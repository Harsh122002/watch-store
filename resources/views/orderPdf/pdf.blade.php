<!DOCTYPE html>
<html>

<head>
    <title>Order Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            margin: 0 0 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .summary {
            margin-top: 20px;
            text-align: right;
        }
    </style>
</head>

<body>
    <h1>Order Invoice</h1>

    <p><strong>Order ID:</strong> {{ $order->order_id }}</p>
    <p><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
    <p><strong>Customer Name:</strong> {{ $order->user->name ?? 'N/A' }}</p>
    <p><strong>Address:</strong> {{ $order->address }}</p>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderItems as $item)
                <tr>
                    <td>{{ $item->product->name ?? 'Unknown Product' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 2) }}</td>
                    <td>{{ number_format($item->quantity * $item->price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <p><strong>Subtotal:</strong> {{ number_format($order->total, 2) }}</p>
        <p><strong>SGST (5%):</strong> {{ number_format($order->sgst, 2) }}</p>
        <p><strong>CGST (5%):</strong> {{ number_format($order->cgst, 2) }}</p>
        <p><strong>Delivery:</strong> {{ number_format($order->delivery, 2) }}</p>
        <p><strong>Grand Total:</strong> {{ number_format($order->grand_total, 2) }}</p>
    </div>
</body>

</html>
