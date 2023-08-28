<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Package Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .invoice {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .info {
            margin-bottom: 20px;
        }
        .info p {
            margin: 5px 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th,
        .table td {
            border: 1px solid #ccc;
            padding: 8px;
        }
        .total {
            text-align: right;
        }
    </style>
</head>
<body>
<div class="invoice">
    <div class="header">
        <h1>Membership Invoice</h1>
        @php
            $paddedOrderId = str_pad($invoiceData['order_id'], 5, '0', STR_PAD_LEFT);
            $invoiceNumber = "INV-" . $paddedOrderId;
        @endphp
        <p>Order ID: #{{ $invoiceNumber }}</p>
    </div>
    <div class="info">
        <p><strong>Full Name:</strong> {{ $invoiceData['fullname'] }}</p>
        <p><strong>Email:</strong> {{ $invoiceData['email'] }}</p>
        <p><strong>Phone:</strong> {{ $invoiceData['phone'] }}</p>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Quantity</th>
            <th>Total Amount</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{$invoiceData['package_name']}}</td>
            <td>1</td>
            <td>{{ $invoiceData['total_amount'] }}</td>
        </tr>
        </tbody>
    </table>
    <div class="total">
        <p><strong>Total Amount:</strong> {{ $invoiceData['total_amount'] }}</p>
    </div>
    <br>
    <br>
    <br>
    <p>You Can Download your Invoice from your Profile Page. <a href="http://localhost:3000/auth/profile">Click Here</a>
    </p>
    <br>
    <br>
    <br>
    <p>Thank you for your business.</p>
    <p>Regards,</p>
    <p>CGCANO Team.</p>
    <p style="font-size: 8px;">Note: This is a computer generated invoice and does not require physical signature.</p>
</div>
</body>
</html>
