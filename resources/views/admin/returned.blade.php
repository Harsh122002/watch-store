<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Returned Products</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .status-select {
            width: 60px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2>Declined Orders</h2>

        <!-- Success message -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Display message if no pending products -->
        @if ($orderItems->isEmpty())
            <p>No pending products found.</p>
        @else
            <!-- Display pending products in a table -->
            <table class="table table-bordered w-12">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product Name</th>
                        <th>User Name</th>
                        <th>Mobile No.</th>
                        <th>Address</th>
                        <th>Payment Type</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Grand Total</th>
                        <th>Current Status</th>
                        <th>Date</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($orderItems as $item)
                        <tr>
                            <td>{{ $item->order->id }}</td>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->order->user->name }}</td>
                            <td>{{ $item->order->user->phone }}</td>
                            <td>{{ $item->order->address }}</td>
                            <td>{{ ucfirst($item->order->payment_type) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rs.{{ number_format($item->product->price, 2) }}</td>
                            <td>Rs.{{ number_format($item->order->grand_total, 2) }}</td>
                            <td>{{ ucfirst($item->order->status) }}</td>
                            <td> {{ $item->created_at->format('d M Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('admin-home') }}" class="btn btn-secondary">Back</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
