@php
    use Carbon\Carbon;
    $workPermit = $schedules->first()->workPermit ?? null;
    $po = $workPermit ? $workPermit->purchaseOrder : null;
    $logoPath = public_path('logo.png');
    $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));

@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Laporan Jam Kerja Gabungan</title>
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
        <div class="title">Laporan Jam Kerja Gabungan</div>
    </div>

    @if (!$po)
        <p>Data Work Permit / Purchase Order tidak ditemukan.</p>
    @else
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
                    <td style="border: none;"><strong>Masa Pekerjaan</strong></td>
                    <td style="border: none;">: {{ \Carbon\Carbon::parse($po->tanggal_mulai)->format('d M Y') }}
                        - {{ \Carbon\Carbon::parse($po->tanggal_akhir)->format('d M Y') }}</td>
                </tr>
            </table>
        </div>


        @foreach ($schedules as $schedule)
            <div class="section-title" style="margin-top:30px">Periode Laporan: {{ $schedule->periode_laporan }}</div>

            @php
                $totalNormalHours = 0;
                $totalOvertimeHours = 0;
                $totalWorkHours = 0;
                $totalCuti = 0;
                $totalIjin = 0;
                $totalSakit = 0;
                $totalAlpha = 0;
                $totalLostHours = 0;
                $totalSafeWorkHours = 0;
            @endphp

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
                    @foreach ($schedule->details as $detail)
                        @php
                            $normalHours = $detail->jumlah_pekerja * $detail->jam_kerja;
                            $overtimeHours = $detail->jumlah_pekerja_lembur * $detail->jam_lembur;
                            $totalHours = $normalHours + $overtimeHours;

                            $lostHours = $detail->cuti + $detail->ijin + $detail->sakit + $detail->alpha;
                            $safeWorkHours = $totalHours - $lostHours;

                            $totalNormalHours += $normalHours;
                            $totalOvertimeHours += $overtimeHours;
                            $totalWorkHours += $totalHours;
                            $totalCuti += $detail->cuti;
                            $totalIjin += $detail->ijin;
                            $totalSakit += $detail->sakit;
                            $totalAlpha += $detail->alpha;
                            $totalLostHours += $lostHours;
                            $totalSafeWorkHours += $safeWorkHours;
                        @endphp
                        <tr>
                            <td>{{ Carbon::parse($detail->tanggal)->format('d M Y') }}</td>
                            <td>{{ $detail->jumlah_pekerja }}</td>
                            <td>{{ $detail->jam_kerja }}</td>
                            <td>{{ $normalHours }}</td>
                            <td>{{ $detail->jumlah_pekerja_lembur }}</td>
                            <td>{{ $detail->jam_lembur }}</td>
                            <td>{{ $overtimeHours }}</td>
                            <td>{{ $totalHours }}</td>
                            <td>{{ $detail->cuti }}</td>
                            <td>{{ $detail->ijin }}</td>
                            <td>{{ $detail->sakit }}</td>
                            <td>{{ $detail->alpha }}</td>
                            <td>{{ $lostHours }}</td>
                            <td>{{ $safeWorkHours }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"><strong>Total</strong></td>
                        <td>{{ $totalNormalHours }}</td>
                        <td>-</td>
                        <td>-</td>
                        <td>{{ $totalOvertimeHours }}</td>
                        <td>{{ $totalWorkHours }}</td>
                        <td>{{ $totalCuti }}</td>
                        <td>{{ $totalIjin }}</td>
                        <td>{{ $totalSakit }}</td>
                        <td>{{ $totalAlpha }}</td>
                        <td>{{ $totalLostHours }}</td>
                        <td>{{ $totalSafeWorkHours }}</td>
                    </tr>
                </tfoot>
            </table>

            @php $hse = $schedule->hseMonthlyReport; @endphp
            @if ($hse)
                <section class="mt-5 mb-3">
                    <div class="section-title mb-3">Data Statistik HSE Periode {{ $schedule->periode_laporan }}</div>
                    <table class="table table-bordered text-center align-middle" border="1" cellpadding="5"
                        cellspacing="0" style="width: 100%; border-collapse: collapse;">
                        <thead class="table-light" style="background-color: #f8f9fa;">
                            <tr>
                                <th>Keterangan</th>
                                <th>Bulan Lalu</th>
                                <th>Bulan Ini</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-start">Jumlah Hari Kerja</td>
                                <td>{{ $hse->hari_kerja_bulan_lalu ?? '-' }}</td>
                                <td>{{ $hse->hari_kerja_bulan_ini ?? '-' }}</td>
                                <td>{{ $hse->hari_kerja_total ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-start">Jumlah Manhours (Termasuk Lembur)</td>
                                <td>{{ $hse->manhours_lembur_bulan_lalu ?? '-' }}</td>
                                <td>{{ $hse->manhours_lembur_bulan_ini ?? '-' }}</td>
                                <td>{{ $hse->manhours_lembur_total ?? '-' }}</td>
                            </tr>
                        </tbody>
                        <tfoot class="table-light" style="background-color: #f8f9fa;">
                            <tr>
                                <td class="text-start">Jumlah Pekerja Kontraktor Utama</td>
                                <td colspan="2">{{ $hse->pekerja_kontraktor_utama ?? '-' }}</td>
                                <td>Orang</td>
                            </tr>
                            <tr>
                                <td class="text-start">Jumlah Pekerja Subkontraktor</td>
                                <td colspan="2">{{ $hse->pekerja_subkon ?? '-' }}</td>
                                <td>Orang</td>
                            </tr>
                            <tr>
                                <td class="text-start">Total Jumlah Pekerja</td>
                                <td colspan="2">{{ $hse->total_pekerja ?? '-' }}</td>
                                <td>Orang</td>
                            </tr>
                        </tfoot>
                    </table>
                </section>


                {{-- 2. Data Tim HSE --}}
                <section class="mb-5">
                    <h5 class="fw-semibold mb-3">2. Data Tim HSE</h5>
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Jabatan</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-start">HSE Manager</td>
                                <td>{{ $hse->hse_manager ?? '-' }}</td>
                                <td>Orang</td>
                            </tr>
                            <tr>
                                <td class="text-start">HSE Coordinator</td>
                                <td>{{ $hse->hse_coordinator ?? '-' }}</td>
                                <td>Orang</td>
                            </tr>
                            <tr>
                                <td class="text-start">HSE Supervisor</td>
                                <td>{{ $hse->hse_supervisor ?? '-' }}</td>
                                <td>Orang</td>
                            </tr>
                            <tr>
                                <td class="text-start">Safety Engineer</td>
                                <td>{{ $hse->safety_engineer ?? '-' }}</td>
                                <td>Orang</td>
                            </tr>
                            <tr>
                                <td class="text-start">Safety Officer</td>
                                <td>{{ $hse->safety_officer ?? '-' }}</td>
                                <td>Orang</td>
                            </tr>
                            <tr>
                                <td class="text-start">Safety Inspector</td>
                                <td>{{ $hse->safety_inspector ?? '-' }}</td>
                                <td>Orang</td>
                            </tr>
                            <tr>
                                <td class="text-start">Safety Administration</td>
                                <td>{{ $hse->safety_administration ?? '-' }}</td>
                                <td>Orang</td>
                            </tr>
                            <tr>
                                <td class="text-start">Safety Man</td>
                                <td>{{ $hse->safety_man ?? '-' }}</td>
                                <td>Orang</td>
                            </tr>
                            <tr>
                                <td class="text-start">Paramedis</td>
                                <td>{{ $hse->paramedis ?? '-' }}</td>
                                <td>Orang</td>
                            </tr>
                        </tbody>
                    </table>
                </section>

                {{-- 3. Data Kasus Insiden --}}
                <section class="mt-5 mb-3">
                    <h5 class="fw-semibold mb-3">3. Data Kasus Insiden</h5>
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Keterangan</th>
                                <th>Bulan Ini</th>
                                <th>Kumulatif</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-start">Jumlah Kasus Insiden</td>
                                <td>{{ $hse->kasus_insiden_bulan_ini ?? '-' }}</td>
                                <td>{{ $hse->kasus_insiden_total ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </section>


                {{-- 4. Rincian Data Insiden --}}
                <section class="mt-5 mb-3">
                    <h5 class="fw-semibold mb-3">4. Rincian Data Insiden</h5>
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Keterangan</th>
                                <th>Bulan Ini</th>
                                <th>Kumulatif</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-start">Fatality / Kematian</td>
                                <td>{{ $hse->fatality_bulan_ini ?? '-' }}</td>
                                <td>{{ $hse->fatality_total ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-start">Disability / Cacat Permanen</td>
                                <td>{{ $hse->disability_bulan_ini ?? '-' }}</td>
                                <td>{{ $hse->disability_total ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-start">Medical Treatment / Perawatan Medis</td>
                                <td>{{ $hse->medical_bulan_ini ?? '-' }}</td>
                                <td>{{ $hse->medical_total ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-start">First Aid / P3K</td>
                                <td>{{ $hse->first_aid_bulan_ini ?? '-' }}</td>
                                <td>{{ $hse->first_aid_total ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-start">Property Damage</td>
                                <td>{{ $hse->property_damage_bulan_ini ?? '-' }}</td>
                                <td>{{ $hse->property_damage_total ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-start">Traffic Accident</td>
                                <td>{{ $hse->traffic_accident_bulan_ini ?? '-' }}</td>
                                <td>{{ $hse->traffic_accident_total ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-start">Near Miss</td>
                                <td>{{ $hse->near_miss_bulan_ini ?? '-' }}</td>
                                <td>{{ $hse->near_miss_total ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-start">Lost Time Injury</td>
                                <td>{{ $hse->lost_time_bulan_ini ?? '-' }}</td>
                                <td>{{ $hse->lost_time_total ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </section>

                {{-- 5. Data Kasus Penyakit --}}
                <section class="mt-5 mb-3">
                    <h5 class="fw-semibold mb-3">5. Data Kasus Penyakit</h5>
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Keterangan</th>
                                <th>Bulan Ini</th>
                                <th>Kumulatif</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-start">Jumlah Kasus Penyakit</td>
                                <td>{{ $hse->kasus_penyakit_bulan_ini ?? '-' }}</td>
                                <td>{{ $hse->kasus_penyakit_total ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </section>


                {{-- 6. Rincian Data Kasus Penyakit --}}
                <section class="mt-5 mb-3">
                    <h5 class="fw-semibold mb-3">6. Rincian Data Kasus Penyakit</h5>
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Keterangan</th>
                                <th>Bulan Ini</th>
                                <th>Kumulatif</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-start">Penyakit Akibat Kerja</td>
                                <td>{{ $hse->penyakit_kerja_bulan_ini ?? '-' }}</td>
                                <td>{{ $hse->penyakit_kerja_total ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-start">Penyakit Akibat Hubungan Kerja</td>
                                <td>{{ $hse->penyakit_hubungan_kerja_bulan_ini ?? '-' }}</td>
                                <td>{{ $hse->penyakit_hubungan_kerja_total ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-start">Penyakit Biasa</td>
                                <td>{{ $hse->penyakit_biasa_bulan_ini ?? '-' }}</td>
                                <td>{{ $hse->penyakit_biasa_total ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-start">Lost Time Injury</td>
                                <td>{{ $hse->lost_time_penyakit_bulan_ini ?? '-' }}</td>
                                <td>{{ $hse->lost_time_penyakit_total ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </section>

                {{-- 7. Kasus Pencemaran Lingkungan --}}
                <section class="mt-5 mb-3">
                    <h5 class="fw-semibold mb-3">7. Kasus Pencemaran Lingkungan</h5>
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Keterangan</th>
                                <th>Bulan Ini</th>
                                <th>Kumulatif</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-start">Jumlah Kasus Pencemaran</td>
                                <td>{{ $hse->kasus_pencemaran_bulan_ini ?? '-' }}</td>
                                <td>{{ $hse->kasus_pencemaran_total ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </section>

                {{-- 8. Rincian Pencemaran Lingkungan --}}
                <section class="mt-5 mb-3">
                    <h5 class="fw-semibold mb-3">8. Rincian Pencemaran Lingkungan</h5>
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Keterangan</th>
                                <th>Bulan Ini</th>
                                <th>Kumulatif</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-start">Pencemaran Air</td>
                                <td>{{ $hse->pencemaran_air_bulan_ini ?? '-' }}</td>
                                <td>{{ $hse->pencemaran_air_total ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-start">Pencemaran Udara</td>
                                <td>{{ $hse->pencemaran_udara_bulan_ini ?? '-' }}</td>
                                <td>{{ $hse->pencemaran_udara_total ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </section>


                {{-- 9. Laporan Bahaya --}}
                <section class="mb-5">
                    <h5 class="fw-semibold mb-3">9. Laporan Bahaya</h5>
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="text-start">Keterangan</th>
                                <th>Periode s/d Bulan Lalu</th>
                                <th>Periode Bulan Ini</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-start">Temuan</td>
                                <td>{{ $hse->bahaya_temuan_lalu ?? '-' }}</td>
                                <td>{{ $hse->bahaya_temuan_bulan_ini ?? '-' }}</td>
                                <td>{{ $hse->bahaya_temuan_total ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-start">Terselesaikan</td>
                                <td>{{ $hse->bahaya_selesai_lalu ?? '-' }}</td>
                                <td>{{ $hse->bahaya_selesai_bulan_ini ?? '-' }}</td>
                                <td>{{ $hse->bahaya_selesai_total ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-start">Sisa</td>
                                <td>{{ $hse->bahaya_sisa_lalu ?? '-' }}</td>
                                <td>{{ $hse->bahaya_sisa_bulan_ini ?? '-' }}</td>
                                <td>{{ $hse->bahaya_sisa_total ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </section>

                {{-- 10. Laporan Inspeksi HSE --}}
                <section class="mb-5">
                    <h5 class="fw-semibold mb-3">10. Laporan Inspeksi HSE</h5>
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="text-start">Keterangan</th>
                                <th>Periode s/d Bulan Lalu</th>
                                <th>Periode Bulan Ini</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-start">Temuan</td>
                                <td>{{ $hse->inspeksi_temuan_lalu ?? '-' }}</td>
                                <td>{{ $hse->inspeksi_temuan_bulan_ini ?? '-' }}</td>
                                <td>{{ $hse->inspeksi_temuan_total ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-start">Terselesaikan</td>
                                <td>{{ $hse->inspeksi_selesai_lalu ?? '-' }}</td>
                                <td>{{ $hse->inspeksi_selesai_bulan_ini ?? '-' }}</td>
                                <td>{{ $hse->inspeksi_selesai_total ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-start">Sisa</td>
                                <td>{{ $hse->inspeksi_sisa_lalu ?? '-' }}</td>
                                <td>{{ $hse->inspeksi_sisa_bulan_ini ?? '-' }}</td>
                                <td>{{ $hse->inspeksi_sisa_total ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </section>


                {{-- 11. Laporan Inspeksi Alat --}}
                <section class="mb-5">
                    <h5 class="fw-semibold mb-3">11. Laporan Inspeksi Alat</h5>
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="text-start">Keterangan</th>
                                <th>Periode s/d Bulan Lalu</th>
                                <th>Periode Bulan Ini</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-start">Temuan</td>
                                <td>{{ $hse->alat_temuan_lalu ?? '-' }}</td>
                                <td>{{ $hse->alat_temuan_bulan_ini ?? '-' }}</td>
                                <td>{{ $hse->alat_temuan_total ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-start">Terselesaikan</td>
                                <td>{{ $hse->alat_selesai_lalu ?? '-' }}</td>
                                <td>{{ $hse->alat_selesai_bulan_ini ?? '-' }}</td>
                                <td>{{ $hse->alat_selesai_total ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-start">Sisa</td>
                                <td>{{ $hse->alat_sisa_lalu ?? '-' }}</td>
                                <td>{{ $hse->alat_sisa_bulan_ini ?? '-' }}</td>
                                <td>{{ $hse->alat_sisa_total ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </section>


                {{-- 12. Kegiatan Bulan Ini --}}
                @php
                    $kegiatan = array_filter(explode("\n", $hse->kegiatan_bulan_ini));
                @endphp

                <section class="mb-5">
                    <h5 class="fw-semibold mb-3">12. Kegiatan Bulan Ini</h5>

                    @if (count($kegiatan))
                        <ol class="ps-4">
                            @foreach ($kegiatan as $item)
                                <li class="mb-2">{{ $item }}</li>
                            @endforeach
                        </ol>
                    @else
                        <p class="text-muted fst-italic">Tidak ada kegiatan yang dicatat bulan ini.</p>
                    @endif
                </section>

                @php
                    // Parsing pelatihan
                    $pelatihanList = [];
                    if (!empty($hse->pelatihan_bulan_ini)) {
                        $rows = explode("\n", $hse->pelatihan_bulan_ini);
                        foreach ($rows as $row) {
                            $fields = explode('|', $row);
                            $data = [];
                            foreach ($fields as $field) {
                                [$key, $value] = array_map('trim', explode(':', $field, 2));
                                $data[strtolower($key)] = $value ?? '-';
                            }
                            $pelatihanList[] = $data;
                        }
                    }

                    // Parsing induksi
                    $induksiList = [];
                    if (!empty($hse->induction_bulan_ini)) {
                        $rows = explode("\n", $hse->induction_bulan_ini);
                        foreach ($rows as $row) {
                            $fields = explode('|', $row);
                            $data = [];
                            foreach ($fields as $field) {
                                [$key, $value] = array_map('trim', explode(':', $field, 2));
                                $key = strtolower(str_replace(' ', '_', $key));
                                $data[$key] = $value ?? '-';
                            }
                            $induksiList[] = $data;
                        }
                    }
                @endphp

                <section class="mb-5">
                    <h5 class="fw-semibold mb-3">13. Pelatihan & HSE Induction</h5>

                    {{-- Pelatihan --}}
                    <h6>Pelatihan</h6>
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Perusahaan</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pelatihanList as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item['judul'] ?? '-' }}</td>
                                    <td>{{ $item['perusahaan'] ?? '-' }}</td>
                                    <td>{{ $item['jumlah'] ?? '-' }}</td>
                                    <td>{{ $item['keterangan'] ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-muted">Tidak ada data pelatihan bulan ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </section>

                {{-- Induksi --}}
                <h6 class="mt-4">HSE Induction</h6>
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Petugas</th>
                            <th>Jumlah Peserta</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($induksiList as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item['petugas'] ?? '-' }}</td>
                                <td>{{ $item['jumlah_peserta'] ?? '-' }}</td>
                                <td>{{ $item['keterangan'] ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-muted">Tidak ada data induksi bulan ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                </section>

                {{-- 14. Ringkasan & Permasalahan HSE --}}
                @php
                    $ringkasanList = array_filter(explode("\n", $hse->ringkasan_permasalahan));
                @endphp

                <section class="mb-5">
                    <h5 class="fw-semibold mb-3">14. Ringkasan & Permasalahan HSE</h5>
                    @if (count($ringkasanList))
                        <ol class="ps-4">
                            @foreach ($ringkasanList as $item)
                                <li class="mb-2">{{ $item }}</li>
                            @endforeach
                        </ol>
                    @else
                        <p class="text-muted fst-italic">Tidak ada permasalahan yang dicatat.</p>
                    @endif
                </section>

                {{-- 15. Daftar Lampiran --}}
                @php
                    $lampiranList = array_filter(explode("\n", $hse->daftar_lampiran));
                @endphp

                <section class="mb-5">
                    <h5 class="fw-semibold mb-3">15. Daftar Lampiran</h5>
                    @if (count($lampiranList))
                        <ol class="ps-4">
                            @foreach ($lampiranList as $item)
                                <li class="mb-2">{{ $item }}</li>
                            @endforeach
                        </ol>
                    @else
                        <p class="text-muted fst-italic">Tidak ada lampiran.</p>
                    @endif
                </section>

                {{-- 16. Rencana Kegiatan Bulan Depan --}}
                @php
                    $rencanaKegiatanList = array_filter(explode("\n", $hse->rencana_bulan_depan));
                @endphp

                <section class="mb-5">
                    <h5 class="fw-semibold mb-3">16. Rencana Kegiatan Bulan Depan</h5>
                    @if (count($rencanaKegiatanList))
                        <ol class="ps-4">
                            @foreach ($rencanaKegiatanList as $item)
                                <li class="mb-2">{{ $item }}</li>
                            @endforeach
                        </ol>
                    @else
                        <p class="text-muted fst-italic">Tidak ada rencana kegiatan yang dicatat.</p>
                    @endif
                </section>
            @endif
            <div class="page-break"></div>
        @endforeach
    @endif
    <div class="footer">
        Laporan ini dihasilkan oleh sistem Work Permit &mdash; {{ now()->format('d M Y H:i') }}
    </div>
</body>
</html>
