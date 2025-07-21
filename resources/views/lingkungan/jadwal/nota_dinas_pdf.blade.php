@php
    use Carbon\Carbon;
    $logoPath = public_path('logo.png');
    $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Nota Dinas Pengukuran Lingkungan</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 13px;
            color: #333;
            padding: 30px;
            background-color: #fff;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 3px solid #007BFF;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }

        .logo {
            height: 60px;
        }

        .title {
            text-align: right;
        }

        .title h1 {
            margin: 0;
            font-size: 20px;
            color: #007BFF;
            text-transform: uppercase;
        }

        .title p {
            margin: 3px 0 0;
            font-size: 13px;
            font-weight: bold;
        }

        .info-table {
            margin-top: 20px;
            margin-bottom: 20px;
            width: 100%;
        }

        .info-table td {
            padding: 5px 0;
            vertical-align: top;
        }

        .info-table td:first-child {
            width: 100px;
        }

        .isi {
            margin-top: 15px;
            line-height: 1.6;
        }

        .ttd {
            margin-top: 50px;
            text-align: right;
        }

        hr {
            border: 1px solid #007BFF;
            margin: 20px 0;
        }

        .multi-recipient div {
            margin-bottom: 2px;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <div class="header">
        <img src="{{ $logoBase64 }}" alt="Logo" class="logo">
        <div class="title">
            <h1>Nota Dinas</h1>
            <p>No: {{ $nomorNota ?? '....' }}</p>
        </div>
    </div>

    <!-- Info -->
    <table class="info-table">
        <tr>
            <td><strong>Kepada</strong></td>
            <td>
                @foreach ($jadwal->lokasi as $lokasi)
                    <div>{{ $loop->iteration }}. Manager {{ $lokasi->nama_lokasi }}</div>
                @endforeach
            </td>
            </td>
        </tr>
        <tr>
            <td><strong>Dari</strong></td>
            <td>: Dept Security, Fire & SHE</td>
        </tr>
        <tr>
            <td><strong>Perihal</strong></td>
            <td>: {{ $jadwal->catatan ?? 'Pengukuran Lingkungan Kerja' }}</td>
        </tr>
        <tr>
            <td><strong>Tanggal</strong></td>
            <td>: {{ Carbon::parse($jadwal->tanggal_pengukuran)->translatedFormat('d F Y') }}</td>
        </tr>
    </table>

    <hr>

    <!-- Isi -->
    <div class="isi">
        <p>Dengan hormat,</p>

        <p style="text-align: justify;">
            Sehubungan dengan telah dilaksanakannya pengukuran kondisi fisik lingkungan kerja yang di antaranya meliputi
            Cahaya, Suhu, Kelembaban dan Kebisingan di beberapa area PT KIEC,
            maka kami sampaikan laporan hasil pemeriksaan tersebut. Hasil yang berada di atas baku mutu agar dapat
            ditindaklanjuti, dan hasil perbaikannya disampaikan kembali kepada Divisi Security, Fire & SHE.
        </p>


        <p>Demikian kami sampaikan. Atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>
    </div>

    <!-- TTD -->
    <div class="ttd">
        <p>Hormat kami,</p>
        <br><br><br>
        <p><strong>Manager<br>Dept Security, Fire & SHE</strong></p>
    </div>

</body>

</html>
