<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;


class CartController extends Controller
{
    public function add(Request $request)
{
    // Validate the request data
    $validatedData = $request->validate([
        'product_id' => 'required|integer|exists:products,id',  // Ensure product_id exists in the database
        'quantity' => 'required|integer|min:1|max:4',  // Ensure quantity is between 1 and 4
    ]);

    $productId = $validatedData['product_id'];
    $requestedQuantity = $validatedData['quantity'];

    // Retrieve the product from the database
    $product = Product::findOrFail($productId);

    // Check if the requested quantity is available in stock
    if ($requestedQuantity > $product->quantity) {
        // Redirect back with an error if the requested quantity exceeds available stock
        return redirect()->back()->withErrors([
            'quantity' => 'The requested quantity exceeds the available stock. Only ' . $product->quantity . ' items are available.'
        ]);
    }

    // Initialize the cart if not already set
    if (!Session::has('cart')) {
        Session::put('cart', []);
    }

    $cart = Session::get('cart');

    // Add or update the quantity in the cart
    if (isset($cart[$productId])) {
        $newQuantity = $cart[$productId] + $requestedQuantity;
        
        // Ensure the updated quantity does not exceed available stock
        if ($newQuantity > $product->quantity) {
            return redirect()->back()->withErrors([
                'quantity' => 'The total quantity in the cart exceeds available stock. You already have ' . $cart[$productId] . ' items in the cart, and only ' . $product->quantity . ' are available.'
            ]);
        }

        $cart[$productId] = $newQuantity;
    } else {
        $cart[$productId] = $requestedQuantity;
    }

    // Store the updated cart in the session
    Session::put('cart', $cart);

    // Update the total item count in the cart
    $cartItemCount = array_sum($cart);
    Session::put('cartItemCount', $cartItemCount);

    // Redirect to the home page
    return redirect()->route('home');
}

    public function index()
    {
        $cart = Session::get('cart', []);
        $products = Product::whereIn('id', array_keys($cart))->get();

        $cartItemCount = array_sum($cart);

        return view('cart.index', compact('products', 'cart', 'cartItemCount'));
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        $cartItemCount = array_sum($cart);
        session()->put('cartItemCount', $cartItemCount);

        return redirect()->route('cart.index')->with('success', 'Product removed successfully.');
    }
    public function update(Request $request, $id)
{
    $action = $request->input('action');
    $cart = session()->get('cart', []);
    
    if (!isset($cart[$id])) {
        return redirect()->route('cart.index')->with('error', 'Product not found in cart.');
    }
    
    $quantity = $cart[$id];

    
    if ($action === 'increase' && $quantity < 4) {
        $quantity++;
    } elseif ($action === 'decrease' && $quantity > 1) {
        $quantity--;
    }

    $cart[$id] = $quantity;
    session()->put('cart', $cart);

    $cartItemCount = array_sum($cart);
    session()->put('cartItemCount', $cartItemCount);

    return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
}

}
