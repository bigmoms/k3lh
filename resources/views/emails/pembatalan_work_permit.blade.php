<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pemberitahuan Pembatalan Work Permit</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            background-color: #f9f9f9;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            padding: 25px;
            border-radius: 8px;
            border: 1px solid #ddd;
            max-width: 650px;
            margin: auto;
        }
        h2 {
            color: #c0392b;
        }
        ul {
            padding-left: 18px;
        }
        .footer {
            font-size: 12px;
            color: #888;
            margin-top: 30px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Pemberitahuan Pembatalan Pekerjaan</h2>

        <p>Yth. <strong>{{ $pembatalan->purchaseOrder->vendor->vendor_name }}</strong>,</p>

        <p>
            Dengan ini kami informasikan bahwa pekerjaan berikut <strong>tidak akan dilanjutkan</strong> karena telah dibatalkan oleh tim kami.
        </p>

        <ul>
            <li><strong>Nama Pekerjaan:</strong> {{ $pembatalan->purchaseOrder->nama_pekerjaan }}</li>
            <li><strong>No. PO:</strong> {{ $pembatalan->purchaseOrder->nomor }}</li>
            <li><strong>Tanggal Pembatalan:</strong> {{ $pembatalan->created_at->format('d F Y, H:i') }}</li>
        </ul>

        @if ($pembatalan->alasan && $pembatalan->alasan !== '-')
            <p><strong>Alasan Pembatalan:</strong></p>
            <blockquote style="border-left: 4px solid #c0392b; padding-left: 10px; margin: 10px 0;">
                {{ $pembatalan->alasan }}
            </blockquote>
        @endif

        <p>
            Jika Anda memiliki pertanyaan atau klarifikasi terkait pembatalan ini, silakan hubungi tim Safety & Permit.
        </p>

        <p>Terima kasih atas perhatian dan kerja samanya.</p>

        <p>Hormat kami,<br>
        <strong>Tim Safety & Permit</strong></p>

        <div class="footer">
            Email ini dikirim secara otomatis oleh sistem. Mohon tidak membalas email ini.
        </div>
    </div>
</body>
</html>
