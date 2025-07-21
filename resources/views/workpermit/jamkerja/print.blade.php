@php
    use Carbon\Carbon;
    $workPermit = $schedule->workPermit;
    $po = $workPermit->purchaseOrder;
    $logoPath = public_path('logo.png');
    $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));

    $tanggal = explode(' s/d ', $schedule->periode_laporan);
    $tanggalAwal = Carbon::parse($tanggal[0])->translatedFormat('d M Y');
    $tanggalAkhir = Carbon::parse($tanggal[1])->translatedFormat('d M Y');
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Jam Kerja</title>
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
            padding-bottom: 12px;
            margin-bottom: 25px;
        }

        .logo {
            height: 60px;
        }

        .title {
            font-size: 22px;
            color: #007BFF;
            text-align: right;
        }

        .info {
            margin-bottom: 20px;
        }

        .info div {
            margin-bottom: 4px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            color: #444;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px 4px;
            text-align: left;
        }

        th {
            background-color: #e9f1ff;
            color: #333;
        }

        tfoot td {
            font-weight: bold;
            background-color: #f5f5f5;
        }

        .footer {
            margin-top: 35px;
            text-align: center;
            font-size: 11px;
            color: #888;
        }
    </style>
</head>

<body>

    <div class="header">
        <img src="{{ $logoBase64 }}" alt="Logo" class="logo">
        <div class="title">Laporan Jam Kerja Aman</div>
    </div>

    <div class="info">
        <table style="width: 100%; border: none; border-collapse: collapse;">
            <tr>
                <td style="width: 20%; border: none;"><strong>No. PO</strong></td>
                <td style="border: none;">: {{ $po->no_po }}</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Nama Vendor</strong></td>
                <td style="border: none;">: {{ $po->vendor->vendor_name }}</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Nama Pekerjaan</strong></td>
                <td style="border: none;">: {{ $po->nama_pekerjaan }}</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Lokasi Kerja</strong></td>
                <td style="border: none;">: {{ $po->lokasi_pekerjaan }}</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Periode Laporan</strong></td>
                <td style="border: none;">: {{ $tanggalAwal }} s/d {{ $tanggalAkhir }}</td>
            </tr>
        </table>
    </div>

    <div class="section-title">Rincian Jam Kerja</div>
    <table>
        <thead>
            <tr>
                <th rowspan="2">Tanggal</th>
                <th rowspan="2">Jumlah Pekerja</th>
                <th rowspan="2">Jam Kerja</th>
                <th rowspan="2">Jam Kerja Nyata</th>
                <th rowspan="2">Pekerja Lembur</th>
                <th rowspan="2">Jam Lembur</th>
                <th rowspan="2">Total Lembur</th>
                <th rowspan="2">Total Kerja</th>
                <th colspan="4">Kehilangan Jam</th>
                <th rowspan="2">Total Kehilangan</th>
                <th rowspan="2">Jam Kerja Aman</th>
            </tr>
            <tr>
                <th>Cuti</th>
                <th>Ijin</th>
                <th>Sakit</th>
                <th>Alpha</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalD = $totalG = $totalH = $totalM = $totalN = $totalI = $totalJ = $totalK = $totalL = 0;
            @endphp
            @foreach ($schedule->details as $detail)
                @php
                    $d = $detail->jumlah_pekerja * $detail->jam_kerja;
                    $g = $detail->jumlah_pekerja_lembur * $detail->jam_lembur;
                    $h = $d + $g;
                    $i = $detail->cuti;
                    $j = $detail->ijin;
                    $k = $detail->sakit;
                    $l = $detail->alpha;
                    $m = $i + $j + $k + $l;
                    $n = $h - $m;

                    $totalD += $d;
                    $totalG += $g;
                    $totalH += $h;
                    $totalI += $i;
                    $totalJ += $j;
                    $totalK += $k;
                    $totalL += $l;
                    $totalM += $m;
                    $totalN += $n;
                @endphp
                <tr>
                    <td>{{ Carbon::parse($detail->tanggal)->format('d M Y') }}</td>
                    <td>{{ $detail->jumlah_pekerja }}</td>
                    <td>{{ $detail->jam_kerja }}</td>
                    <td>{{ $d }}</td>
                    <td>{{ $detail->jumlah_pekerja_lembur }}</td>
                    <td>{{ $detail->jam_lembur }}</td>
                    <td>{{ $g }}</td>
                    <td>{{ $h }}</td>
                    <td>{{ $i }}</td>
                    <td>{{ $j }}</td>
                    <td>{{ $k }}</td>
                    <td>{{ $l }}</td>
                    <td>{{ $m }}</td>
                    <td>{{ $n }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">Total</td>
                <td>{{ $totalD }}</td>
                <td>-</td>
                <td>-</td>
                <td>{{ $totalG }}</td>
                <td>{{ $totalH }}</td>
                <td>{{ $totalI }}</td>
                <td>{{ $totalJ }}</td>
                <td>{{ $totalK }}</td>
                <td>{{ $totalL }}</td>
                <td>{{ $totalM }}</td>
                <td>{{ $totalN }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Laporan ini dihasilkan oleh sistem Work Permit &mdash; {{ now()->format('d M Y H:i') }}
    </div>

</body>

</html>
