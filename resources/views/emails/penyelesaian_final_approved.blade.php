<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pekerjaan Diselesaikan Sepenuhnya</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f7fa;
            padding: 20px;
            font-size: 14px;
            color: #333;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        h2 {
            color: #198754;
            margin-top: 0;
        }

        .btn {
            display: inline-block;
            background-color: #198754;
            color: #fff;
            padding: 12px 22px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }

        .info-label {
            font-weight: bold;
            width: 160px;
            display: inline-block;
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
        <h2>Pekerjaan Telah Diselesaikan</h2>

        <p>Halo <strong>{{ $vendorName }}</strong>,</p>

        <p>
            Selamat! Seluruh tahapan <strong>penyelesaian pekerjaan</strong> telah disetujui oleh pihak terkait. Pekerjaan Anda telah dinyatakan <strong>selesai secara resmi</strong>.
        </p>

        <div style="margin: 20px 0;">
            <div><span class="info-label">Nama Pekerjaan:</span> {{ $namaPekerjaan }}</div>
            <div><span class="info-label">Tanggal Penyelesaian:</span> {{ \Carbon\Carbon::parse($tanggal)->format('d M Y H:i') }}</div>
        </div>

        <p>
            Anda dapat mengunduh laporan pekerjaan atau melihat detail lengkap melalui tombol di bawah ini:
        </p>

        <p style="text-align: center; margin: 30px 0;">
            <a href="{{ $linkDetail }}" class="btn">Lihat Detail Pekerjaan</a>
        </p>

        <p>
            Terima kasih atas kerjasama dan dedikasi Anda dalam menjalankan pekerjaan ini dengan baik.
        </p>

        <p>Salam sukses,<br><strong>Tim Safety & Permit</strong></p>

        <div class="footer">
            Email ini dikirim otomatis oleh sistem. Mohon untuk tidak membalas email ini.
        </div>
    </div>
</body>
</html>
