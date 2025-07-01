<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanda Terima Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .info-section {
            margin-bottom: 20px;
        }

        .info-section p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
            font-size: 14px;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }

        .signature {
            text-align: center;
            width: 45%;
        }

        .signature p {
            margin: 0;
            font-size: 14px;
            color: #555;
        }

        .signature strong {
            display: block;
            margin-top: 10px;
            font-size: 16px;
            color: #333;
        }

        .signature .line {
            margin-top: 20px;
            border-bottom: 1px solid #000;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
        }

        .button-group {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .print-button,
        .back-button {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 10px;
        }

        .print-button {
            background-color: #007bff;
        }

        .back-button {
            background-color: #f3ca42;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        @media print {
            body * {
                visibility: hidden;
                background: none;
            }

            .print-container,
            .print-container * {
                visibility: visible;
            }

            .print-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .print-button,
            .back-button {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="print-container">
        <!-- Tanda Terima 1 -->
        <div class="container">
            <h1>TANDA TERIMA KELUAR BARANG</h1>

            <div class="info-section">
                <p style="text-align: justify">Berikut adalah informasi tentang barang yang diterima pada tanggal
                    {{ $transaction->created_at->format('d M Y') }}, dengan
                    rincian sebagai berikut:</p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Kondisi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaction->details as $detail)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $detail->inventory->name }}</td>
                        <td>{{ $detail->quantity }} {{ $detail->inventory->unit }}</td>
                        <td>{{ $detail->condition }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="signature-section">
                <div class="signature">
                    <p>Mengetahui,</p>
                    <div class="line"></div>
                    <strong>{{ auth()->user()->name }}</strong>
                    <p>{{ auth()->user()->roles[0]->name }}</p>
                </div>
                <div class="signature">
                    <p>Penerima Barang,</p>
                    <div class="line"></div>
                    <strong>{{ $transaction->is_group ? $transaction->supervisor->name : $transaction->employee->name }}</strong>
                    <p>{{ $transaction->is_group ? $transaction->supervisor->roles[0]->name : $transaction->employee->position->name }}</p>
                </div>
            </div>
        </div>

        <!-- Tanda Terima 2 (hanya muncul saat cetak) -->
        <div class="container">
            <h1>TANDA TERIMA KELUAR BARANG</h1>

            <div class="info-section">
                <p style="text-align: justify">Berikut adalah informasi tentang barang yang diterima pada tanggal
                    {{ $transaction->created_at->format('d M Y') }}, dengan
                    rincian sebagai berikut:</p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Kondisi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaction->details as $detail)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $detail->inventory->name }}</td>
                        <td>{{ $detail->quantity }} {{ $detail->inventory->unit }}</td>
                        <td>{{ $detail->condition }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="signature-section">
                <div class="signature">
                    <p>Mengetahui,</p>
                    <div class="line"></div>
                    <strong>{{ auth()->user()->name }}</strong>
                    <p>{{ auth()->user()->roles[0]->name }}</p>
                </div>
                <div class="signature">
                    <p>Penerima Barang,</p>
                    <div class="line"></div>
                    <strong>{{ $transaction->is_group ? $transaction->supervisor->name : $transaction->employee->name }}</strong>
                    <p>{{ $transaction->is_group ? $transaction->supervisor->roles[0]->name : $transaction->employee->position->name }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="button-group">
        <button class="print-button" onclick="window.print()">Print</button>
        <a href="{{ route('inventory.outbound') }}" class="back-button">Back</a>
    </div>

</body>

</html>
