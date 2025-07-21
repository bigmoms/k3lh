@extends('layouts.master')
@section('title', 'Tambah Data Jam Kerja Aman')
@section('header', 'Tambah Data Jam Kerja Aman')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flatpickr/flatpickr.min.css') }}">
    <style>
        #jamKerjaTable input.form-control {
            min-width: 110px;
            padding: 4px 8px;
        }

        thead th {
            background-color: #f5f7fa;
            text-align: center;
            vertical-align: middle;
        }

        tfoot {
            background-color: #f0f2f5;
        }

        tfoot td {
            font-weight: bold;
        }

        .form-control[readonly] {
            background-color: #f9f9f9;
            font-weight: 500;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
    </style>
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-sm-6 col-12">
                        <h2>Tambah Data Jam Kerja Aman</h2>
                    </div>
                    <div class="col-sm-6 col-12">
                        <ol class="breadcrumb float-end">
                            <li class="breadcrumb-item"><a href="#"><i class="iconly-Home icli svg-color"></i></a>
                            </li>
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Tambah Jam Kerja Aman</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <form id="jamKerjaForm" method="POST">
                    @csrf
                    <input type="hidden" name="work_permit_id" id="work_permit_id" value="{{ $workPermit->id }}">
                    <div class="card">
                        <div class="card-body">
                            {{-- Informasi PO --}}
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label>Nomor PO</label>
                                    <input type="text" class="form-control"
                                        value="{{ $workPermit->purchaseOrder->no_po ?? '-' }}" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label>Nama Proyek</label>
                                    <input type="text" class="form-control"
                                        value="{{ $workPermit->purchaseOrder->nama_pekerjaan ?? '-' }}" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label>Lokasi Kerja</label>
                                    <input type="text" class="form-control"
                                        value="{{ $workPermit->purchaseOrder->lokasi_pekerjaan ?? '-' }}" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label>Project Manager</label>
                                    <input type="text" name="project_manager" class="form-control" required
                                        placeholder="Nama Project Manager">
                                </div>
                            </div>

                            {{-- Periode --}}
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label>Lampiran Daftar Hadir Safety Induction</label>
                                    <input type="file" name="lampiran_induction" class="form-control"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                </div>
                                <div class="col-md-4">
                                    <label>Periode Laporan</label>
                                    <input type="text" class="form-control" id="periode"
                                        placeholder="Pilih rentang tanggal" autocomplete="off">
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="button" class="btn btn-info" id="generateBtn">Generate</button>
                                </div>
                            </div>

                            {{-- Tabel Input --}}
                            <div class="table-responsive">
                                <table class="table table-bordered text-center align-middle" id="jamKerjaTable"
                                    style="display:none;">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Tanggal</th>
                                            <th rowspan="2">Jumlah Pekerja</th>
                                            <th rowspan="2">Jam Kerja</th>
                                            <th rowspan="2">Jumlah Jam Kerja Nyata</th>
                                            <th rowspan="2">Jumlah Pekerja Lembur</th>
                                            <th rowspan="2">Jam Lembur</th>
                                            <th rowspan="2">Jumlah Jam Lembur</th>
                                            <th rowspan="2">Jumlah Jam Kerja Real</th>
                                            <th colspan="4">Kehilangan Jam Kerja</th>
                                            <th rowspan="2">Jumlah Kehilangan Jam</th>
                                            <th rowspan="2">Total Jam Kerja Aman</th>
                                        </tr>
                                        <tr>
                                            <th>Cuti</th>
                                            <th>Ijin</th>
                                            <th>Sakit</th>
                                            <th>Alpha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Baris akan digenerate JS --}}
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-center">Total</td>
                                            <td id="total-d">0</td>
                                            <td>—</td>
                                            <td>—</td>
                                            <td id="total-g">0</td>
                                            <td id="total-h">0</td>
                                            <td id="total-i">0</td>
                                            <td id="total-j">0</td>
                                            <td id="total-k">0</td>
                                            <td id="total-l">0</td>
                                            <td id="total-m">0</td>
                                            <td id="total-n">0</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            {{-- HSE Monthly Report --}}
                            <div class="mt-5">
                                <h4 class="fw-bold border-bottom pb-2 mb-4">📋 Laporan HSE Bulanan</h4>

                                {{-- 1. Data Statistik HSE --}}
                                <section class="mb-5">
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
                                            @foreach (['Jumlah Hari Kerja', 'Jumlah Manhours (Termasuk Lembur)'] as $i => $label)
                                                <tr>
                                                    <td class="text-start">{{ $label }}</td>
                                                    <td><input type="number" name="statistik_lalu[{{ $i }}]"
                                                            class="form-control" min="0" readonly></td>
                                                    <td><input type="number" name="statistik_sekarang[{{ $i }}]"
                                                            class="form-control" min="0" readonly></td>
                                                    <td><input type="number" class="form-control" readonly
                                                            value="0"></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="table-light">
                                            <tr>
                                                <td class="text-start">Jumlah Pekerja Kontraktor Utama</td>
                                                <td colspan="2"><input type="number" name="jumlah_pekerja[utama]"
                                                        class="form-control" min="0"></td>
                                                <td>Orang</td>
                                            </tr>
                                            <tr>
                                                <td class="text-start">Jumlah Pekerja Subkontraktor</td>
                                                <td colspan="2"><input type="number" name="jumlah_pekerja[subkon]"
                                                        class="form-control" min="0"></td>
                                                <td>Orang</td>
                                            </tr>
                                            <tr>
                                                <td class="text-start">Total Jumlah Pekerja</td>
                                                <td colspan="2"><input readonly type="number"
                                                        name="jumlah_pekerja[total]" class="form-control" value="0">
                                                </td>
                                                <td>Orang</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </section>

                                {{-- 2. Tim HSE --}}
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
                                            @foreach ([
            'hse_manager' => 'HSE Manager',
            'hse_coordinator' => 'HSE Coordinator',
            'hse_supervisor' => 'HSE Supervisor',
            'safety_engineer' => 'Safety Engineer',
            'safety_officer' => 'Safety Officer',
            'safety_inspector' => 'Safety Inspector',
            'safety_administration' => 'Safety Administration',
            'safety_man' => 'Safety Man',
            'paramedis' => 'Paramedis',
        ] as $name => $label)
                                                <tr>
                                                    <td class="text-start">{{ $label }}</td>
                                                    <td><input type="number" name="tim_hse[{{ $name }}]"
                                                            class="form-control" min="0"></td>
                                                    <td>Orang</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </section>

                                @php
                                    $insidenFields = [
                                        '3. Data Kasus Insiden' => ['Jumlah Kasus Insiden'],
                                        '4. Rincian Data Insiden' => [
                                            'Fatality / Kematian',
                                            'Disability / Cacat Permanen',
                                            'Medical Treatment / Perawatan Medis',
                                            'First Aid / P3K',
                                            'Property Damage',
                                            'Traffic Accident',
                                            'Near Miss',
                                            'Lost Time Injury',
                                        ],
                                        '5. Data Kasus Penyakit' => ['Jumlah Kasus Penyakit'],
                                        '6. Rincian Data Kasus Penyakit' => [
                                            'Penyakit Akibat Kerja',
                                            'Penyakit Akibat Hubungan Kerja',
                                            'Penyakit Biasa',
                                            'Lost Time Injury',
                                        ],
                                        '7. Kasus Pencemaran Lingkungan' => ['Jumlah Kasus Pencemaran'],
                                        '8. Rincian Pencemaran Lingkungan' => ['Pencemaran Air', 'Pencemaran Udara'],
                                    ];
                                    $index = 1;
                                @endphp

                                {{-- Input Laporan 3–17 --}}
                                @foreach ($insidenFields as $judul => $labels)
                                    <section class="mb-5">
                                        <h5 class="fw-semibold mb-3">{{ $judul }}</h5>
                                        <table class="table table-bordered text-center align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="text-start">Keterangan</th>
                                                    <th>Bulan Ini</th>
                                                    <th>Kumulatif</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($labels as $label)
                                                    <tr>
                                                        <td class="text-start">{{ $label }}</td>
                                                        <td>
                                                            <input type="number"
                                                                name="laporan[{{ $index }}][bulan_ini][0]"
                                                                class="form-control" min="0">
                                                        </td>
                                                        <td>
                                                            <input type="number"
                                                                name="laporan[{{ $index }}][total][0]"
                                                                class="form-control" min="0">
                                                        </td>
                                                    </tr>
                                                    @php $index++; @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </section>
                                @endforeach

                                {{-- Input Laporan 18–20 (Bahaya, Inspeksi HSE, Inspeksi Alat) --}}
                                @foreach (['9. Laporan Bahaya', '10. Laporan Inspeksi HSE', '11. Laporan Inspeksi Alat'] as $idx => $judul)
                                    @php $laporanIndex = $idx + 18; @endphp
                                    <section class="mb-5">
                                        <h5 class="fw-semibold mb-3">{{ $judul }}</h5>
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
                                                @foreach (['Temuan', 'Terselesaikan', 'Sisa'] as $i => $label)
                                                    <tr>
                                                        <td class="text-start">{{ $label }}</td>
                                                        <td><input type="number"
                                                                name="laporan[{{ $laporanIndex }}][lalu][{{ $i }}]"
                                                                class="form-control" min="0"></td>
                                                        <td><input type="number"
                                                                name="laporan[{{ $laporanIndex }}][bulan_ini][{{ $i }}]"
                                                                class="form-control" min="0"></td>
                                                        <td><input type="number"
                                                                name="laporan[{{ $laporanIndex }}][total][{{ $i }}]"
                                                                class="form-control" readonly value="0"></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </section>
                                @endforeach

                                {{-- 12. Kegiatan Bulan Ini --}}
                                <section class="mb-5">
                                    <h5 class="fw-semibold mb-3">12. Kegiatan Bulan Ini</h5>
                                    <ol class="ps-4">
                                        @for ($i = 0; $i < 3; $i++)
                                            <li class="mb-2"><input type="text" name="kegiatan_bulan_ini[]"
                                                    class="form-control"></li>
                                        @endfor
                                    </ol>
                                </section>

                                {{-- 13. Pelatihan & Induksi --}}
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
                                            @for ($i = 0; $i < 4; $i++)
                                                <tr>
                                                    <td>{{ $i + 1 }}</td>
                                                    <td><input type="text"
                                                            name="pelatihan[{{ $i }}][judul]"
                                                            class="form-control"></td>
                                                    <td><input type="text"
                                                            name="pelatihan[{{ $i }}][perusahaan]"
                                                            class="form-control"></td>
                                                    <td><input type="number"
                                                            name="pelatihan[{{ $i }}][jumlah]"
                                                            class="form-control" min="0"></td>
                                                    <td><input type="text"
                                                            name="pelatihan[{{ $i }}][keterangan]"
                                                            class="form-control"></td>
                                                </tr>
                                            @endfor
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
                                            @for ($i = 0; $i < 3; $i++)
                                                <tr>
                                                    <td>{{ $i + 1 }}</td>
                                                    <td><input type="text"
                                                            name="induksi[{{ $i }}][petugas]"
                                                            class="form-control"></td>
                                                    <td><input type="number" name="induksi[{{ $i }}][jumlah]"
                                                            class="form-control" min="0"></td>
                                                    <td><input type="text"
                                                            name="induksi[{{ $i }}][keterangan]"
                                                            class="form-control"></td>
                                                </tr>
                                            @endfor
                                        </tbody>
                                    </table>
                                </section>

                                {{-- 14–16 Ringkasan --}}
                                @foreach (['14. Ringkasan & Permasalahan HSE' => 'ringkasan_permasalahan[]', '15. Daftar Lampiran' => 'lampiran[]', '16. Rencana Kegiatan Bulan Depan' => 'rencana_kegiatan[]'] as $judul => $name)
                                    <section class="mb-5">
                                        <h5 class="fw-semibold mb-3">{{ $judul }}</h5>
                                        <ol class="ps-4">
                                            @for ($i = 0; $i < 3; $i++)
                                                <li class="mb-2"><input type="text" name="{{ $name }}"
                                                        class="form-control"></li>
                                            @endfor
                                        </ol>
                                    </section>
                                @endforeach
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="text-end mt-4">
                                <a href="{{ route('permit.jamkerja.index') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/flat-pickr/flatpickr.js') }}"></script>
    <script>
        const csrfToken = '{{ csrf_token() }}';
        const workPermitId = '{{ $workPermit->id }}';
        const jamKerjaStoreUrl = '{{ route('permit.jamkerja.store') }}';
        const jamKerjaIndexUrl = '{{ route('permit.jamkerja.index') }}';
        const tanggalAwal = '{{ $start }}';
        const tanggalAkhir = '{{ $end }}';
    </script>
    <script src="{{ asset('js/jamkerja.js') }}"></script>
@endsection
