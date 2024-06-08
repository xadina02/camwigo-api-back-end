<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{ route('payment.post', ["reservation" => 1]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="route-schedule">Amount</label>
            <input type="number" id="route-schedule" name="amount"> <br>
        </div>
        <button class="btn btn-primary">Submit Payment</button>
    </form>
</body>
</html>