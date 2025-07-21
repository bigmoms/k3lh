@php
    use Carbon\Carbon;
    $tanggal = Carbon::parse($jadwal->tanggal_pengukuran)->translatedFormat('d F Y');
    $jamMulai = $jadwal->jam_mulai ? Carbon::parse($jadwal->jam_mulai)->format('H:i') : '-';
    $jamSelesai = $jadwal->jam_selesai ? Carbon::parse($jadwal->jam_selesai)->format('H:i') : '-';
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Hasil Pengukuran Lingkungan Kerja</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            font-size: 14px;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 640px;
            margin: 40px auto;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .header {
            background-color: #198754;
            padding: 20px;
            color: #fff;
            text-align: center;
        }

        .content {
            padding: 30px;
        }

        .content p {
            margin: 10px 0;
        }

        .info-table {
            width: 100%;
            margin-top: 15px;
        }

        .info-table td {
            padding: 6px 0;
            vertical-align: top;
        }

        .info-table td:first-child {
            width: 140px;
            font-weight: bold;
            color: #555;
        }

        .footer {
            background-color: #f1f1f1;
            text-align: center;
            font-size: 12px;
            color: #777;
            padding: 12px;
        }

        .button {
            display: inline-block;
            background-color: #198754;
            color: #fff;
            padding: 10px 18px;
            border-radius: 6px;
            text-decoration: none;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <h2>Hasil Pengukuran Lingkungan Kerja</h2>
        </div>

        <div class="content">
            <p>Yth. Tim di lokasi <strong>{{ $lokasi->nama_lokasi }}</strong>,</p>

            <p>Pengukuran lingkungan kerja telah selesai dilaksanakan. Berikut detail jadwalnya:</p>

            <table class="info-table">
                <tr>
                    <td>Tanggal Pengukuran</td>
                    <td>: {{ $tanggal }}</td>
                </tr>
                <tr>
                    <td>Waktu</td>
                    <td>: {{ $jamMulai }} - {{ $jamSelesai }}</td>
                </tr>
                <tr>
                    <td>Lokasi</td>
                    <td>: {{ $lokasi->nama_lokasi }}</td>
                </tr>
            </table>

            <p>Silakan periksa hasil pengukuran melalui aplikasi dan lakukan konfirmasi apabila hasil telah diterima
                dengan baik.</p>

            <a href="{{ route('lingkungan.hasil.index') }}" class="button" target="_blank">
                Lihat Hasil Pengukuran
            </a>

            <p style="margin-top: 20px;">Terima kasih atas perhatian dan kerja samanya.</p>

            <p>Hormat kami,<br><strong>Dept Security, Fire & SHE</strong></p>
        </div>

        <div class="footer">
            Email ini dikirim otomatis oleh sistem. Jangan membalas email ini.
        </div>
    </div>

</body>

</html>
