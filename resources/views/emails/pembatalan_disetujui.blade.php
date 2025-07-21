<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pembatalan Work Permit Disetujui</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            padding: 20px;
            line-height: 1.6;
        }

        .email-container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 30px;
        }

        h3 {
            color: #c0392b;
        }

        ul {
            padding-left: 20px;
        }

        ul li {
            margin-bottom: 5px;
        }

        .footer {
            font-size: 12px;
            color: #999;
            margin-top: 30px;
            border-top: 1px solid #eee;
            padding-top: 15px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <h3>Halo, {{ $vendorName }}</h3>

        <p>Dengan hormat,</p>

        <p>
            Kami informasikan bahwa pengajuan pembatalan <strong>Work Permit</strong> untuk pekerjaan berikut telah
            <strong>disetujui sepenuhnya</strong> dan dinyatakan <strong>dibatalkan</strong> secara resmi:
        </p>

        <ul>
            <li><strong>No. PO:</strong> {{ $noPO }}</li>
            <li><strong>Nama Pekerjaan:</strong> {{ $namaPekerjaan }}</li>
            <li><strong>Tanggal Persetujuan:</strong>
                {{ \Carbon\Carbon::parse($tanggalPembatalan)->translatedFormat('d F Y') }}</li>
            <li><strong>Alasan Pembatalan:</strong> {{ $alasan }}</li>
        </ul>

        <p>
            Mohon segera menghentikan seluruh aktivitas pekerjaan yang berkaitan dengan PO tersebut.
            Jika terdapat pertanyaan lebih lanjut, silakan hubungi tim <strong>Safety & Permit</strong>.
        </p>

        <p>Terima kasih atas perhatian dan kerja sama yang baik.</p>

        <p><strong>Tim Safety & Permit</strong></p>

        <div class="footer">
            Email ini dikirim secara otomatis oleh sistem. Mohon tidak membalas email ini.
        </div>
    </div>
</body>

</html>
