@extends('layouts.app')

@section('content')
    <div class="container" style="min-height: 700px">

        <h1 class="h1 text-white">Cart</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (empty($cart))
            <p class="text-white" style="margin-bottom: 0px;padding-bottom: 20px;font-size: 30px">Your cart is empty.</p>
        @else
            <div class="table-responsive"> <!-- Responsive wrapper -->
                <table class="table text-white">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="img-fluid" style="max-width: 100px; height: auto;">
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>Rs.{{ $product->price }}</td>
                                <td>
                                    <form action="{{ route('cart.update', $product->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="input-group">
                                            <button type="submit" name="action" value="decrease"
                                                class="btn btn-outline-danger btn-sm">-</button>
                                            <input type="text" name="quantity" value="{{ $cart[$product->id] }}"
                                                class="form-control text-center" style="max-width: 50px;" readonly>
                                            <button type="submit" name="action" value="increase"
                                                class="btn btn-outline-success btn-sm">+</button>
                                        </div>
                                    </form>
                                </td>
                                <td>Rs.{{ $product->price * $cart[$product->id] }}</td>
                                <td>
                                    <form action="{{ route('cart.remove', $product->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-end">Total</td>
                            <td>Rs.{{ $products->sum(fn($product) => $product->price * $cart[$product->id]) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end">SGST (5%)</td>
                            <td>Rs.{{ $products->sum(fn($product) => $product->price * $cart[$product->id]) * 0.05 }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end">CGST (5%)</td>
                            <td>Rs.{{ $products->sum(fn($product) => $product->price * $cart[$product->id]) * 0.05 }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end">Delivery charges
                                ({{ $products->sum(fn($product) => $product->price * $cart[$product->id]) > 150 ? 0 : 50 }})
                            </td>
                            <td>Rs.{{ $products->sum(fn($product) => $product->price * $cart[$product->id]) > 150 ? 0 : 50 }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end">Grand Total</td>
                            <td>Rs.{{ $products->sum(fn($product) => $product->price * $cart[$product->id]) + $products->sum(fn($product) => $product->price * $cart[$product->id]) * 0.05 + $products->sum(fn($product) => $product->price * $cart[$product->id]) * 0.05 + ($products->sum(fn($product) => $product->price * $cart[$product->id]) > 150 ? 0 : 50) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif
        <a href="{{ route('home') }}" class="btn btn-secondary">Back</a>
        @if (session('cart') && count(session('cart')) > 0)
            <div class="container mt-5">
                <div class="text-center">
                    <a href="{{ route('order.place') }}" class="btn btn-primary mb-4">Order Now</a>
                </div>
            </div>
        @endif

    </div>
@endsection
