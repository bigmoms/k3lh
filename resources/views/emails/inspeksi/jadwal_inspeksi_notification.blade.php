@php
    use Carbon\Carbon;
    $tanggal = \Carbon\Carbon::parse($jadwal->tanggal_inspeksi)->translatedFormat('d F Y');
    $jamMulai = \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i');
    $jamSelesai = \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Notifikasi Jadwal Inspeksi</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14px;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #fff;
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .header {
            background-color: #007BFF;
            padding: 20px;
            color: #fff;
            text-align: center;
        }

        .header h2 {
            margin: 0;
        }

        .content {
            padding: 30px;
        }

        .content p {
            margin: 8px 0;
        }

        .info-table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 6px 4px;
            vertical-align: top;
        }

        .info-table td:first-child {
            font-weight: bold;
            width: 140px;
            color: #555;
        }

        .footer {
            background-color: #f1f1f1;
            text-align: center;
            font-size: 12px;
            color: #888;
            padding: 15px;
        }

        .button {
            display: inline-block;
            margin-top: 20px;
            background-color: #007BFF;
            color: #fff;
            padding: 10px 18px;
            border-radius: 6px;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>Pemberitahuan Jadwal Inspeksi</h2>
    </div>

    <div class="content">
        <p>Yth. Tim Divisi {{ $jadwal->divisiInspeksi->nama_divisi }},</p>

        <p>Berikut adalah detail jadwal inspeksi yang telah dijadwalkan:</p>

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
            <tr>
                <td>Catatan</td>
                <td>: {{ $jadwal->catatan ?? '-' }}</td>
            </tr>
        </table>

        <p>Silakan melakukan persiapan yang diperlukan sebelum pelaksanaan inspeksi. Terima kasih atas kerja samanya.</p>

        <p>Hormat kami,</p>
        <p><strong>Dept Security, Fire & SHE</strong></p>

        <a href="{{ route('inspeksi.jadwal.show', encodeId($jadwal->id)) }}" class="button" target="_blank">
            Lihat Detail Jadwal
        </a>
    </div>

    <div class="footer">
        Email ini dikirim otomatis oleh sistem. Jangan balas ke email ini.
    </div>
</div>

</body>
</html>
