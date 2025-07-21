@extends('layouts.master')
@section('title', 'Detail Pekerjaan')
@section('header', 'Detail Pekerjaan')

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
                        <h2>Detail Pekerjaan</h2>
                    </div>
                    <div class="col-sm-6 col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:;"><i
                                        class="iconly-Home icli svg-color"></i></a></li>
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Detail Pekerjaan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                            <h5 class="mb-0 fw-bold"><i class="me-2"></i> Informasi Pekerjaan</h5>
                            <a href="{{ route('purchasing.po.index') }}" class="btn btn-light text-primary fw-bold">
                                <i class="me-1"></i> Kembali
                            </a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <tbody>
                                        <tr>
                                            <th class="bg-dark">Nama Pekerjaan</th>
                                            <td>{{ $purchaseOrder->nama_pekerjaan }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-dark">Vendor</th>
                                            <td>{{ $purchaseOrder->vendor->vendor_name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-dark">No PO</th>
                                            <td>{{ $purchaseOrder->no_po ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-dark">Jenis Pekerjaan</th>
                                            <td>
                                                <span class="badge bg-info text-dark">
                                                    {{ $purchaseOrder->jenis_pekerjaan == 'jasa_perorangan' ? 'Jasa Perorangan' : 'Jasa Non Perorangan' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-dark">Area Pekerjaan</th>
                                            <td>{{ $purchaseOrder->area_pekerjaan }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-dark">Lokasi Pekerjaan</th>
                                            <td>{{ $purchaseOrder->lokasi_pekerjaan }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-dark">Tanggal Mulai</th>
                                            <td><i class="me-1"></i> {{ \Carbon\Carbon::parse($purchaseOrder->tanggal_mulai)->format('d M Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-dark">Tanggal Akhir</th>
                                            <td><i class="me-1"></i> {{ \Carbon\Carbon::parse($purchaseOrder->tanggal_akhir)->format('d M Y') }}</td>
                                        </tr>
                                        @php
                                            $statusClass = match ($purchaseOrder->status) {
                                                'active' => 'badge bg-success',
                                                'cancelled' => 'badge bg-danger',
                                                'draft' => 'badge bg-secondary',
                                                default => 'badge bg-warning',
                                            };
                                        @endphp
                                        <tr>
                                            <th class="bg-dark">Status</th>
                                            <td><span class="{{ $statusClass }} rounded-pill px-3 py-2">{{ ucfirst($purchaseOrder->status) }}</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0 text-center">Klasifikasi Pekerjaan, APD & Perlengkapan Darurat</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <h6 class="text-secondary fw-bold mb-2">Klasifikasi Pekerjaan:</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($selectedClassifications as $classification)
                                        <div class="d-flex align-items-center gap-2">
                                            <input class="form-check-input" type="checkbox" checked disabled>
                                            <span class="badge bg-success  px-3 py-2 shadow-sm">
                                                <i class="me-1"></i> {{ $classification }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row">
                                <!-- APD -->
                                <div class="col-md-6">
                                    <div class="card border-light shadow-sm">
                                        <div class="card-header bg-light border-bottom">
                                            <h6 class="mb-0 text-center fw-bold text-primary">
                                                <i class="me-1"></i> Alat Pelindung Diri (APD)
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group list-group-flush">
                                                @foreach ($uniqueApd as $equipment)
                                                    <li class="list-group-item d-flex align-items-center">
                                                        <input class="form-check-input me-2" type="checkbox" checked
                                                            disabled>
                                                        <span class="fw-semibold">{{ $equipment->name }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- Perlengkapan Darurat -->
                                <div class="col-md-6">
                                    <div class="card border-light shadow-sm">
                                        <div class="card-header bg-light border-bottom">
                                            <h6 class="mb-0 text-center fw-bold text-danger">
                                                <i class="me-1"></i> Perlengkapan Darurat
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group list-group-flush">
                                                @foreach ($uniqueEmergencyEquipments as $equipment)
                                                    <li class="list-group-item d-flex align-items-center">
                                                        <input class="form-check-input me-2" type="checkbox" checked
                                                            disabled>
                                                        <span class="fw-semibold">{{ $equipment->name }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- End row -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
@endsection
