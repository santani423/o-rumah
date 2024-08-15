<!DOCTYPE html>
<html>
<head>
    <title>QR Code</title>
</head>
<body>
    <h1>Generated QR Code</h1>
    <div>
        {!! $qrcode !!}
    </div>
    <br>
    <a href="{{ route('qrcode.download') }}">
        <button>Download QR Code</button>
    </a>
    <br>
    <a href="{{ route('qrcode.generateWithLogo') }}">
        <button>Download QR Code with Logo</button>
    </a>
</body>
</html>
