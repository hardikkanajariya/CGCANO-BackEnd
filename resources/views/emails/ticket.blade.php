<!DOCTYPE html>
<html lang="en">
<head>
    <title>Ticket Details</title>
</head>
<body>
<p>Hello, {{$fullname}}</p>
<p>Thank you for Purchasing Ticket :)</p>
<img src="{{url('/')}}/flyer/temp.jpg" alt="Ticket Flyer">
<p>Download your ticket from here <a href="{{url('/')}}/{{$invoice_path}}">Download Ticket</a></p>
</body>
</html>
