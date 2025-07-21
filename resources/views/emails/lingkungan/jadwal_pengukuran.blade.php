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
    <title>Notifikasi Jadwal Pengukuran</title>
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
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .header {
            background-color: #28a745;
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
            background-color: #28a745;
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
            <h2>Pemberitahuan Jadwal Pengukuran Lingkungan Kerja</h2>
        </div>

        <div class="content">
            <p>Yth. {{ $user->name }},</p>

            <p>Berikut adalah jadwal pengukuran lingkungan kerja yang telah dijadwalkan:</p>

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
                    <td>Catatan</td>
                    <td>: {{ $jadwal->catatan ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Lokasi Terkait</td>
                    <td>
                        <ul style="margin: 0; padding-left: 18px;">
                            @foreach ($jadwal->lokasi as $lokasi)
                                <li>{{ $lokasi->nama_lokasi }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            </table>

            <p>Silakan melakukan persiapan yang diperlukan sebelum pelaksanaan pengukuran. Terima kasih atas kerja
                samanya.</p>

            <p>Hormat kami,</p>
            <p><strong>Dept K3 & Lingkungan</strong></p>

            <a href="{{ route('lingkungan.jadwal.show', encodeId($jadwal->id)) }}" class="button" target="_blank">
                Lihat Detail Jadwal
            </a>
        </div>

        <div class="footer">
            Email ini dikirim otomatis oleh sistem. Jangan balas ke email ini.
        </div>
    </div>

</body>

</html>
