@php
    use Carbon\Carbon;
    $logoPath = public_path('logo.png');
    $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail IBPR</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 11px;
            color: #333;
            padding: 30px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 3px solid #007BFF;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .logo {
            height: 60px;
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
            margin: 3px 0 0;
            font-size: 13px;
            font-weight: bold;
        }

        .info {
            margin-bottom: 15px;
        }

        .info p {
            margin: 3px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            vertical-align: top;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .text-danger {
            color: red;
            font-weight: bold;
        }

        .footer {
            font-size: 9px;
            text-align: right;
            margin-top: 15px;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <div class="header">
        <img src="{{ $logoBase64 }}" alt="Logo" class="logo">
        <div class="title">
            <h2>IDENTIFIKASI BAHAYA DAN PENILAIAN RISIKO</h2>
            <p>PT Krakatau Sarana Properti</p>
        </div>
    </div>

    <!-- Info -->
    <div class="info">
        <p><strong>Lokasi:</strong> {{ $lokasi->nama_lokasi ?? '-' }}</p>
        <p><strong>Tahun:</strong> {{ $tahun ?? '-' }}</p>
    </div>

    <!-- Tabel IBPR -->
    <table>
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Aktifitas</th>
                <th rowspan="2">Potensi Bahaya</th>
                <th rowspan="2">Dampak K3</th>
                <th rowspan="2">Risiko K3</th>
                <th rowspan="2">R / NR / E</th>
                <th rowspan="2">No. Dampak</th>
                <th colspan="3">Nilai Risiko Awal</th>
                <th rowspan="2">Tingkat Awal</th>
                <th rowspan="2">Pengendalian Saat Ini</th>
                <th colspan="3">Setelah Pengendalian</th>
                <th rowspan="2">Tingkat Akhir</th>
                <th rowspan="2">Peluang</th>
                <th rowspan="2">Peraturan</th>
                <th rowspan="2">Pengendalian Lanjutan</th>
                <th rowspan="2">Status</th>
            </tr>
            <tr>
                <th>L</th>
                <th>C</th>
                <th>Tot</th>
                <th>L</th>
                <th>C</th>
                <th>Tot</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($groupedData as $aktivitasId => $list)
                @foreach ($list as $index => $item)
                    <tr>
                        @if ($index === 0)
                            <td rowspan="{{ $list->count() }}">{{ $no++ }}</td>
                            <td rowspan="{{ $list->count() }}">{{ $item->aktivitas->aktifitas }}</td>
                        @endif
                        <td>{{ $item->potensi_bahaya }}</td>
                        <td>{{ $item->dampak_k3 }}</td>
                        <td>{{ $item->resiko_k3 }}</td>
                        <td>{{ $item->r_n }}</td>
                        <td>{{ $item->no_dampak }}</td>
                        <td>{{ $item->l }}</td>
                        <td>{{ $item->c }}</td>
                        <td>{{ $item->total }}</td>
                        <td>{{ $item->tingkat_risiko }}</td>
                        <td>{{ $item->pengendalian_saat_ini }}</td>
                        <td>{{ $item->l_after }}</td>
                        <td>{{ $item->c_after }}</td>
                        <td>{{ $item->total_after }}</td>
                        <td class="{{ $item->tingkat_risiko_after === 'H' ? 'text-danger' : '' }}">
                            {{ $item->tingkat_risiko_after }}
                        </td>
                        <td>{{ $item->peluang }}</td>
                        <td>{{ $item->peraturan_perundangan }}</td>
                        <td>{{ $item->pengendalian_lanjutan }}</td>
                        <td>{{ ucwords(str_replace('_', ' ', $item->status)) }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i') }}
    </div>

</body>

</html>
