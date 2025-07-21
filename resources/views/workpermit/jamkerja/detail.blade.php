@extends('layouts.master')
@section('title', 'Detail Jam Kerja Aman')
@section('header', 'Detail Jam Kerja Aman')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flatpickr/flatpickr.min.css') }}">
    <style>
        .card-header h5 {
            font-weight: 600;
            font-size: 1.25rem;
            margin: 0;
        }

        label {
            font-weight: 500;
            color: #4f4f4f;
        }

        .form-control[readonly] {
            background-color: #f8f9fc;
            font-weight: 500;
            border-color: #dee2e6;
        }

        #jamKerjaTable th,
        #jamKerjaTable td {
            vertical-align: middle;
            font-size: 14px;
        }

        #jamKerjaTable thead th {
            background-color: #f1f3f7;
            font-weight: 600;
        }

        #jamKerjaTable tfoot {
            background-color: #f9f9f9;
            font-weight: 600;
        }

        .table-responsive {
            border-radius: 0.5rem;
            overflow-x: auto;
        }

        .breadcrumb {
            background: none;
            padding: 0;
            margin-bottom: 0;
        }
    </style>
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                        <div class="col-sm-6 col-12">
                        <h2 class="fw-bold">Detail Jam Kerja Aman</h2>
                    </div>
                        <div class="col-sm-6 col-12">
                        <ol class="breadcrumb float-end">
                            <li class="breadcrumb-item"><a href="#"><i class="iconly-Home icli svg-color"></i></a>
                            </li>
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Detail Jam Kerja Aman</li>
                        </ol>
                    </div>
                </div>
            </div>

            {{-- Card --}}
            <div class="card shadow-sm">
                <div class="card-body">

                    {{-- Informasi Umum --}}
                    <h5 class="mb-3">Informasi Pekerjaan</h5>
                    <div class="card shadow-sm rounded-3 mb-4">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Nomor PO</label>
                                    <input type="text" class="form-control"
                                        value="{{ $workPermit->purchaseOrder->no_po ?? '-' }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Nama Proyek</label>
                                    <input type="text" class="form-control"
                                        value="{{ $workPermit->purchaseOrder->nama_pekerjaan ?? '-' }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Lokasi Kerja</label>
                                    <input type="text" class="form-control"
                                        value="{{ $workPermit->purchaseOrder->lokasi_pekerjaan ?? '-' }}" readonly>
                                </div>

                                <div class="col-md-4 mt-3">
                                    <label class="form-label fw-semibold">Periode Laporan</label>
                                    <input type="text" class="form-control" value="{{ $schedule->periode_laporan }}"
                                        readonly>
                                </div>

                                <div class="col-md-4 mt-3">
                                    <label class="form-label fw-semibold">Lampiran Daftar Hadir</label>
                                    @if ($schedule?->lampiran_induction)
                                        @php
                                            $ext = strtolower(
                                                pathinfo($schedule->lampiran_induction, PATHINFO_EXTENSION),
                                            );
                                        @endphp
                                        <a href="{{ asset('storage/' . $schedule->lampiran_induction) }}" target="_blank"
                                            class="btn btn-outline-primary w-100">
                                            <i class="bi bi-eye"></i> Lihat Lampiran
                                        </a>
                                    @else
                                        <input type="text" class="form-control text-muted"
                                            value="Tidak ada file lampiran." readonly>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4 mt-3">
                                <a href="{{ route('permit.jamkerja.preview', [
                                    'id' => encodeId($workPermit->id),
                                    'periode' => substr($schedule->periode_laporan, 0, 7),
                                ]) }}"
                                    class="btn btn-primary" target="_blank">
                                    Preview PDF
                                </a>
                            </div>
                        </div>
                    </div>

                    <h5 class="mb-3">Status Approval SHE</h5>
                    <div class="card shadow-sm rounded-3 mb-4">
                        <div class="card-body">
                            @php
                                $status = $schedule->status_approve_she;
                                $approvedAt = $schedule->approved_at
                                    ? \Carbon\Carbon::parse($schedule->approved_at)->format('d M Y, H:i')
                                    : null;
                            @endphp

                            @if ($status === 'approved')
                                <span class="badge bg-success fs-6">Disetujui SHE</span>
                                <p class="mt-2 mb-0 text-muted">Tanggal Disetujui: <strong>{{ $approvedAt }}</strong></p>
                            @elseif ($status === 'rejected')
                                <span class="badge bg-danger fs-6">Ditolak SHE</span>
                                <p class="mt-2 mb-1 text-muted">Tanggal Ditolak: <strong>{{ $approvedAt }}</strong></p>
                                <p class="mb-0"><strong>Alasan Penolakan:</strong> {{ $schedule->alasan_reject }}</p>
                            @else
                                <span class="badge bg-warning text-dark fs-6">Menunggu Persetujuan</span>
                            @endif
                        </div>
                    </div>


                    {{-- Tabel Detail --}}
                    <div class="mt-5">
                        <h5 class="mb-3">Rincian Jam Kerja</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle text-center" id="jamKerjaTable">
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
                                            <td>{{ \Carbon\Carbon::parse($detail->tanggal)->translatedFormat('d M Y') }}
                                            </td>
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
                                        <td>—</td>
                                        <td>—</td>
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
                        </div>
                    </div>

                    {{-- 1. Data Statistik HSE --}}
                    <section class="mt-5 mb-3">
                        <h5 class="fw-semibold mb-3">1. Data Statistik HSE</h5>
                        <table class="table table-bordered text-center align-middle">
                            <thead class="table-light">
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
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->hari_kerja_bulan_lalu }}"></td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->hari_kerja_bulan_ini }}"></td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->hari_kerja_total }}"></td>
                                </tr>
                                <tr>
                                    <td class="text-start">Jumlah Manhours (Termasuk Lembur)</td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->manhours_lembur_bulan_lalu }}"></td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->manhours_lembur_bulan_ini }}"></td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->manhours_lembur_total }}"></td>
                                </tr>
                                {{-- <tr>
                                    <td class="text-start">Jumlah Manhours Subkontraktor</td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->manhours_subkon_bulan_lalu }}"></td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->manhours_subkon_bulan_ini }}"></td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->manhours_subkon_total }}"></td>
                                </tr>
                                <tr>
                                    <td class="text-start">Total Jumlah Manhours</td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->total_manhours_bulan_lalu }}"></td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->total_manhours_bulan_ini }}"></td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->total_manhours_total }}"></td>
                                </tr> --}}
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td class="text-start">Jumlah Pekerja Kontraktor Utama</td>
                                    <td colspan="2"><input type="number" class="form-control" readonly
                                            value="{{ $hse->pekerja_kontraktor_utama }}"></td>
                                    <td>Orang</td>
                                </tr>
                                <tr>
                                    <td class="text-start">Jumlah Pekerja Subkontraktor</td>
                                    <td colspan="2"><input type="number" class="form-control" readonly
                                            value="{{ $hse->pekerja_subkon }}"></td>
                                    <td>Orang</td>
                                </tr>
                                <tr>
                                    <td class="text-start">Total Jumlah Pekerja</td>
                                    <td colspan="2"><input type="number" class="form-control" readonly
                                            value="{{ $hse->total_pekerja }}"></td>
                                    <td>Orang</td>
                                </tr>
                            </tfoot>
                        </table>
                    </section>

                    {{-- 2. Tim HSE (View Only) --}}
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
                                    <td><input type="number" class="form-control" value="{{ $hse->hse_manager }}"
                                            disabled></td>
                                    <td>Orang</td>
                                </tr>
                                <tr>
                                    <td class="text-start">HSE Coordinator</td>
                                    <td><input type="number" class="form-control" value="{{ $hse->hse_coordinator }}"
                                            disabled></td>
                                    <td>Orang</td>
                                </tr>
                                <tr>
                                    <td class="text-start">HSE Supervisor</td>
                                    <td><input type="number" class="form-control" value="{{ $hse->hse_supervisor }}"
                                            disabled></td>
                                    <td>Orang</td>
                                </tr>
                                <tr>
                                    <td class="text-start">Safety Engineer</td>
                                    <td><input type="number" class="form-control" value="{{ $hse->safety_engineer }}"
                                            disabled></td>
                                    <td>Orang</td>
                                </tr>
                                <tr>
                                    <td class="text-start">Safety Officer</td>
                                    <td><input type="number" class="form-control" value="{{ $hse->safety_officer }}"
                                            disabled></td>
                                    <td>Orang</td>
                                </tr>
                                <tr>
                                    <td class="text-start">Safety Inspector</td>
                                    <td><input type="number" class="form-control" value="{{ $hse->safety_inspector }}"
                                            disabled></td>
                                    <td>Orang</td>
                                </tr>
                                <tr>
                                    <td class="text-start">Safety Administration</td>
                                    <td><input type="number" class="form-control"
                                            value="{{ $hse->safety_administration }}" disabled></td>
                                    <td>Orang</td>
                                </tr>
                                <tr>
                                    <td class="text-start">Safety Man</td>
                                    <td><input type="number" class="form-control" value="{{ $hse->safety_man }}"
                                            disabled></td>
                                    <td>Orang</td>
                                </tr>
                                <tr>
                                    <td class="text-start">Paramedis</td>
                                    <td><input type="number" class="form-control" value="{{ $hse->paramedis }}"
                                            disabled></td>
                                    <td>Orang</td>
                                </tr>
                            </tbody>
                        </table>
                    </section>

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
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->kasus_insiden_bulan_ini }}"></td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->kasus_insiden_total }}"></td>
                                </tr>
                            </tbody>
                        </table>
                    </section>

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
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->fatality_bulan_ini }}"></td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->fatality_total }}"></td>
                                </tr>
                                <tr>
                                    <td class="text-start">Disability / Cacat Permanen</td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->disability_bulan_ini }}"></td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->disability_total }}"></td>
                                </tr>
                                <tr>
                                    <td class="text-start">Medical Treatment / Perawatan Medis</td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->medical_bulan_ini }}"></td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->medical_total }}"></td>
                                </tr>
                                <tr>
                                    <td class="text-start">First Aid / P3K</td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->first_aid_bulan_ini }}"></td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->first_aid_total }}"></td>
                                </tr>
                                <tr>
                                    <td class="text-start">Property Damage</td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->property_damage_bulan_ini }}"></td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->property_damage_total }}"></td>
                                </tr>
                                <tr>
                                    <td class="text-start">Traffic Accident</td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->traffic_accident_bulan_ini }}"></td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->traffic_accident_total }}"></td>
                                </tr>
                                <tr>
                                    <td class="text-start">Near Miss</td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->near_miss_bulan_ini }}"></td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->near_miss_total }}"></td>
                                </tr>
                                <tr>
                                    <td class="text-start">Lost Time Injury</td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->lost_time_bulan_ini }}"></td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->lost_time_total }}"></td>
                                </tr>
                            </tbody>
                        </table>
                    </section>

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
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->kasus_penyakit_bulan_ini }}"></td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->kasus_penyakit_total }}"></td>
                                </tr>
                            </tbody>
                        </table>
                    </section>

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
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->penyakit_kerja_bulan_ini }}"></td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->penyakit_kerja_total }}"></td>
                                </tr>
                                <tr>
                                    <td class="text-start">Penyakit Akibat Hubungan Kerja</td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->penyakit_hubungan_kerja_bulan_ini }}"></td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->penyakit_hubungan_kerja_total }}"></td>
                                </tr>
                                <tr>
                                    <td class="text-start">Penyakit Biasa</td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->penyakit_biasa_bulan_ini }}"></td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->penyakit_biasa_total }}"></td>
                                </tr>
                                <tr>
                                    <td class="text-start">Lost Time Injury</td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->lost_time_penyakit_bulan_ini }}"></td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->lost_time_penyakit_total }}"></td>
                                </tr>
                            </tbody>
                        </table>
                    </section>

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
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->kasus_pencemaran_bulan_ini }}"></td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->kasus_pencemaran_total }}"></td>
                                </tr>
                            </tbody>
                        </table>
                    </section>

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
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->pencemaran_air_bulan_ini }}"></td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->pencemaran_air_total }}"></td>
                                </tr>
                                <tr>
                                    <td class="text-start">Pencemaran Udara</td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->pencemaran_udara_bulan_ini }}"></td>
                                    <td><input type="number" class="form-control" readonly
                                            value="{{ $hse->pencemaran_udara_total }}"></td>
                                </tr>
                            </tbody>
                        </table>
                    </section>

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
                                    <td><input type="number" value="{{ $hse->bahaya_temuan_lalu }}"
                                            class="form-control" readonly></td>
                                    <td><input type="number" value="{{ $hse->bahaya_temuan_bulan_ini }}"
                                            class="form-control" readonly></td>
                                    <td><input type="number" value="{{ $hse->bahaya_temuan_total }}"
                                            class="form-control" readonly></td>
                                </tr>
                                <tr>
                                    <td class="text-start">Terselesaikan</td>
                                    <td><input type="number" value="{{ $hse->bahaya_selesai_lalu }}"
                                            class="form-control" readonly></td>
                                    <td><input type="number" value="{{ $hse->bahaya_selesai_bulan_ini }}"
                                            class="form-control" readonly></td>
                                    <td><input type="number" value="{{ $hse->bahaya_selesai_total }}"
                                            class="form-control" readonly></td>
                                </tr>
                                <tr>
                                    <td class="text-start">Sisa</td>
                                    <td><input type="number" value="{{ $hse->bahaya_sisa_lalu }}" class="form-control"
                                            readonly></td>
                                    <td><input type="number" value="{{ $hse->bahaya_sisa_bulan_ini }}"
                                            class="form-control" readonly></td>
                                    <td><input type="number" value="{{ $hse->bahaya_sisa_total }}" class="form-control"
                                            readonly></td>
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
                                    <td><input type="number" value="{{ $hse->inspeksi_temuan_lalu }}"
                                            class="form-control" readonly></td>
                                    <td><input type="number" value="{{ $hse->inspeksi_temuan_bulan_ini }}"
                                            class="form-control" readonly></td>
                                    <td><input type="number" value="{{ $hse->inspeksi_temuan_total }}"
                                            class="form-control" readonly></td>
                                </tr>
                                <tr>
                                    <td class="text-start">Terselesaikan</td>
                                    <td><input type="number" value="{{ $hse->inspeksi_selesai_lalu }}"
                                            class="form-control" readonly></td>
                                    <td><input type="number" value="{{ $hse->inspeksi_selesai_bulan_ini }}"
                                            class="form-control" readonly></td>
                                    <td><input type="number" value="{{ $hse->inspeksi_selesai_total }}"
                                            class="form-control" readonly></td>
                                </tr>
                                <tr>
                                    <td class="text-start">Sisa</td>
                                    <td><input type="number" value="{{ $hse->inspeksi_sisa_lalu }}"
                                            class="form-control" readonly></td>
                                    <td><input type="number" value="{{ $hse->inspeksi_sisa_bulan_ini }}"
                                            class="form-control" readonly></td>
                                    <td><input type="number" value="{{ $hse->inspeksi_sisa_total }}"
                                            class="form-control" readonly></td>
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
                                    <td><input type="number" value="{{ $hse->alat_temuan_lalu }}" class="form-control"
                                            readonly></td>
                                    <td><input type="number" value="{{ $hse->alat_temuan_bulan_ini }}"
                                            class="form-control" readonly></td>
                                    <td><input type="number" value="{{ $hse->alat_temuan_total }}"
                                            class="form-control" readonly></td>
                                </tr>
                                <tr>
                                    <td class="text-start">Terselesaikan</td>
                                    <td><input type="number" value="{{ $hse->alat_selesai_lalu }}"
                                            class="form-control" readonly></td>
                                    <td><input type="number" value="{{ $hse->alat_selesai_bulan_ini }}"
                                            class="form-control" readonly></td>
                                    <td><input type="number" value="{{ $hse->alat_selesai_total }}"
                                            class="form-control" readonly></td>
                                </tr>
                                <tr>
                                    <td class="text-start">Sisa</td>
                                    <td><input type="number" value="{{ $hse->alat_sisa_lalu }}" class="form-control"
                                            readonly></td>
                                    <td><input type="number" value="{{ $hse->alat_sisa_bulan_ini }}"
                                            class="form-control" readonly></td>
                                    <td><input type="number" value="{{ $hse->alat_sisa_total }}" class="form-control"
                                            readonly></td>
                                </tr>
                            </tbody>
                        </table>
                    </section>

                    {{-- 12. Kegiatan Bulan Ini --}}
                    @php
                        $kegiatan = explode("\n", $hse->kegiatan_bulan_ini);
                    @endphp

                    <section class="mb-5">
                        <h5 class="fw-semibold mb-3">12. Kegiatan Bulan Ini</h5>
                        <ol class="ps-4">
                            <li class="mb-2">
                                <input type="text" value="{{ $kegiatan[0] ?? '' }}" class="form-control" readonly>
                            </li>
                            <li class="mb-2">
                                <input type="text" value="{{ $kegiatan[1] ?? '' }}" class="form-control" readonly>
                            </li>
                            <li class="mb-2">
                                <input type="text" value="{{ $kegiatan[2] ?? '' }}" class="form-control" readonly>
                            </li>
                        </ol>
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
                                    $data[strtolower($key)] = $value;
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
                                    $data[$key] = $value;
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
                                <tr>
                                    <td>1</td>
                                    <td><input type="text" value="{{ $pelatihanList[0]['judul'] ?? '' }}"
                                            class="form-control" readonly></td>
                                    <td><input type="text" value="{{ $pelatihanList[0]['perusahaan'] ?? '' }}"
                                            class="form-control" readonly></td>
                                    <td><input type="number" value="{{ $pelatihanList[0]['jumlah'] ?? '' }}"
                                            class="form-control" readonly></td>
                                    <td><input type="text" value="{{ $pelatihanList[0]['keterangan'] ?? '' }}"
                                            class="form-control" readonly></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td><input type="text" value="{{ $pelatihanList[1]['judul'] ?? '' }}"
                                            class="form-control" readonly></td>
                                    <td><input type="text" value="{{ $pelatihanList[1]['perusahaan'] ?? '' }}"
                                            class="form-control" readonly></td>
                                    <td><input type="number" value="{{ $pelatihanList[1]['jumlah'] ?? '' }}"
                                            class="form-control" readonly></td>
                                    <td><input type="text" value="{{ $pelatihanList[1]['keterangan'] ?? '' }}"
                                            class="form-control" readonly></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td><input type="text" value="{{ $pelatihanList[2]['judul'] ?? '' }}"
                                            class="form-control" readonly></td>
                                    <td><input type="text" value="{{ $pelatihanList[2]['perusahaan'] ?? '' }}"
                                            class="form-control" readonly></td>
                                    <td><input type="number" value="{{ $pelatihanList[2]['jumlah'] ?? '' }}"
                                            class="form-control" readonly></td>
                                    <td><input type="text" value="{{ $pelatihanList[2]['keterangan'] ?? '' }}"
                                            class="form-control" readonly></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td><input type="text" value="{{ $pelatihanList[3]['judul'] ?? '' }}"
                                            class="form-control" readonly></td>
                                    <td><input type="text" value="{{ $pelatihanList[3]['perusahaan'] ?? '' }}"
                                            class="form-control" readonly></td>
                                    <td><input type="number" value="{{ $pelatihanList[3]['jumlah'] ?? '' }}"
                                            class="form-control" readonly></td>
                                    <td><input type="text" value="{{ $pelatihanList[3]['keterangan'] ?? '' }}"
                                            class="form-control" readonly></td>
                                </tr>
                            </tbody>
                        </table>

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
                                <tr>
                                    <td>1</td>
                                    <td><input type="text" value="{{ $induksiList[0]['petugas'] ?? '' }}"
                                            class="form-control" readonly></td>
                                    <td><input type="number" value="{{ $induksiList[0]['jumlah_peserta'] ?? '' }}"
                                            class="form-control" readonly></td>
                                    <td><input type="text" value="{{ $induksiList[0]['keterangan'] ?? '' }}"
                                            class="form-control" readonly></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td><input type="text" value="{{ $induksiList[1]['petugas'] ?? '' }}"
                                            class="form-control" readonly></td>
                                    <td><input type="number" value="{{ $induksiList[1]['jumlah_peserta'] ?? '' }}"
                                            class="form-control" readonly></td>
                                    <td><input type="text" value="{{ $induksiList[1]['keterangan'] ?? '' }}"
                                            class="form-control" readonly></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td><input type="text" value="{{ $induksiList[2]['petugas'] ?? '' }}"
                                            class="form-control" readonly></td>
                                    <td><input type="number" value="{{ $induksiList[2]['jumlah_peserta'] ?? '' }}"
                                            class="form-control" readonly></td>
                                    <td><input type="text" value="{{ $induksiList[2]['keterangan'] ?? '' }}"
                                            class="form-control" readonly></td>
                                </tr>
                            </tbody>
                        </table>
                    </section>

                    {{-- 14. Ringkasan & Permasalahan HSE --}}
                    @php
                        $ringkasanList = [];
                        if (!empty($hse->ringkasan_permasalahan)) {
                            $ringkasanList = explode("\n", $hse->ringkasan_permasalahan);
                        }
                    @endphp

                    <section class="mb-5">
                        <h5 class="fw-semibold mb-3">14. Ringkasan & Permasalahan HSE</h5>
                        <ol class="ps-4">
                            <li class="mb-2">
                                <input type="text" value="{{ $ringkasanList[0] ?? '' }}" class="form-control"
                                    readonly>
                            </li>
                            <li class="mb-2">
                                <input type="text" value="{{ $ringkasanList[1] ?? '' }}" class="form-control"
                                    readonly>
                            </li>
                            <li class="mb-2">
                                <input type="text" value="{{ $ringkasanList[2] ?? '' }}" class="form-control"
                                    readonly>
                            </li>
                        </ol>
                    </section>

                    @php
                        $lampiranList = [];
                        if (!empty($hse->daftar_lampiran)) {
                            $lampiranList = explode("\n", $hse->daftar_lampiran);
                        }
                    @endphp

                    <section class="mb-5">
                        <h5 class="fw-semibold mb-3">15. Daftar Lampiran</h5>
                        <ol class="ps-4">
                            <li class="mb-2">
                                <input type="text" value="{{ $lampiranList[0] ?? '' }}" class="form-control"
                                    readonly>
                            </li>
                            <li class="mb-2">
                                <input type="text" value="{{ $lampiranList[1] ?? '' }}" class="form-control"
                                    readonly>
                            </li>
                            <li class="mb-2">
                                <input type="text" value="{{ $lampiranList[2] ?? '' }}" class="form-control"
                                    readonly>
                            </li>
                        </ol>
                    </section>

                    {{-- 16. Rencana Kegiatan Bulan Depan --}}
                    @php
                        $rencanaKegiatanList = [];
                        if (!empty($hse->rencana_bulan_depan)) {
                            $rencanaKegiatanList = explode("\n", $hse->rencana_bulan_depan);
                        }
                    @endphp

                    <section class="mb-5">
                        <h5 class="fw-semibold mb-3">16. Rencana Kegiatan Bulan Depan</h5>
                        <ol class="ps-4">
                            <li class="mb-2">
                                <input type="text" value="{{ $rencanaKegiatanList[0] ?? '' }}" class="form-control"
                                    readonly>
                            </li>
                            <li class="mb-2">
                                <input type="text" value="{{ $rencanaKegiatanList[1] ?? '' }}" class="form-control"
                                    readonly>
                            </li>
                            <li class="mb-2">
                                <input type="text" value="{{ $rencanaKegiatanList[2] ?? '' }}" class="form-control"
                                    readonly>
                            </li>
                        </ol>
                    </section>

                    @if ($canApproveShe && $schedule->status_approve_she === 'pending')
                        <button class="btn btn-success" id="btn-approve">Approve</button>
                        <button class="btn btn-danger" id="btn-reject">Reject</button>
                    @endif

                    <a href="{{ route('permit.jamkerja.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $('#btn-approve').on('click', function() {
            const id = '{{ encodeId($schedule->id) }}';
            Swal.fire({
                title: 'Yakin ingin menyetujui?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Setujui'
            }).then(result => {
                if (result.isConfirmed) {
                    $.post(`/permit/jam-kerja/${id}/approve-she`, {
                            _token: '{{ csrf_token() }}'
                        })
                        .done(res => {
                            Swal.fire('Berhasil', res.message, 'success')
                                .then(() => location.reload());
                        });
                }
            });
        });

        $('#btn-reject').on('click', function() {
            const id = '{{ encodeId($schedule->id) }}';
            Swal.fire({
                title: 'Alasan Penolakan',
                input: 'textarea',
                inputLabel: 'Tulis alasan',
                showCancelButton: true,
                confirmButtonText: 'Tolak',
                preConfirm: (alasan) => {
                    if (!alasan) {
                        Swal.showValidationMessage('Alasan wajib diisi');
                    }
                    return alasan;
                }
            }).then(result => {
                if (result.isConfirmed) {
                    $.post(`/permit/jam-kerja/${id}/reject-she`, {
                        _token: '{{ csrf_token() }}',
                        alasan_reject: result.value
                    }).done(res => {
                        Swal.fire('Ditolak', res.message, 'success')
                            .then(() => location.reload());
                    });
                }
            });
        });
    </script>
@endsection
