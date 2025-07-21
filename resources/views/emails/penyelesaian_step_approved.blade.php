<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Penyelesaian Pekerjaan Disetujui - Step {{ $step }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            padding: 20px;
            font-size: 14px;
            color: #333;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: #fff;
            padding: 25px 30px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }

        h2 {
            color: #0d6efd;
            margin-top: 0;
        }

        ul {
            padding-left: 20px;
        }

        .btn {
            display: inline-block;
            background-color: #0d6efd;
            color: #fff;
            padding: 12px 22px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            font-size: 12px;
            color: #888;
            text-align: center;
        }

        .info-label {
            font-weight: bold;
            width: 160px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Informasi Persetujuan Penyelesaian</h2>

        <p>Halo <strong>{{ $vendorName }}</strong>,</p>

        <p>
            Kami informasikan bahwa <strong>Step ke-{{ $step }}</strong> dari proses <strong>penyelesaian pekerjaan</strong> Anda telah <strong>disetujui</strong>.
        </p>

        <div style="margin: 20px 0;">
            <div><span class="info-label">Nama Pekerjaan:</span> {{ $namaPekerjaan }}</div>
            <div><span class="info-label">Disetujui oleh:</span> {{ $approvedBy }}</div>
            <div><span class="info-label">Tanggal Persetujuan:</span> {{ \Carbon\Carbon::parse($tanggal)->format('d M Y H:i') }}</div>
        </div>

        <p>
            Anda dapat melihat detail pekerjaan dan status terkini melalui tombol berikut:
        </p>

        <p style="text-align: center; margin-top: 30px;">
            <a href="{{ $linkDetail }}" class="btn">Lihat Detail Penyelesaian</a>
        </p>

        <p style="margin-top: 30px;">Terima kasih atas perhatian dan kerja samanya.</p>

        <p>Salam hormat,<br><strong>Tim Safety & Permit</strong></p>

        <div class="footer">
            Email ini dikirim otomatis oleh sistem. Mohon untuk tidak membalas email ini.
        </div>
    </div>
</body>
</html>
