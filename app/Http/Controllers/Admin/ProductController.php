<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product; 
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Handle product creation
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'description' => 'required',
            'company' => 'required|max:255',
            'type' => 'required|max:255',
            'warranty' => 'required|max:255',
            'image' => 'required|image',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = str_replace(' ', '_', strtolower($validatedData['name'])) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->storeAs('product_images', $imageName, 'public');
            $validatedData['image'] = $imagePath;
        }

        // Create the product in the database
        Product::create($validatedData);

        // Redirect back with success message
        return redirect()->route('add-product')->with('success', 'Product added successfully!');
    }

    // Display products (with search functionality)
    public function index(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'like', '%' . $query . '%')
        ->orWhere('description', 'like', '%' . $query . '%')
        ->paginate(10); // 10 products per page

    // Pass the products and query to the view
    return view('auth.Home', [
        'products' => $products,
        'query' => $query
    ]);
    }

    // Show all products
    public function allProduct()
    {
        $products = Product::all();
        return view('admin.discount', compact('products'));
    }

    // Apply discount to a product
    public function applyDiscount(Request $request, $id)
    {
        $request->validate([
            'discount' => 'required|numeric|min:0|max:100',
        ]);

        $product = Product::findOrFail($id);
        $product->discount = $request->input('discount');
        $product->save();

        return redirect()->route('products.index')->with('success', 'Discount applied successfully!');
    }

    // Show orders with 'pending' status
    public function showPendingProducts()
    {
        $orders = Order::whereIn('status', ['pending', 'returning'])->get();
        
        // Fetch the related order items and their associated products
        $orderItems = OrderItem::with('product','user','order')->whereIn('order_id', $orders->pluck('id'))->get();
        
        return view('admin.manage', compact('orderItems', 'orders',));
    }

    // Update order status
    public function updateProductStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,complete,declined,running,returning,returned',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->input('status');
        $order->save();

        return redirect()->route('products.pending')->with('success', 'Order status updated successfully!');
    }

    public function showRunningProducts()
    {
        $orders = Order::where('status', 'running')->get();
        
        // Fetch the related order items and their associated products
        $orderItems = OrderItem::with('product','user','order')->whereIn('order_id', $orders->pluck('id'))->get();
        
        return view('admin.running', compact('orderItems', 'orders',));
    }
    public function updateProductRunningStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,complete,declined,running',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->input('status');
        $order->save();

        return redirect()->route('products.running')->with('success', 'Order status updated successfully!');
    }
    public function showCompleteProducts()
    {
        $orders = Order::where('status', 'complete')->get();
        
        // Fetch the related order items and their associated products
        $orderItems = OrderItem::with('product','user','order')->whereIn('order_id', $orders->pluck('id'))->get();
        
        return view('admin.complete', compact('orderItems', 'orders',));
    }
    public function showDeclinedProducts()
    {
        $orders = Order::where('status', 'declined')->get();
        
        // Fetch the related order items and their associated products
        $orderItems = OrderItem::with('product','user','order')->whereIn('order_id', $orders->pluck('id'))->get();
        
        return view('admin.declined', compact('orderItems', 'orders',));
    }
    public function showReturnedProducts()
    {
        $orders = Order::where('status', 'returned')->get();
        
        // Fetch the related order items and their associated products
        $orderItems = OrderItem::with('product','user','order')->whereIn('order_id', $orders->pluck('id'))->get();
        
        return view('admin.returned', compact('orderItems', 'orders',));
    }

   }
