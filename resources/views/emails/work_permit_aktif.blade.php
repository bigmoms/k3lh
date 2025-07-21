<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Work Permit Telah Disetujui</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 14px;
            color: #333;
            background-color: #f1f1f1;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 680px;
            margin: auto;
            background-color: #fff;
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 25px 30px;
        }
        h2 {
            color: #198754;
            margin-top: 0;
        }
        ul {
            padding-left: 18px;
        }
        .btn {
            display: inline-block;
            margin-top: 18px;
            background-color: #198754;
            color: #fff;
            padding: 10px 20px;
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
        <h2>Work Permit Aktif</h2>

        <p>Yth. <strong>{{ $vendorName }}</strong>,</p>

        <p>
            Kami informasikan bahwa pengajuan <strong>Work Permit</strong> Anda telah <strong>disetujui</strong> dan saat ini sudah <strong>aktif</strong>.
            Berikut detail pekerjaan terkait:
        </p>

        <ul>
            <li><strong>Nama Pekerjaan:</strong> {{ $namaPekerjaan }}</li>
            <li><strong>Tanggal Mulai:</strong> {{ \Carbon\Carbon::parse($tanggalMulai)->format('d M Y') }}</li>
            <li><strong>Tanggal Akhir:</strong> {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d M Y') }}</li>
            <li><strong>Status:</strong> <span style="color: green;">Aktif</span></li>
        </ul>

        <p>
            Mohon untuk melanjutkan pelaksanaan pekerjaan sesuai jadwal yang telah ditentukan.
            Jangan lupa untuk melakukan pelaporan harian melalui menu <strong>Jam Kerja Aman</strong> pada sistem.
        </p>

        <p>
            Jika ada pertanyaan atau kendala, silakan hubungi tim Safety & Permit kami.
        </p>

        <p>Terima kasih atas perhatian dan kerja samanya.</p>

        <p>Hormat kami,<br><strong>Tim Safety & Permit</strong></p>

        <div class="footer">
            Email ini dikirim secara otomatis oleh sistem. Mohon untuk tidak membalas email ini.
        </div>
    </div>
</body>
</html>
