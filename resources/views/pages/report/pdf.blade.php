<!-- resources/views/report/pdf.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Report Results</h1>
    @if(!empty($orders) && $orders->count())
    <table>
        <thead>
            <tr>
                <th>ID Order</th>
                <th>Total Price</th>
                <th>Total Item</th>
                <th>Kasir</th>
                <th>Transaction Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->total_price }}</td>
                <td>{{ $order->total_item }}</td>
                <td>{{ $order->kasir->name }}</td>
                <td>{{ $order->transaction_time }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No orders found for the selected period.</p>
    @endif
</body>
</html>
