@extends('layouts.master')
@section('title', 'Data Pekerjaan')
@section('header', 'Data Pekerjaan')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/js-datatables/style.css') }}">
@endsection
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-sm-6 col-12">
                        <h2>Pengajuan Work Permit</h2>
                    </div>
                    <div class="col-sm-6 col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:;"><i
                                        class="iconly-Home icli svg-color"></i></a></li>
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Data Pekerjaan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            @if (session('error'))
                <div class="alert alert-warning">
                    {{ session('error') }}
                </div>
            @endif
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="horizontal-wizard-wrapper">
                                <div class="row g-3">

                                    <div class="col-12 main-horizontal-header">
                                        <div class="nav nav-pills horizontal-options" id="horizontal-wizard-tab"
                                            role="tablist" aria-orientation="vertical">
                                            <a class="nav-link active" id="detail-pekerjaan-tab" data-bs-toggle="pill"
                                                href="#detail-pekerjaan" role="tab" aria-controls="detail-pekerjaan"
                                                aria-selected="false">
                                                <div class="horizontal-wizard">
                                                    <div class="stroke-icon-wizard">
                                                        <i class="fa-solid fa-briefcase"></i>
                                                    </div>
                                                    <div class="horizontal-wizard-content">
                                                        <h5>Detail Pekerjaan</h5>
                                                    </div>
                                                </div>
                                            </a>
                                            <a class="nav-link disabled" id="daftar-pekerja-tab" data-bs-toggle="pill"
                                                href="#daftar-pekerja" role="tab" aria-controls="daftar-pekerja"
                                                aria-selected="false">
                                                <div class="horizontal-wizard">
                                                    <div class="stroke-icon-wizard">
                                                        <i class="fa-solid fa-users"></i>
                                                    </div>
                                                    <div class="horizontal-wizard-content">
                                                        <h5>Daftar Pekerja</h5>
                                                    </div>
                                                </div>
                                            </a>
                                            <a class="nav-link disabled" id="daftar-perlengkapan-tab" data-bs-toggle="pill"
                                                href="#daftar-perlengkapan" role="tab"
                                                aria-controls="daftar-perlengkapan" aria-selected="false">
                                                <div class="horizontal-wizard">
                                                    <div class="stroke-icon-wizard">
                                                        <i class="fa-solid fa-tools"></i>
                                                    </div>
                                                    <div class="horizontal-wizard-content">
                                                        <h5>Daftar Perlengkapan Kerja</h5>
                                                    </div>
                                                </div>
                                            </a>
                                            <a class="nav-link disabled" id="jsa-tab" data-bs-toggle="pill" href="#jsa"
                                                role="tab" aria-controls="jsa" aria-selected="false">
                                                <div class="horizontal-wizard">
                                                    <div class="stroke-icon-wizard">
                                                        <i class="fa-solid fa-file-contract"></i>
                                                    </div>
                                                    <div class="horizontal-wizard-content">
                                                        <h5>JSA</h5>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="tab-content dark-field" id="horizontal-wizard-tabContent">
                                            <div class="tab-pane fade show active" id="detail-pekerjaan">
                                                <form id="step1Form" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" id="purchase_order_id" name="purchase_order_id"
                                                        value="{{ $purchaseOrder->id }}">
                                                    <input type="hidden" name="vendor_id"
                                                        value="{{ $purchaseOrder->vendor_id }}">
                                                    @include('components.workpermit.detail-po', [
                                                        'purchaseOrder' => $purchaseOrder,
                                                    ])
                                                    @include('components.workpermit.data-pemohon', [
                                                        'workPermit' => $workPermit,
                                                    ])
                                                    @include('components.workpermit.klasifikasi', [
                                                        'selectedClassifications' => $selectedClassifications,
                                                        'uniqueApd' => $uniqueApd,
                                                        'uniqueEmergencyEquipments' => $uniqueEmergencyEquipments,
                                                    ])

                                                    <div class="col-12 text-end">
                                                        <button type="button" class="btn btn-primary"
                                                            id="nextStep">Next</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane fade" id="daftar-pekerja" role="tabpanel"
                                                aria-labelledby="daftar-pekerja-tab">
                                                {{-- <div class="alert alert-danger">
                                                    Untuk menghapus nama pekerja pada jabatan tertentu. klik tanda merah (-)
                                                    pada nama pekerja yang dituju, lalu klik kembali tanda hijau (+) dan
                                                    biarkan nama pekerja kosong
                                                </div> --}}
                                                <form id="step2Form" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" id="work_permit_id" name="work_permit_id"
                                                        value="{{ $workPermit->id ?? '' }}">
                                                    <input type="hidden" id="deleted_workers" name="deleted_workers"
                                                        value="">
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <div class="alert alert-danger">
                                                                        <p style="color: white">Isi data dengan
                                                                            pekerja yang berada dilapangan sesuai
                                                                            jabatannya</p>
                                                                    </div>
                                                                    <th>Jabatan</th>
                                                                    <th>Nama Pekerja</th>
                                                                    <th>KTP</th>
                                                                    <th>Sertifikat</th>
                                                                    <th>Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            @php
                                                                $jabatanList = [
                                                                    'engineer',
                                                                    'surveyor',
                                                                    'operator_alat_berat',
                                                                    'rigger',
                                                                    'teknisi_elektrik',
                                                                    'mekanik',
                                                                    'welder',
                                                                    'fitter',
                                                                    'tukang_bangunan',
                                                                    'hekiper',
                                                                    'helper',
                                                                    'safety_officer',
                                                                    'lainnya',
                                                                ];
                                                            @endphp

                                                            <tbody id="daftar-pekerja-body">
                                                                @foreach ($jabatanList as $jabatan)
                                                                    @include(
                                                                        'components.workpermit.worker-group',
                                                                        [
                                                                            'jabatan' => $jabatan,
                                                                            'workers' => $workers,
                                                                        ]
                                                                    )
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-12 text-end mt-3">
                                                        <button type="button" class="btn btn-secondary"
                                                            id="prevStep1">Previous</button>
                                                        <button type="submit" class="btn btn-primary"
                                                            id="nextStep2">Continue</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane fade" id="daftar-perlengkapan" role="tabpanel"
                                                aria-labelledby="daftar-perlengkapan-tab">
                                                <form id="step3Form" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="work_permit_id"
                                                        value="{{ $workPermit->id ?? '' }}">
                                                    <div class="alert alert-danger">
                                                        <p style="color: white">Wajib menambahkan peralatan kerja</p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="kategori">Kategori Peralatan</label>
                                                        <select class="form-control" id="kategori">
                                                            <option value="">-- Pilih Kategori --</option>
                                                            @foreach (['alat', 'mesin', 'material', 'alat_berat'] as $kategori)
                                                                <option value="{{ $kategori }}">
                                                                    {{ ucfirst(str_replace('_', ' ', $kategori)) }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <button type="button" class="btn btn-success btn-sm mb-3"
                                                        id="tambah-peralatan">Tambah Peralatan</button>

                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Kategori</th>
                                                                    <th>Nama</th>
                                                                    <th>Jumlah</th>
                                                                    <th>Foto / Sertifikat Alat (Opsional)</th>
                                                                    <th>Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="daftar-peralatan-body">
                                                                @if ($equipments && count($equipments))
                                                                    @foreach ($equipments as $kategori => $equipmentGroup)
                                                                        @foreach ($equipmentGroup as $equipment)
                                                                            <tr data-equipment-id="{{ $equipment->id }}">
                                                                                <td>
                                                                                    <input type="hidden"
                                                                                        name="kategori[]"
                                                                                        value="{{ $equipment->kategori }}">
                                                                                    {{ str_replace('_', ' ', $equipment->kategori) }}
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text" name="nama[]"
                                                                                        class="form-control"
                                                                                        style="min-width: 200px; width: 70%;"
                                                                                        value="{{ $equipment->nama }}">
                                                                                </td>
                                                                                <td>
                                                                                    <input type="number" name="jumlah[]"
                                                                                        class="form-control"
                                                                                        value="{{ $equipment->jumlah }}"
                                                                                        min="1">
                                                                                </td>
                                                                                <td>
                                                                                    <input type="file"
                                                                                        name="lampiran_foto[]"
                                                                                        class="form-control foto-peralatan"
                                                                                        accept=".jpg,.png,.pdf">
                                                                                    @if ($equipment->lampiran_foto)
                                                                                        <a href="{{ asset('storage/' . $equipment->lampiran_foto) }}"
                                                                                            target="_blank">Lihat</a>
                                                                                    @endif
                                                                                </td>
                                                                                <td>
                                                                                    <button type="button"
                                                                                        class="btn btn-danger btn-sm hapus-peralatan">
                                                                                        <i class="fa-solid fa-trash"></i>
                                                                                    </button>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td colspan="5" class="text-center">Tidak ada
                                                                            data peralatan.</td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>


                                                        </table>
                                                    </div>

                                                    <div class="text-end mt-3">
                                                        <button type="button" class="btn btn-secondary"
                                                            id="prevStep2">Previous</button>
                                                        <button type="submit" class="btn btn-primary"
                                                            id="saveStep3">Continue</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane fade" id="jsa" role="tabpanel"
                                                aria-labelledby="jsa-tab">
                                                <form id="step4Form" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" id="work_permit_id" name="work_permit_id"
                                                        value="{{ $workPermit->id ?? '' }}">
                                                    <input type="hidden" name="deleted_jsa" id="deletedJsa">
                                                    <div class="alert alert-danger">
                                                        <p style="color: white">Wajib mengisi semua tahapan! minimal 1
                                                            aktifitas dalam setiap tahapan</p>
                                                    </div>
                                                    <div class="table-responsive mt-3">

                                                        <table class="table table-bordered align-middle shadow-sm">
                                                            <thead class="text-white text-center table-dark">
                                                                <tr>
                                                                    <th style="width: 20%">Tahapan</th>
                                                                    <th style="width: 30%">Aktivitas/Sub-Tahapan</th>
                                                                    <th style="width: 25%">Potensi Bahaya</th>
                                                                    <th style="width: 25%">Pengendalian Risiko</th>
                                                                </tr>
                                                            </thead>

                                                            @php
                                                                $tahapanList = [
                                                                    'persiapan' => 'Persiapan',
                                                                    'mobilisasi' => 'Mobilisasi',
                                                                    'pelaksanaan' => 'Pelaksanaan',
                                                                    'finishing' => 'Finishing',
                                                                ];
                                                                $alphabet = range('a', 'z');
                                                                $globalIndex = 0;
                                                            @endphp

                                                            @foreach ($tahapanList as $key => $label)
                                                                <tbody id="tbody-{{ $key }}">
                                                                    <tr class="fw-bold bg-light">
                                                                        <td colspan="4">{{ $label }}</td>
                                                                    </tr>

                                                                    {{-- Riwayat data JSA --}}
                                                                    @if ($groupedJsaRecords->has($key))
                                                                        @foreach ($groupedJsaRecords->get($key) as $record)
                                                                            @foreach ($record->subTahapan as $i => $sub)
                                                                                <tr>
                                                                                    <td class="text-center align-middle">
                                                                                        {{ $alphabet[$i] ?? $i + 1 }}.
                                                                                        <input type="hidden"
                                                                                            name="jsa[{{ $globalIndex }}][tahapan]"
                                                                                            value="{{ $key }}">
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="text"
                                                                                            name="jsa[{{ $globalIndex }}][sub_tahapan]"
                                                                                            class="form-control"
                                                                                            value="{{ $sub->sub_tahapan }}">
                                                                                    </td>
                                                                                    <td>
                                                                                        <textarea name="jsa[{{ $globalIndex }}][identifikasi_bahaya]" class="form-control">{{ is_array($sub->identifikasi_bahaya) ? implode("\n", $sub->identifikasi_bahaya) : $sub->identifikasi_bahaya }}</textarea>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="input-group">
                                                                                            <textarea name="jsa[{{ $globalIndex }}][pengendalian_risiko]" class="form-control">{{ is_array($sub->pengendalian_risiko) ? implode("\n", $sub->pengendalian_risiko) : $sub->pengendalian_risiko }}</textarea>
                                                                                            <button type="button"
                                                                                                class="btn btn-danger btn-sm delete-row ms-2">
                                                                                                <i
                                                                                                    class="fa-solid fa-trash"></i>
                                                                                            </button>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                @php $globalIndex++; @endphp
                                                                            @endforeach
                                                                        @endforeach
                                                                    @endif
                                                                </tbody>

                                                                <tr>
                                                                    <td colspan="4" class="text-end">
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-success add-row"
                                                                            data-tahapan="{{ $key }}">
                                                                            <i class="fas fa-plus"></i> Tambah Baris
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach

                                                        </table>
                                                    </div>

                                                    <div class="col-12 text-end mt-3">
                                                        <button type="button" class="btn btn-secondary"
                                                            id="prevStep3">Previous</button>
                                                        <button type="submit" class="btn btn-primary"
                                                            id="saveStep4">Ajukan</button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- row -->
                </div>
            </div>
        </div>
    @endsection
    @section('scripts')
        <script src="{{ asset('js/workpermit.js') }}"></script>
        <script>
            var storeStep1Url = "{{ route('permit.po.storeStep1') }}";
            var storeStep2Url = "{{ route('permit.po.storeStep2') }}";
            var storeStep3Url = "{{ route('permit.po.storeStep3') }}";
            var storeStep4Url = "{{ route('permit.po.storeStep4') }}";
        </script>
    @endsection
