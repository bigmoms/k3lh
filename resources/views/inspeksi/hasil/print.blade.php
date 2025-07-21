@php
    use Carbon\Carbon;
    $logoPath = public_path('logo.png');
    $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Form Tindak Lanjut Inspeksi</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            padding: 30px;
            color: #333;
            background: #fff;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
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
            text-transform: uppercase;
        }

        .meta-table,
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .meta-table td {
            padding: 5px 0;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        .data-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: left;
        }

        .footer {
            margin-top: 40px;
            font-size: 12px;
        }

        .form-tindaklanjut {
            margin-top: 30px;
        }

        .form-tindaklanjut h3 {
            margin-bottom: 10px;
            font-size: 14px;
            color: #007BFF;
        }

        .form-table {
            width: 100%;
            border-collapse: collapse;
        }

        .form-table th,
        .form-table td {
            border: 1px solid #aaa;
            padding: 8px;
        }

        .form-table th {
            background-color: #f9f9f9;
            text-align: left;
        }

        .ttd {
            margin-top: 30px;
            text-align: right;
        }

        .line {
            border-bottom: 1px dotted #888;
            height: 20px;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ $logoBase64 }}" alt="Logo" class="logo">
        <div class="title">
            <h2>Form Tindak Lanjut Hasil Inspeksi</h2>
            <p>Dept Security, Fire & SHE</p>
        </div>
    </div>

    <table class="meta-table">
        <tr>
            <td><strong>Lokasi / Divisi:</strong> {{ $jadwal->divisiInspeksi->nama_divisi ?? '-' }}</td>
            <td style="text-align: right;"><strong>Tanggal Inspeksi:</strong>
                {{ tanggalIndo($jadwal->tanggal_inspeksi) }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 18%;">Hasil Inspeksi</th>
                <th style="width: 12%;">Gambar</th>
                <th style="width: 15%;">Saran Perbaikan</th>
                <th style="width: 10%;">Target Selesai</th>
                <th style="width: 8%;">Status</th>
                <th style="width: 12%;">Foto Perbaikan</th>
                <th style="width: 17%;">Catatan Perbaikan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($jadwal->hasilInspeksi as $hasil)
                @forelse ($hasil->tindakLanjut as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $hasil->hasil_inspeksi }}</td>
                        <td>
                            @if ($hasil->hasil_gambar && file_exists(public_path('storage/' . $hasil->hasil_gambar)))
                                @php
                                    $path = public_path('storage/' . $hasil->hasil_gambar);
                                    $type = pathinfo($path, PATHINFO_EXTENSION);
                                    $data = file_get_contents($path);
                                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                @endphp
                                <img src="{{ $base64 }}" width="80">
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $item->saran_perbaikan }}</td>
                        <td>{{ $item->target_penyelesaian ? tanggalIndo($item->target_penyelesaian) : '-' }}</td>
                        <td>
                            @php
                                $status = match ($item->status) {
                                    'selesai', 1 => 'Selesai',
                                    'proses', 0 => 'Belum',
                                    default => ucfirst($item->status),
                                };
                            @endphp
                            {{ $status }}
                        </td>

                        <td>
                            @if ($item->foto_perbaikan && file_exists(public_path('storage/' . $item->foto_perbaikan)))
                                @php
                                    $path = public_path('storage/' . $item->foto_perbaikan);
                                    $type = pathinfo($path, PATHINFO_EXTENSION);
                                    $data = file_get_contents($path);
                                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                @endphp
                                <img src="{{ $base64 }}" width="80">
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $item->catatan_perbaikan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">Tidak ada tindak lanjut untuk hasil inspeksi ini.</td>
                    </tr>
                @endforelse
            @empty
                <tr>
                    <td colspan="9">Tidak ada hasil inspeksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <strong>Tanggal Dicetak:</strong> {{ tanggalIndo(now()) }}<br>
        <strong>Dibuat oleh:</strong> Safety, Health & Environment
    </div>

    <div class="ttd">
        <p>Disetujui oleh,</p>
        <br><br><br>
        <strong>(_________________________)</strong><br>
    </div>
</body>

</html>
