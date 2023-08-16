
<!DOCTYPE html>
<html>
<head>
    <title>Event Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .invoice-container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-title {
            font-size: 24px;
            color: #333;
        }
        .invoice-details {
            font-size: 16px;
            color: #555;
            margin-bottom: 10px;
        }
        .invoice-data {
            font-weight: bold;
        }
        .ticket {
            text-align: center;
            padding: 20px;
            background-color: #f0f0f0;
            border-radius: 10px;
            margin-top: 20px;
        }
        .ticket-title {
            font-size: 20px;
            color: #333;
            margin-bottom: 10px;
        }
        .ticket-info {
            font-size: 16px;
            color: #555;
        }
    </style>
</head>
<body>
<div class="invoice-container">
    <div class="invoice-header">
        <div class="invoice-title">Event Invoice</div>
        <div class="invoice-details">
            Invoice Number: <span class="invoice-data">{{ $invoiceData['invoiceNumber'] }}</span><br>
            Amount: <span class="invoice-data">${{ $invoiceData['amount'] }}</span><br>
            Name: <span class="invoice-data">{{ $invoiceData['name'] }}</span><br>
            Time: <span class="invoice-data">{{ $invoiceData['time'] }}</span><br>
            Title: <span class="invoice-data">{{ $invoiceData['title'] }}</span>
        </div>
    </div>

    <div class="ticket">
        <div class="ticket-title">Event Ticket</div>
        <img src="data:image/png;base64,{{ base64_encode($barcodeImage) }}" alt="Event Barcode" style="max-width: 100%;">
{{--        <img src="data:image/png;base64,{{ ($barcodeImage) }}" alt="Barcode">--}}
        <div class="ticket-info">
            Please present this ticket at the event entrance for entry.
        </div>
    </div>
</div>
</body>
</html>
