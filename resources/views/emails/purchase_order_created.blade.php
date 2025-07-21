<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pemberitahuan Pekerjaan Baru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f9f9f9;
            padding: 20px;
            font-size: 14px;
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
            color: #198754;
            margin-top: 0;
        }

        h4 {
            color: #444;
            margin-top: 24px;
        }

        ul,
        ol {
            padding-left: 18px;
        }

        .btn {
            display: inline-block;
            background-color: #28a745;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 15px;
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

        <p>Ada pekerjaan baru yang membutuhkan pengisian <strong>Work Permit</strong>. Berikut detailnya:</p>

        <ul>
            <li><strong>No. PO:</strong> {{ $no_po }}</li>
            <li><strong>Nama Pekerjaan:</strong> {{ $namaPekerjaan }}</li>
            <li><strong>Area Pekerjaan:</strong> {{ $areaPekerjaan }}</li>
            <li><strong>Lokasi:</strong> {{ $lokasiPekerjaan }}</li>
            <li><strong>Detail:</strong> {{ $detailPekerjaan }}</li>
            <li><strong>Tanggal Mulai:</strong> {{ \Carbon\Carbon::parse($tanggalMulai)->translatedFormat('d F Y') }}
            </li>
            <li><strong>Tanggal Akhir:</strong> {{ \Carbon\Carbon::parse($tanggalAkhir)->translatedFormat('d F Y') }}
            </li>
        </ul>

        @if (!empty($klasifikasiPekerjaan))
            <h4>Peralatan Safety yang Dibutuhkan</h4>
            @php
                $allAlat = collect($klasifikasiPekerjaan)
                    ->flatMap(fn($k) => $k['alatSafety'])
                    ->unique()
                    ->sort()
                    ->values();
            @endphp

            <ul>
                @forelse($allAlat as $alat)
                    <li>{{ $alat }}</li>
                @empty
                    <li><em>Tidak ada alat safety tercatat</em></li>
                @endforelse
            </ul>
        @endif

        @if (!empty($catatan))
            <p><strong>Catatan:</strong> {{ $catatan }}</p>
        @endif

        <p>
            Mohon untuk segera melengkapi dokumen Work Permit. Klik tombol di bawah untuk memulai:
        </p>

        <p style="text-align: center;">
            <a href="{{ $linkWorkPermit }}" class="btn">Isi Work Permit Sekarang</a>
        </p>

        <p>Terima kasih atas perhatian dan kerja samanya.</p>

        <p><strong>Tim Safety & Permit</strong></p>

        <div class="footer">
            Email ini dikirim otomatis oleh sistem. Jika Anda tidak merasa terkait, abaikan pesan ini.
        </div>
    </div>
</body>

</html>
