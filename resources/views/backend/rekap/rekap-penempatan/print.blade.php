<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Penempatan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        table th {
            background-color: #f2f2f2;
        }

        .title {
            text-align: center;
            margin-bottom: 20px;
        }

        .title h1 {
            margin: 0;
            font-size: 24px;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="title">
        <h1>Rekap Data Penempatan</h1>
        <h2>Bulan: {{ $month ? date('F', mktime(0, 0, 0, $month, 10)) : 'Semua Bulan' }} Tahun: {{ $year ?? 'Semua Tahun' }}</h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Penempatan</th>
                <th>Gender L</th>
                <th>Gender P</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['jenis_penempatan'] }}</td>
                    <td>{{ $item['gender_l'] }}</td>
                    <td>{{ $item['gender_p'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
