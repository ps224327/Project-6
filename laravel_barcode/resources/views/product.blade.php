<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


@foreach($products as $product)
{!!DNS1D::getBarcodeHTML('223144', 'UPCA')!!}


@endforeach
</body>
</html>

