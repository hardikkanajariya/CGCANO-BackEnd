<!DOCTYPE html>
<html>
<head>
    <title>Invoice PDF</title>
</head>
<body>
<h1>Invoice</h1>
<p>Invoice Number: {{ $invoiceData['invoiceNumber'] }}</p>
<p>Amount: {{ $invoiceData['amount'] }}</p>
<img src="data:image/png;base64,{{ base64_encode($barcodeImage) }}" alt="Barcode">
</body>
</html>
