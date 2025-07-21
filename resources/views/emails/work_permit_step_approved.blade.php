<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Work Permit Disetujui - Step {{ $step }}</title>
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
        <h2>Notifikasi Persetujuan Work Permit</h2>

        <p>Halo, <strong>{{ $vendorName }}</strong>,</p>

        <p>
            Kami informasikan bahwa <strong>Step persetujuan {{ $step }}</strong> dari proses Work Permit Anda telah <strong>disetujui</strong>. Berikut rincian pekerjaannya:
        </p>

        <ul>
            <li><strong>Pekerjaan:</strong> {{ $namaPekerjaan }}</li>
            <li><strong>Disetujui oleh:</strong> {{ $approvedBy }}</li>
            <li><strong>Tanggal Persetujuan:</strong> {{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}</li>
        </ul>

        <p>
            Silakan lanjutkan ke tahapan berikutnya atau pantau perkembangan status pekerjaan Anda melalui tombol di bawah:
        </p>

        <p style="text-align: center;">
            <a href="{{ $linkDetail }}" class="btn">Lihat Detail Work Permit</a>
        </p>

        <p>Terima kasih atas perhatian dan kerja samanya.</p>

        <p>Salam hormat,<br><strong>Tim Safety & Permit</strong></p>

        <div class="footer">
            Email ini dikirim secara otomatis oleh sistem. Mohon untuk tidak membalas email ini.
        </div>
    </div>
</body>
</html>
