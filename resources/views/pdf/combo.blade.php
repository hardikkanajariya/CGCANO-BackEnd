<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Event Combo Ticket & Invoice</title>
    <style>@import url(https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap);

        body {
            font-family: Poppins, sans-serif;
            background: #f1f1f1
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            display: flex;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, .1)
        }

        .invoice {
            flex: 1;
            padding-right: 40px
        }

        .invoice h1 {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 15px
        }

        .invoice p {
            font-size: 16px;
            line-height: 1.5;
            color: #555
        }

        .invoice p span {
            font-weight: 500
        }

        .ticket {
            flex: 1;
            background: linear-gradient(135deg, #e2e8f0, #f7fafc);
            border-radius: 20px;
            padding: 30px;
            text-align: center
        }

        .ticket h1 {
            font-size: 28px;
            font-weight: 500;
            margin-bottom: 15px
        }

        .barcode img {
            max-width: 80%;
            margin-bottom: 15px
        }

        .ticket p {
            font-size: 14px;
            line-height: 1.5;
            color: #666
        }</style>
</head>
<body>
<div class="container">
    <div class="invoice"><h1>Combo Ticket Invoice</h1>
        <p>Invoice Number:<span>{{ $invoiceData['invoiceNumber'] }}</span></p>
        <p>Amount:<span>${{ $invoiceData['amount'] }}</span></p>
        <p>Name:<span>{{ $invoiceData['name'] }}</span></p>
        <p>Title:<span>{{ $invoiceData['title'] }}</span></p>
    </div>
    <div class="ticket">
        <h1>Download your Event Tickets from here</h1>
        @foreach($events as $data)
            <div class="barcode" style="margin-bottom: 20px;">
                <a href="{{url('/')}}/invoice/combo/">Download <b style="color: red;">{{$data->title}}</b> Ticket</a>
            </div>
        @endforeach
        <p>Please present this ticket at the event entrance for entry. Enjoy the show!</p>
    </div>
</div>
</body>
</html>
