<!DOCTYPE html>
<html>
<head>
    <title>Barcodes</title>
</head>
<body>
    <div>
        @foreach($barcodes as $barcode)
            {!! $barcode !!}
            <br>
        @endforeach
    </div>
</body>
</html>