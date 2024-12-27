<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        h2 {
            margin: 0;
            font-size: 14px;
            font-weight: normal;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        .penghasilan-bulanan {
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <!-- Header with Store Name -->
    <div class="header">
        <h1>TOKO ADIT SEMBAKO</h1>
        <h2>Laporan Transaksi</h2>
    </div>
    
    <!-- Laporan Transaksi Table -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Transaksi</th>
                <th>Kasir</th>
                <th>Status</th>
                <th>Total Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->created_at }}</td>
                <td>{{ $item->kasir_name }}</td>
                <td>{{ $item->status }}</td>
                <td>{{ 'Rp. ' . number_format($item->total, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Penghasilan Bulanan Table -->
    <div class="penghasilan-bulanan">
        <h3>Penghasilan Bulanan</h3>
        <table>
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th>Total Penghasilan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penghasilanBulanan as $item)
                <tr>
                    <td>{{ $item->bulan }}</td>
                    <td>{{ 'Rp. ' . number_format($item->total_penghasilan, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>
