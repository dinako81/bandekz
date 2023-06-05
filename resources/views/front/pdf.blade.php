<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order {{$order->id}}</title>
</head>
<body>
    <style>
        body {
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            height: 200px;
            text-align: center;
            font-size: 30px;
            letter-spacing: 3px;
            color: white;
        }

    </style>

</body>
<h1> Invoice</h1>
<table>

    @foreach($order->hotels as $hotel)
    <div class="front-order-hotels-list">
        <span>Hotel Title: {{$hotel['title']}}</span>
        <i>Price: {{$hotel['price']}} eur</i>
        X
        <i>Holiday duration: {{$hotel['count']}} days </i>

    </div>

    @endforeach

    <div class="front-order-hotels-list">
        <b>Total price: {{$order->price}} eur</b>
    </div>


</table>

</html>
