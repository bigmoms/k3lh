@php
    use Carbon\Carbon;
    $tanggal = Carbon::parse($jadwal->tanggal_inspeksi)->translatedFormat('d F Y');
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Verifikasi Hasil Inspeksi</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            font-size: 14px;
            background: #f9f9f9;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #0d6efd;
            color: #fff;
            padding: 16px;
            text-align: center;
        }

        .content {
            padding: 25px 30px;
        }

        .footer {
            background: #f1f1f1;
            text-align: center;
            padding: 15px;
            font-size: 12px;
            color: #888;
        }

        .btn {
            background: #0d6efd;
            color: #fff;
            padding: 10px 16px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }

        .info-table {
            margin-top: 10px;
            width: 100%;
        }

        .info-table td {
            padding: 6px;
            vertical-align: top;
        }

        .info-table td:first-child {
            font-weight: bold;
            width: 130px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <h2>Verifikasi Hasil Inspeksi</h2>
        </div>

        <div class="content">
            <p>Yth. Tim Divisi {{ $jadwal->divisiInspeksi->nama_divisi }},</p>

            <p>Dengan ini kami informasikan bahwa hasil inspeksi yang dilakukan pada:</p>

            <table class="info-table">
                <tr>
                    <td>Tanggal</td>
                    <td>: {{ $tanggal }}</td>
                </tr>
                <tr>
                    <td>Lokasi</td>
                    <td>: {{ $jadwal->divisiInspeksi->lokasi->nama_lokasi ?? '-' }}</td>
                </tr>
            </table>

            <p>Telah dilakukan verifikasi terhadap seluruh temuan dan tindak lanjut perbaikan. Seluruh perbaikan telah
                dinyatakan <strong>selesai</strong> dan inspeksi ditutup.</p>

            <p>Silakan meninjau kembali laporan hasil inspeksi melalui sistem untuk dokumentasi internal.</p>

            <a href="{{ route('inspeksi.jadwal.show', encodeId($jadwal->id)) }}" class="btn" target="_blank">
                Lihat Laporan Inspeksi
            </a>

            <p style="margin-top: 30px;">Terima kasih atas kerja samanya.</p>

            <p><strong>Dept Security, Fire & SHE</strong></p>
        </div>

        <div class="footer">
            Email ini dikirim otomatis oleh sistem. Jangan balas ke email ini.
        </div>
    </div>

</body>

</html>
