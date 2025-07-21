@php
    use Carbon\Carbon;
    $tanggal = Carbon::parse($jadwal->tanggal_inspeksi)->translatedFormat('d F Y');
    $jamMulai = Carbon::parse($jadwal->jam_mulai)->format('H:i');
    $jamSelesai = Carbon::parse($jadwal->jam_selesai)->format('H:i');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Notifikasi Hasil Inspeksi</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14px;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 680px;
            margin: 30px auto;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .header {
            background-color: #28a745;
            color: white;
            padding: 16px;
            text-align: center;
        }

        .content {
            padding: 24px 32px;
        }

        .content p {
            margin-bottom: 14px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
            margin-bottom: 24px;
        }

        .info-table td {
            padding: 8px;
            vertical-align: top;
        }

        .info-table td:first-child {
            font-weight: bold;
            width: 160px;
            color: #444;
        }

        .hasil-box {
            background-color: #f8f9fa;
            border-left: 4px solid #198754;
            padding: 12px 16px;
            margin-bottom: 14px;
            border-radius: 6px;
        }

        .button {
            display: inline-block;
            background-color: #198754;
            color: #fff;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            margin-top: 20px;
        }

        .footer {
            background-color: #f1f1f1;
            color: #888;
            font-size: 12px;
            text-align: center;
            padding: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Hasil Inspeksi</h2>
        </div>

        <div class="content">
            <p>Yth. Tim Divisi <strong>{{ $jadwal->divisiInspeksi->nama_divisi }}</strong>,</p>

            <p>Berikut kami sampaikan hasil dari inspeksi yang telah dilaksanakan:</p>

            <table class="info-table">
                <tr>
                    <td>Tanggal Inspeksi</td>
                    <td>: {{ $tanggal }}</td>
                </tr>
                <tr>
                    <td>Waktu</td>
                    <td>: {{ $jamMulai }} - {{ $jamSelesai }}</td>
                </tr>
                <tr>
                    <td>Lokasi</td>
                    <td>: {{ $jadwal->divisiInspeksi->lokasi->nama_lokasi ?? '-' }}</td>
                </tr>
            </table>

            @foreach ($hasilInspeksi as $index => $hasil)
                <div class="hasil-box">
                    <p><strong>Titik {{ $index + 1 }}</strong></p>
                    <p><strong>Hasil:</strong> {{ $hasil->hasil_inspeksi }}</p>
                    @php
                        $tindak = $hasil->tindakLanjut->first();
                    @endphp
                    @if ($tindak)
                        <p><strong>Saran Perbaikan:</strong> {{ $tindak->saran_perbaikan }}</p>
                        <p><strong>Target Selesai:</strong> {{ \Carbon\Carbon::parse($tindak->target_penyelesaian)->translatedFormat('d F Y') }}</p>
                    @endif
                </div>
            @endforeach

            <p>Mohon segera dilakukan tindak lanjut dan konfirmasi perbaikan melalui sistem. Terima kasih atas perhatian dan kerja samanya.</p>

            <p>Hormat kami,</p>
            <p><strong>Dept Security, Fire & SHE</strong></p>

            <a href="{{ route('inspeksi.hasil.show', encodeId($jadwal->id)) }}" class="button" target="_blank">Lihat Hasil Inspeksi</a>
        </div>

        <div class="footer">
            Email ini dikirim otomatis oleh sistem. Jangan balas ke email ini.
        </div>
    </div>
</body>
</html>
