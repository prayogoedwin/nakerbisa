<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail AK1</title>
</head>

<body>
    <h1>Detail AK1</h1>
    <p><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::parse($ak1->tanggal_cetak)->locale('id')->translatedFormat('d F Y') }}</p>
    <p><strong>Status Cetak:</strong> {{ $ak1->status_cetak == '0' ? 'Mandiri' : 'Admin' }}</p>
    <p><strong>Berhenti Berlaku:</strong> {{ \Carbon\Carbon::parse($ak1->berlaku_hingga)->locale('id')->translatedFormat('d F Y') }}</p>
    <p><strong>QR Code:</strong></p>
    <img src="{{ asset('storage/' . $ak1->qr) }}" alt="QR Code">
</body>

</html>
