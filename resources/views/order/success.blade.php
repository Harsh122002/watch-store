<!-- resources/views/order/success.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mt-8" style="min-height: 615px">
        <div class="alert alert-success">
            <h4 class="alert-heading">Success!</h4>
            <p>Your order ID is: {{ session('order_id') }}</p>
            <p>Your order has been placed successfully.</p>
        </div>
        <a href="{{ route('home') }}" class="btn btn-primary">Go to Home</a>
        <a href="{{ route('order.pdf', ['id' => session('order_id')]) }}" class="btn btn-primary">Generate PDF</a>
        <a href="{{ route('order.orderStatus') }}" class="btn btn-primary">Order Status</a>

    </div>
@endsection
