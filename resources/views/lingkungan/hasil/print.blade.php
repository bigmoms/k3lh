@php
    use Carbon\Carbon;
    $logoPath = public_path('logo.png');
    $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Pengukuran Lingkungan Kerja</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            padding: 30px;
            color: #333;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 3px solid #007BFF;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }
        .logo {
            height: 50px;
        }
        .title {
            text-align: right;
        }
        .title h2 {
            margin: 0;
            font-size: 18px;
            color: #007BFF;
        }
        .title p {
            margin: 0;
            font-size: 12px;
            color: #555;
        }
        .meta-table, .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .meta-table td {
            padding: 5px 0;
        }
        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
            text-align: center;
        }
        .data-table th {
            background-color: #f0f0f0;
        }
        .footer {
            margin-top: 40px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ $logoBase64 }}" alt="Logo" class="logo">
        <div class="title">
            <h2>Hasil Pengukuran Lingkungan Kerja</h2>
            <p>Dept Security, Fire & SHE</p>
        </div>
    </div>

    <table class="meta-table">
        <tr>
            <td><strong>Tanggal Pengukuran:</strong> {{ \Carbon\Carbon::parse($jadwal->tanggal_pengukuran)->translatedFormat('d F Y') }}</td>
        </tr>
    </table>

    @foreach ($jadwal->lokasi as $lokasi)
        <h4>Lokasi: {{ $lokasi->nama_lokasi }}</h4>
        <table class="data-table">
            <thead>
                <tr>
                    <th rowspan="2">Divisi</th>
                    <th colspan="4">Cahaya (Lux)</th>
                    <th colspan="4">Suhu (°C)</th>
                    <th colspan="4">Kelembaban (%)</th>
                    <th colspan="4">Kebisingan (dB)</th>
                    <th rowspan="2">Catatan</th>
                </tr>
                <tr>
                    @foreach(range(1, 3) as $i)<th>{{ $i }}</th>@endforeach <th>Rata²</th>
                    @foreach(range(1, 3) as $i)<th>{{ $i }}</th>@endforeach <th>Rata²</th>
                    @foreach(range(1, 3) as $i)<th>{{ $i }}</th>@endforeach <th>Rata²</th>
                    @foreach(range(1, 3) as $i)<th>{{ $i }}</th>@endforeach <th>Rata²</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lokasi->divisis as $divisi)
                    @php $hasil = $pengukurans[$divisi->id]->first() ?? null; @endphp
                    <tr>
                        <td>{{ $divisi->nama_divisi }}</td>
                        @foreach(['cahaya','suhu','kelembaban','kebisingan'] as $param)
                            @foreach(range(1,3) as $i)
                                <td>{{ $hasil?->{$param . '_' . $i} ?? '-' }}</td>
                            @endforeach
                            <td>{{ $hasil?->{$param . '_rata2'} ?? '-' }}</td>
                        @endforeach
                        <td>{{ $hasil?->catatan ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

    <div class="footer">
        <strong>Tanggal Dicetak:</strong> {{ now()->format('d-m-Y H:i') }}<br>
        <strong>Dibuat oleh:</strong> Tim SHE
    </div>
</body>
</html>
