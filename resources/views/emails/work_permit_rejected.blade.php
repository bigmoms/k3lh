<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Work Permit Ditolak</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
            font-size: 14px;
            color: #333;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        h3 {
            margin-top: 0;
            color: #c0392b;
        }

        .btn {
            display: inline-block;
            background-color: #e74c3c;
            color: #fff;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        blockquote {
            border-left: 4px solid #c0392b;
            margin: 10px 0;
            padding-left: 10px;
            font-style: italic;
            color: #555;
        }

        .footer {
            margin-top: 40px;
            font-size: 12px;
            color: #888;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Halo, {{ $vendorName }}</h3>

        <h3>Work Permit #{{ $nomor }} <span style="color:#c0392b;">DITOLAK</span></h3>

        <p>
            <strong>Pekerjaan:</strong> {{ $namaPekerjaan }}<br>
            <strong>Tanggal:</strong> {{ $tanggal }}<br>
            <strong>Ditolak oleh:</strong> {{ $approver }}
        </p>

        @if($alasan && $alasan !== '-')
            <p><strong>Alasan Penolakan:</strong></p>
            <blockquote>
                {{ $alasan }}
            </blockquote>
        @endif

        <p>
            Mohon lakukan perbaikan pada data atau dokumen <strong>Work Permit</strong> Anda sesuai catatan di atas, kemudian ajukan kembali melalui sistem.
        </p>

        <p style="text-align: center; margin: 30px 0;">
            <a href="{{ $linkIndex }}" class="btn">Kembali ke Daftar Work Permit</a>
        </p>

        <p>Terima kasih,<br><strong>Tim Safety & Permit</strong></p>

        <div class="footer">
            Email ini dikirim secara otomatis oleh sistem. Jangan balas ke email ini.
        </div>
    </div>
</body>
</html>
