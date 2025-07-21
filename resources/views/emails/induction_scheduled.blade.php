<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jadwal Induction</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
            background-color: #f9f9f9;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            padding: 25px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        h2 {
            color: #198754;
            margin-top: 0;
        }
        table {
            width: 100%;
            margin-top: 15px;
        }
        td {
            padding: 6px 4px;
            vertical-align: top;
        }
        .btn {
            display: inline-block;
            background-color: #198754;
            color: #fff;
            padding: 10px 20px;
            margin-top: 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #888;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Halo, {{ $vendorName }}</h2>

        <p>
            Jadwal <strong>Induction</strong> untuk pekerjaan Anda telah ditentukan. Mohon hadir tepat waktu dan ikuti seluruh prosedur keselamatan kerja yang berlaku.
        </p>

        <table>
            <tr>
                <td style="width: 40%;"><strong>Nama Pekerjaan</strong></td>
                <td>: {{ $namaPekerjaan }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Induction</strong></td>
                <td>: {{ \Carbon\Carbon::parse($tanggalInduction)->format('d M Y') }}</td>
            </tr>
            <tr>
                <td><strong>Lokasi</strong></td>
                <td>: {{ $lokasi }}</td>
            </tr>
        </table>

        <p>
            Untuk informasi lebih lanjut dan akses ke dokumen lengkap Work Permit, klik tombol berikut:
        </p>

        <p style="text-align: center;">
            <a href="{{ $linkDetail }}" class="btn">Lihat Detail Work Permit</a>
        </p>

        <p>Terima kasih atas perhatian dan kerja samanya.</p>

        <p><strong>Salam hormat,</strong><br>Tim Safety & Permit</p>

        <div class="footer">
            Email ini dikirim secara otomatis oleh sistem. Mohon untuk tidak membalas email ini.
        </div>
    </div>
</body>
</html>
