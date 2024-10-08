@extends('layouts.app')

@section('content')
    <div class="container pb-4">
        <h2 class="text-white">Order Status</h2>
        <a href="{{ route('home') }}" class="btn btn-secondary mb-1">Back</a>

        @foreach ($allOrders as $order)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Order {{ $order->id }}</h5>
                    <p><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</p>

                    <p><strong>User Name:</strong> {{ $order->user ? $order->user->name : 'N/A' }}</p>
                    @foreach ($order->orderItems as $item)
                        <div class="mb-2">
                            <p><strong>Product Name:</strong> {{ $item->product ? $item->product->name : 'N/A' }}</p>
                            <p><strong>Quantity:</strong> {{ $item->quantity }}</p>

                            <p><strong>Price:</strong> Rs.{{ number_format($item->product->price, 2) }}</p>
                            <p><strong>Description:</strong> {{ $item->product->description }}</p>
                            <p><strong>Discount:</strong> {{ $item->product->Discount ?? 'N/A' }}</p>
                            <p><strong>Company:</strong> {{ $item->product->company }}</p>
                            <p><strong>Type:</strong> {{ $item->product->type }}</p>
                            <p><strong>Warranty:</strong> {{ $item->product->warranty }}</p>
                            <p><strong>Image:</strong> <img src="{{ asset('storage/' . $item->product->image) }}"
                                    alt="{{ $item->product->name }}" style="max-width: 100px;"></p>
                        </div>
                    @endforeach
                    <p><strong>Total:</strong> Rs.{{ number_format($order->total, 2) }}</p>
                    <p><strong>CGST:</strong> Rs.{{ number_format($order->cgst, 2) }}</p>
                    <p><strong>SGST:</strong> Rs.{{ number_format($order->sgst, 2) }}</p>
                    <p><strong>Grand Total:</strong> Rs. {{ number_format($order->grand_total, 2) }}</p>
                    <p><strong>Delivery Charge:</strong> Rs.{{ number_format($order->delivery_charge, 2) }}</p>
                    <p><strong>Discount:</strong> Rs.{{ number_format($order->discount, 2) }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>

                    @if ($order->status == 'pending')
                        <button class="btn btn-danger" onclick="cancelOrder({{ $order->id }})">Cancel Order</button>
                    @elseif($order->status == 'declined')
                        <button class="btn btn-secondary" disabled>Order Declined</button>
                    @elseif($order->status == 'complete' && $order->isWithinReturnWindow())
                        <button class="btn btn-warning" onclick="showReturnDialog({{ $order->id }})">Return
                            Order</button>
                    @elseif($order->status == 'returning')
                        <p class="text-info">Order is being returned</p>
                    @elseif($order->status == 'returned')
                        <p class="text-info">Order has been returned</p>
                    @endif
                </div>
            </div>
        @endforeach

        <!-- Return Dialog Modal -->
        <div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="returnForm" method="POST" action="{{ route('order.return') }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="returnModalLabel">Return Order</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="orderId" name="order_id" value="">
                            <div class="mb-3">
                                <label for="bankName" class="form-label">Bank Name</label>
                                <input type="text" class="form-control" id="bankName" name="bank_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="accountNumber" class="form-label">Account Number</label>
                                <input type="text" class="form-control" id="accountNumber" name="account_number"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="ifscCode" class="form-label">IFSC Code</label>
                                <input type="text" class="form-control" id="ifscCode" name="ifsc_code" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script>
        // Function to handle cancel order
        function cancelOrder(orderId) {
            if (confirm('Are you sure you want to cancel this order?')) {
                window.location.href = `/order/cancel/${orderId}`;
            }
        }

        // Function to show the return dialog
        function showReturnDialog(orderId) {
            document.getElementById('orderId').value = orderId;
            new bootstrap.Modal(document.getElementById('returnModal')).show();
        }
    </script>
@endsection
