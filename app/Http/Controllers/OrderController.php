<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use \PDF;


class OrderController extends Controller
{
    public function submitOrder(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'address' => 'required|string',
            'phone' => 'required|string',
            'payment_type' => 'required|string',
            'order_id' => 'required|string',
            'razorpay_payment_id' => 'nullable|string',
            'razorpay_order_id' => 'nullable|string',
            'razorpay_signature' => 'nullable|string',
        ]);
    
        // Get cart items from the session
        $cart = Session::get('cart', []);
    
        // Check if the cart is empty
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }
    
        // Calculate total price
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get();
        $total = $products->sum(function ($product) use ($cart) {
            return $product->price * $cart[$product->id];
        });
    
        // Calculate SGST, CGST, and delivery
        $sgst = $total * 0.05;
        $cgst = $total * 0.05;
        $delivery = $total > 150 ? 0 : 50;
        $grandTotal = $total + $sgst + $cgst + $delivery;
    
        // Verify payment if payment type is online
        if ($request->payment_type == 'online') {
            $request->validate([
                'razorpay_payment_id' => 'nullable|string',
                'razorpay_order_id' => 'nullable|string',
                'razorpay_signature' => 'nullable|string',
            ]);
    
            $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));
    
            try {
                // Verify Razorpay payment signature
               
                // Create a new order
                $order = new Order();
                $order->user_id = Auth::id();
                $order->order_id = $request->order_id;
                $order->address = $request->address;
                $order->phone = $request->phone;
                $order->payment_type = $request->payment_type;
                $order->total = $total;
                $order->sgst = $sgst;
                $order->cgst = $cgst;
                $order->delivery = $delivery;
                $order->grand_total = $grandTotal;
                $order->save();
    
                // Create order items and update product stock
                foreach ($cart as $productId => $quantity) {
                    $product = Product::find($productId);
    
                    if ($product) {
                        $product->quantity -= $quantity;
                        $product->save();
    
                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $product->id,
                            'quantity' => $quantity,
                            'price' => $product->price,
                        ]);
                    }
                }
    
                // Clear the cart
                Session::forget('cart');
                Session::put('cartItemCount', 0);
                Session::put('order_id', $order->id);

    
                // Redirect to success page with a success message
                return redirect()->route('order.success')->with([
                    'success' => 'Order placed successfully!',
                    'order_id' => $order->order_id
                ]);            } catch (\Exception $e) {
                // Log the exception details for debugging
                Log::error('Payment verification failed: ' . $e->getMessage());
            
                // Redirect back with an error message
                return redirect()->back()->with('error', 'Payment verification failed. Please try again.');
            }
        } else {
            // Create order for cash payment
            $order = new Order();
            $order->user_id = Auth::id();
            $order->order_id = $request->order_id;
            $order->address = $request->address;
            $order->phone = $request->phone;
            $order->payment_type = $request->payment_type;
            $order->total = $total;
            $order->sgst = $sgst;
            $order->cgst = $cgst;
            $order->delivery = $delivery;
            $order->grand_total = $grandTotal;
            $order->save();
    
            // Create order items and update product stock
            foreach ($cart as $productId => $quantity) {
                $product = Product::find($productId);
    
                if ($product) {
                    $product->quantity -= $quantity;
                    $product->save();
    
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $product->price,
                    ]);
                }
            }
    
            // Clear the cart
            Session::forget('cart');
            Session::put('cartItemCount', 0);
            Session::put('order_id', $order->id);

            return redirect()->route('order.success')->with([
                'success' => 'Order placed successfully!',
                'order_id' => $order->order_id
            ]);
        }
    }
    

    public function orderSuccess()
    {
        return view('order.success');
    }

    public function orderView()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get();

        $total = $products->sum(function ($product) use ($cart) {
            return $product->price * $cart[$product->id];
        });

        $sgst = $total * 0.05;
        $cgst = $total * 0.05;
        $delivery = $total > 150 ? 0 : 50;
        $orderTotal = $total + $sgst + $cgst + $delivery;

        return view('order.orderplace', compact('products', 'cart', 'total', 'sgst', 'cgst', 'delivery', 'orderTotal'));
    }
    public function generatePdf($id)
    {
        Log::info('Generating PDF for Order ID: ' . $id);
    
        // Fetch the order details from the database
        $order = Order::with('user')->where('order_id', $id)->first();
    
        if (!$order) {
            Log::error('Order not found for ID: ' . $id);
            abort(404, 'Order not found');
        }
    
        // Retrieve the order ID
        $orderId = $order->id;
    
        // Fetch related order items and their associated products
        $orderItems = OrderItem::with('product')->where('order_id', $orderId)->get();
    
        if ($orderItems->isEmpty()) {
            Log::warning('No order items found for Order ID: ' . $orderId);
        }
    
        // Log the order details
        Log::info('Order Details: ', $order->toArray());
        Log::info('Order Items with Products: ', $orderItems->toArray());
    
        try {
            // Load a Blade view and pass the data
            $pdf = PDF::loadView('orderPdf.pdf', compact('order', 'orderItems'));
    
            // Download the PDF when the user clicks the button
            return $pdf->download('order_' . $order->order_id . '.pdf');
        } catch (\Exception $e) {
            Log::error('Error generating PDF: ' . $e->getMessage());
            abort(500, 'Error generating PDF');
        }
    }
    public function orderStatus()
{
    // Fetching all orders, ordered by status, with related user and product information
    $allOrders = Order::with(['user', 'orderItems.product'])
        ->orderByRaw("
            CASE 
                WHEN status = 'pending' THEN 1 
                WHEN status = 'running' THEN 2 
                WHEN status = 'complete' THEN 3 
                WHEN status = 'declined' THEN 4 
                ELSE 5 
            END
        ")
        ->get();

    // Logging the fetched orders and their items
    Log::info('Fetched Orders:', ['orders' => $allOrders]);

    // Returning the view with all orders and related order items
    return view('order.orderStatus', compact('allOrders'));
}
    
public function cancelOrder($orderId) {
    // Find the order by ID
    $order = Order::find($orderId);
    
    if (!$order) {
        return redirect()->back()->with('error', 'Order not found.');
    }

    // Update the order status to 'declined'
    $order->status = 'declined';
    
    // Retrieve order items associated with this order
    $orderItems = OrderItem::where('order_id', $orderId)->get();
    
    // Update product quantities
    foreach ($orderItems as $item) {
        $product = Product::find($item->product_id);
        
        if ($product) {
            // Increase the product quantity by the quantity in the order
            $product->quantity += $item->quantity;
            $product->save();
        }
    }
    
    // Save the order status change
    $order->save();
    
    // Redirect back with a success message
    return redirect()->back()->with('message', 'Order has been cancelled and product quantities have been updated.');
}

    
    public function returnOrder(Request $request) {
        $order = Order::find($request->order_id);
        $order->status = 'returning';
        
        // Save bank details (Optional)
        $order->bank_name = $request->bank_name;
        $order->account_number = $request->account_number;
        $order->ifsc_code = $request->ifsc_code;
    
        $order->save();
    
        return redirect()->back()->with('message', 'Return process initiated. Status changed to returning.');
    }
    


    
}
