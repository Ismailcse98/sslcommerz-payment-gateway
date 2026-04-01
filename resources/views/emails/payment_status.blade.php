<!DOCTYPE html>
<html>
<head>
    <title>Payment Status</title>
</head>
<body>
    <h2>{{ $message_text }}</h2>
    <p>Transaction ID: {{ $tran_id }}</p>
    <p>Amount: {{ $amount }} {{ $currency }}</p>
    <p>Status: {{ $status }}</p>
    <p>Thank you for using our service!</p>
</body>
</html>