@extends('layouts.master')
@section('title', 'Data Pekerjaan')
@section('header', 'Data Pekerjaan')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/js-datatables/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flatpickr/flatpickr.min.css') }}">
    <style>
        .toggle-btn {
            transition: transform 0.3s ease;
        }

        .collapsed .toggle-btn {
            transform: rotate(180deg);
        }

        .hover-effect:hover {
            background: rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .toggle-btn {
            transition: transform 0.3s ease;
        }

        .collapsed .toggle-btn {
            transform: rotate(180deg);
        }

        .timeline {
            position: relative;
            margin: 20px 0;
            padding-left: 40px;
            list-style: none;
            border-left: 4px solid #007bff;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 20px;
            padding-left: 20px;
        }

        .timeline-item::before {
            content: "";
            position: absolute;
            left: -10px;
            top: 10px;
            width: 16px;
            height: 16px;
            background: white;
            border: 4px solid #007bff;
            border-radius: 50%;
        }

        .timeline-content {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .approved::before {
            border-color: #28a745;
        }

        .rejected::before {
            border-color: #dc3545;
        }

        .waiting::before {
            border-color: #ffc107;
        }

        .vendor::before {
            border-color: #007bff;
        }

        .status-badge {
            font-size: 14px;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
            display: inline-block;
        }

        .status-approved {
            background: #28a745;
            color: white;
        }

        .status-rejected {
            background: #dc3545;
            color: white;
        }

        .status-waiting {
            background: #ffc107;
            color: black;
        }

        .status-vendor {
            background: #007bff;
            color: white;
        }
    </style>
@endsection
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-sm-6 col-12">
                        <h2>Progress Work Permit</h2>
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
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="row">
                <div class="card shadow-lg border-0">
                    <div
                        class="card-header bg-primary text-white text-center py-3 d-flex justify-content-between align-items-center">
                        <h1 class="mb-0">Riwayat Persetujuan Work Permit</h1>
                        <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="collapse"
                            data-bs-target="#approvalHistory" aria-expanded="true" aria-controls="approvalHistory">
                            Buka/Tutup
                        </button>
                    </div>
                    <div id="approvalHistory" class="collapse show">
                        <div class="card-body">
                            <ul class="timeline">
                                {{-- Vendor / Pengajuan --}}
                                <li class="timeline-item vendor">
                                    <div class="timeline-content">
                                        <h5>{{ $workPermit->vendor->vendor_name ?? 'Unknown' }}</h5>
                                        <p>{{ optional($workPermit->created_at)->format('d M Y') ?? '-' }}</p>
                                        <span class="status-badge status-vendor mb-2">Diajukan</span>
                                        <div><strong>Work Permit Diajukan</strong></div>
                                    </div>
                                </li>

                                @php
                                    $lanjutTampil = true;
                                @endphp

                                @foreach ($approvalPengajuan as $index => $item)
                                    @php
                                        $approval = $item->approval;
                                        $permission = $item->permission_name;
                                        $approvalLevel = $item->level;
                                        $uniqueId = $permission . '_' . $approvalLevel;

                                        $isShe = $permission === 'approval-she_officer';

                                        if ($isShe) {
                                            $startDate = optional($purchaseOrder->tanggal_mulai)->format('Y-m-d');
                                            $endDate = optional($purchaseOrder->tanggal_akhir)->format('Y-m-d');
                                        }

                                        $extraFields = $isShe
                                            ? [
                                                'induction_date' => 'Tanggal Induction',
                                                'catatan_safety' => 'Catatan Safety',
                                                'catatan_lain' => 'Catatan Lain',
                                            ]
                                            : [];
                                    @endphp

                                    @if ($index === 0 || ($index > 0 && optional($approvalPengajuan[$index - 1]->approval)->status === 'approved'))
                                        <li class="timeline-item {{ getTimelineItemClass($approval->status ?? null) }}">
                                            <div class="timeline-content">
                                                <h5>{{ label($approval->permission_name) }}</h5>
                                                <div><strong>Nama:</strong>
                                                    {{ $approval?->approver?->name ?? '-' }}
                                                </div>
                                                <p>
                                                    @if ($approval)
                                                        @if (in_array($approval->status, ['approved', 'rejected']))
                                                            {{ $approval->approved_at?->format('d M Y') ?? '-' }}<br>
                                                            <span
                                                                class="status-badge mb-1 {{ getApprovalStatusClass($approval->status) }}">
                                                                {{ getApprovalStatusLabel($approval->status) }}
                                                            </span><br>

                                                            @if ($isShe && $workPermit->induction_date)
                                                                <div><strong>Tanggal Induction:</strong>
                                                                    {{ \Carbon\Carbon::parse($workPermit->induction_date)->format('d M Y') }}
                                                                </div>
                                                            @endif

                                                            @if (!empty($approval->keterangan))
                                                                <strong>Keterangan: {{ $approval->keterangan }}</strong>
                                                            @endif
                                                        @else
                                                            <span
                                                                class="status-badge {{ getApprovalStatusClass($approval->status) }}">
                                                                {{ getApprovalStatusLabel($approval->status) }}
                                                            </span>
                                                        @endif
                                                    @else
                                                        <span class="status-badge {{ getApprovalStatusClass(null) }}">
                                                            {{ getApprovalStatusLabel(null) }}
                                                        </span>
                                                    @endif
                                                </p>

                                                @if ($isCurrentReviewer && (!$approval || $approval->status == 'pending') && !$isPenyelesaian)
                                                    @if (auth()->user()->hasPermissionTo($permission))
                                                        <div class="mt-3">
                                                            <textarea class="form-control approval-note" name="keterangan" placeholder="Masukkan keterangan..." rows="2"
                                                                id="keterangan_{{ $uniqueId }}" required></textarea>

                                                            @foreach ($extraFields as $field => $label)
                                                                <div class="mt-2">
                                                                    <label for="{{ $field }}_{{ $uniqueId }}"
                                                                        class="form-label">
                                                                        <strong>{{ $label }} <small><span
                                                                                    style="color: red">*</span></small></strong>
                                                                    </label>

                                                                    @if ($field === 'induction_date')
                                                                        <input type="text" class="form-control"
                                                                            id="{{ $field }}_{{ $uniqueId }}"
                                                                            name="{{ $field }}"
                                                                            data-type="induction_date"
                                                                            data-start="{{ $startDate }}"
                                                                            data-end="{{ $endDate }}"></small>
                                                                    @else
                                                                        <textarea class="form-control" id="{{ $field }}_{{ $uniqueId }}" name="{{ $field }}" rows="2"
                                                                            placeholder="Masukkan {{ strtolower($label) }}..."></textarea>
                                                                    @endif
                                                                </div>
                                                            @endforeach

                                                            <button class="btn btn-success btn-approve mt-2"
                                                                data-url="{{ route('permit.po.approve', ['id' => $workPermit->id, 'permission' => $permission]) }}"
                                                                data-permission="{{ $permission }}"
                                                                data-role="{{ str_replace('approval-', '', $permission) }}"
                                                                data-extra-fields="{{ implode(',', array_merge(['keterangan'], array_keys($extraFields))) }}"
                                                                required>
                                                                Approve
                                                            </button>

                                                            <button class="btn btn-danger btn-reject mt-2"
                                                                data-url="{{ route('permit.po.reject', ['id' => $workPermit->id, 'permission' => $permission]) }}"
                                                                data-permission="{{ $permission }}"
                                                                data-extra-fields="keterangan" required>
                                                                Reject
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </li>
                                    @endif

                                    @if ($approval && $approval->status == 'rejected')
                                        @php $lanjutTampil = false; @endphp
                                    @endif
                                @endforeach
                            </ul>

                            <div class="text-center mt-4">
                                <a href="{{ route('permit.workpermit.previewPdf', ['id' => $workPermit->id]) }}"
                                    target="_blank" class="btn btn-primary">
                                    Lihat / Download PDF
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($workPermit->purchaseOrder->pengajuanPenyelesaian)
                    <div class="card shadow-lg border-0">
                        <div
                            class="card-header bg-primary text-white text-center py-3 d-flex justify-content-between align-items-center">
                            <h1 class="mb-0">Riwayat Penyelesaian Pekerjaan</h1>
                            <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="collapse"
                                data-bs-target="#completionHistory" aria-expanded="true" aria-controls="completionHistory">
                                Buka/Tutup
                            </button>
                        </div>
                        <div id="completionHistory" class="collapse show">
                            <div class="card-body">
                                <ul class="timeline">
                                    <li class="timeline-item">
                                        <div class="timeline-content">
                                            <h5>Penyelesaian Pekerjaan Diajukan</h5>
                                            <p>{{ $purchaseOrder->pengajuanPenyelesaian->created_at->format('d M Y') }}
                                            </p>
                                            <span class="status-badge status-vendor mb-1">Diajukan oleh
                                                {{ $workPermit->vendor->vendor_name ?? 'Unknown' }}</span>
                                            <div>
                                                <strong>{{ $purchaseOrder->pengajuanPenyelesaian->alasan }}</strong>
                                            </div>
                                        </div>
                                    </li>

                                    @php $lanjutPenyelesaian = true; @endphp

                                    @foreach ($approvalPenyelesaian as $approval)
                                        @php
                                            $permission = $approval->permission_name;
                                            $isCurrent =
                                                $currentUserPermission === $permission &&
                                                $approval->status === 'pending' &&
                                                $lanjutPenyelesaian;
                                        @endphp

                                        <li
                                            class="timeline-item
                                        @if ($approval->status === 'approved') approved
                                        @elseif ($approval->status === 'rejected') rejected
                                        @else waiting @endif">
                                            <div class="timeline-content">
                                                <h5>{{ label($approval->permission_name) }}</h5>
                                                <div><strong>Nama:</strong>
                                                    {{ $approval?->approver?->name ?? '-' }}
                                                </div>
                                                <p>
                                                    {{ $approval->approved_at ? $approval->approved_at->format('d M Y') : '-' }}<br>
                                                    <span
                                                        class="status-badge
                                                    {{ $approval->status === 'approved' ? 'status-approved' : ($approval->status === 'rejected' ? 'status-rejected' : 'status-waiting') }}">
                                                        {{ ucfirst($approval->status) }}
                                                    </span><br>
                                                    @if (!empty($approval->keterangan))
                                                        <strong>Keterangan:</strong> {{ $approval->keterangan }}
                                                    @endif
                                                </p>

                                                @if ($isCurrent)
                                                    <textarea class="form-control mb-2" name="keterangan" placeholder="Masukkan keterangan..." required></textarea>

                                                    <button class="btn btn-success btn-approve-penyelesaian"
                                                        data-role="{{ $permission }}"
                                                        data-url="{{ route('permit.penyelesaian.approve', $purchaseOrder->pengajuanPenyelesaian->id) }}">
                                                        Approve
                                                    </button>
                                                @endif
                                            </div>
                                        </li>

                                        @if ($approval->status === 'rejected')
                                            @php $lanjutPenyelesaian = false; @endphp
                                        @endif
                                    @endforeach
                                </ul>

                                <div class="text-center mt-4">
                                    <a href="{{ route('permit.workpermit.previewPdf', ['id' => $workPermit->id]) }}"
                                        target="_blank" class="btn btn-primary">
                                        Lihat / Download PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($purchaseOrder->pembatalan)
                    <div class="card shadow-lg border-0">
                        <div
                            class="card-header bg-primary text-white text-center py-3 d-flex justify-content-between align-items-center">
                            <h1 class="mb-0">Riwayat Pembatalan Pekerjaan</h1>
                            <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="collapse"
                                data-bs-target="#cancelHistory" aria-expanded="true" aria-controls="cancelHistory">
                                Buka/Tutup
                            </button>
                        </div>
                        <div id="cancelHistory" class="collapse show">
                            <div class="card-body">
                                <ul class="timeline">
                                    <li class="timeline-item">
                                        <div class="timeline-content">
                                            <h5>Pembatalan Diajukan</h5>
                                            <p>{{ $purchaseOrder->pembatalan->created_at->format('d M Y') }}</p>
                                            <span class="status-badge status-vendor mb-1">Diajukan oleh SHE
                                                Officer</span>
                                            <div><strong> {{ $purchaseOrder->pembatalan->alasan }} </strong>
                                            </div>
                                        </div>
                                    </li>

                                    @php
                                        $approvals = $purchaseOrder->pembatalan->approvals->sortBy('level');
                                        $lanjutPembatalan = true;
                                    @endphp

                                    @foreach ($approvals as $approval)
                                        @php
                                            $permission = $approval->permission_name;
                                            $isCurrent =
                                                auth()->user()->can($permission) &&
                                                $approval->status === 'pending' &&
                                                $lanjutPembatalan;
                                        @endphp

                                        <li class="timeline-item {{ getTimelineItemClass($approval->status) }}">
                                            <div class="timeline-content">
                                                <h5>{{ label($approval->permission_name) }}
                                                </h5>
                                                <div><strong>Nama:</strong>
                                                    {{ $approval?->approver?->name ?? '-' }}
                                                </div>
                                                <p>
                                                    {{ $approval->approved_at ? $approval->approved_at->format('d M Y') : '-' }}<br>

                                                    <span
                                                        class="status-badge {{ getApprovalStatusClass($approval->status) }}">
                                                        {{ getApprovalStatusLabel($approval->status) }}
                                                    </span><br>

                                                    @if (!empty($approval->keterangan))
                                                        <strong>Keterangan:</strong> {{ $approval->keterangan }}
                                                    @endif
                                                </p>

                                                @if ($isCurrent)
                                                    <textarea class="form-control mb-2" name="keterangan" placeholder="Masukkan keterangan..." required></textarea>

                                                    <button class="btn btn-success btn-approve-pembatalan"
                                                        data-role="{{ $permission }}"
                                                        data-url="{{ route('permit.pembatalan.approve', $purchaseOrder->pembatalan->id) }}">
                                                        Approve
                                                    </button>

                                                    {{-- <button class="btn btn-danger btn-reject-pembatalan"
                                                        data-role="{{ $permission }}"
                                                        data-url="{{ route('permit.pembatalan.reject', $purchaseOrder->pembatalan->id) }}">
                                                        Reject
                                                    </button> --}}
                                                @endif
                                            </div>
                                        </li>

                                        @if ($approval->status == 'rejected')
                                            @php $lanjutPembatalan = false; @endphp
                                        @endif
                                    @endforeach


                                </ul>

                                <div class="text-center mt-4">
                                    <a href="{{ route('permit.workpermit.previewPdf', ['id' => $workPermit->id]) }}"
                                        target="_blank" class="btn btn-primary">
                                        Lihat / Download PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-12 mx-auto mt-4">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h1 class="mb-0">Work Permit</h1>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Nama Pekerjaan -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold fs-6">Nama Pekerjaan</label>
                                <input class="form-control fw-bold bg-primary" type="text"
                                    value="{{ $purchaseOrder->nama_pekerjaan }}" readonly />
                            </div>

                            <!-- Vendor -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold fs-6">Vendor</label>
                                <input class="form-control fw-bold bg-primary" type="text"
                                    value="{{ $purchaseOrder->vendor->vendor_name ?? '-' }}" readonly />
                            </div>

                            <!-- No PO -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold fs-6">No PO</label>
                                <input class="form-control fw-bold bg-primary" type="text"
                                    value="{{ $purchaseOrder->no_po ?? '-' }}" readonly />
                            </div>

                            <!-- Jenis Pekerjaan -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold fs-6">Jenis Pekerjaan</label>
                                <input class="form-control fw-bold bg-primary" type="text"
                                    value="{{ $purchaseOrder->jenis_pekerjaan == 'jasa_perorangan' ? 'Jasa Perorangan' : 'Jasa Non Perorangan' }}"
                                    readonly />
                            </div>

                            <!-- Detail Pekerjaan -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold fs-6">Detail Pekerjaan</label>
                                <textarea class="form-control fw-bold bg-primary" rows="3" readonly>{{ $purchaseOrder->detail_pekerjaan ?? '-' }}</textarea>
                            </div>

                            <!-- Area Pekerjaan -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold fs-6">Area Pekerjaan</label>
                                <input class="form-control fw-bold bg-primary" type="text"
                                    value="{{ $purchaseOrder->area_pekerjaan ?? '-' }}" readonly />
                            </div>

                            <!-- Lokasi Pekerjaan -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold fs-6">Lokasi Pekerjaan</label>
                                <input class="form-control fw-bold bg-primary" type="text"
                                    value="{{ $purchaseOrder->lokasi_pekerjaan ?? '-' }}" readonly />
                            </div>

                            <!-- Tanggal Mulai -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold fs-6">Tanggal Mulai</label>
                                <input class="form-control fw-bold bg-primary" type="text"
                                    value="{{ \Carbon\Carbon::parse($purchaseOrder->tanggal_mulai)->format('d M Y') ?? '-' }}"
                                    readonly />
                            </div>

                            <!-- Tanggal Akhir -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold fs-6">Tanggal Akhir</label>
                                <input class="form-control fw-bold bg-primary" type="text"
                                    value="{{ \Carbon\Carbon::parse($purchaseOrder->tanggal_akhir)->format('d M Y') ?? '-' }}"
                                    readonly />
                            </div>

                            <!-- Telepon Pemohon -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold fs-6">Telepon Pemohon</label>
                                <input class="form-control fw-bold bg-primary" type="text"
                                    value="{{ $workPermit->telepon_pemohon ?? '-' }}" readonly />
                            </div>

                            <!-- Nama Pengawas -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold fs-6">Nama Pengawas</label>
                                <input class="form-control fw-bold bg-primary" type="text"
                                    value="{{ $workPermit->pengawas ?? '-' }}" readonly />
                            </div>

                            <!-- Telepon Pengawas -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold fs-6">Telepon Pengawas</label>
                                <input class="form-control fw-bold bg-primary" type="text"
                                    value="{{ $workPermit->telepon_pengawas ?? '-' }}" readonly />
                            </div>

                            <!-- Lampiran Struktur -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold fs-6">Lampiran Struktur</label>
                                <div class="d-flex align-items-center">
                                    <a href="{{ asset('storage/' . $workPermit->lampiran_struktur) }}"
                                        class="btn btn-outline-primary btn-sm" target="_blank">
                                        <i class="fas fa-file-alt me-2"></i> Lihat Lampiran
                                    </a>
                                </div>
                            </div>

                            <!-- Klasifikasi Pekerjaan -->
                            <div class="col-lg-12">
                                <div class="mb-4">
                                    <div class="d-flex flex-wrap gap-3">
                                        <h5 class="text-primary fw-bold">Klasifikasi Pekerjaan:</h5>
                                        @foreach ($selectedClassifications as $classification)
                                            <div class="d-flex align-items-center gap-2">
                                                <input class="form-check-input" type="checkbox" checked disabled>
                                                <span
                                                    class="badge bg-primary px-3 py-2 shadow-sm">{{ $classification }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- APD -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card border-light shadow-sm">
                                            <div class="card-header bg-light border-bottom">
                                                <h6 class="mb-0 text-center fw-bold text-primary"> <i class="me-1"></i>
                                                    Alat Pelindung Diri (APD) yang disediakan
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
                                                <h6 class="mb-0 text-center fw-bold text-primary"> <i class="me-1"></i>
                                                    Perlengkapan Darurat yang disediakan </h6>
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
                                </div>
                            </div>
                        </div>

                        <!-- Daftar Pekerja -->
                        <h5 class="fw-bold text-primary mb-2">Daftar Pekerja</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-dark text-center">
                                    <tr>
                                        <th class="text-white">Jabatan</th>
                                        <th class="text-white">Total Pekerja</th>
                                        <th class="text-white">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($workers as $worker)
                                        <tr class="text-center">
                                            <td><span
                                                    class="fw-bold">{{ ucwords(str_replace('_', ' ', $worker->jabatan)) }}</span>
                                            </td>
                                            <td><span class="badge bg-primary">{{ $worker->workerDetails->count() }}
                                                    Pekerja</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary shadow-sm"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#worker-{{ $worker->id }}">
                                                    <i class="bi bi-eye"></i> Lihat Detail
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="p-0">
                                                <div class="collapse p-3 fade" id="worker-{{ $worker->id }}">
                                                    <table class="table table-bordered">
                                                        <thead class="table-dark text-center">
                                                            <tr>
                                                                <th>Nama Pekerja</th>
                                                                <th>KTP</th>
                                                                <th>Sertifikat</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($worker->workerDetails as $p)
                                                                <tr class="text-center">
                                                                    <td class="fw-semibold">{{ $p->nama }}</td>
                                                                    <td>
                                                                        {!! $p->lampiran_ktp
                                                                            ? '<a href="' .
                                                                                asset('storage/' . $p->lampiran_ktp) .
                                                                                '" target="_blank" class="btn btn-outline-primary btn-sm shadow-sm"><i class="bi bi-file-earmark-text"></i> Lihat</a>'
                                                                            : '<span class="text-muted">Tidak Ada</span>' !!}
                                                                    </td>
                                                                    <td>
                                                                        {!! $p->lampiran_sertifikat
                                                                            ? '<a href="' .
                                                                                asset('storage/' . $p->lampiran_sertifikat) .
                                                                                '" target="_blank" class="btn btn-outline-success btn-sm shadow-sm"><i class="bi bi-file-earmark-check"></i> Lihat</a>'
                                                                            : '<span class="text-muted">Tidak Ada</span>' !!}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Daftar perlengkapan -->
                        <h5 class="fw-bold text-primary mb-2 mt-3">Daftar Peralatan</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-dark text-center">
                                    <tr>
                                        <th class="text-white">Kategori</th>
                                        <th class="text-white">Total Peralatan</th>
                                        <th class="text-white">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($groupedEquipments as $category => $subCategories)
                                        @php $categorySlug = \Illuminate\Support\Str::slug($category); @endphp
                                        <tr class="text-center">
                                            <td class="fw-bold">{{ ucwords(str_replace('_', ' ', $category)) }}</td>
                                            <td>
                                                <span class="badge bg-primary">{{ count($subCategories->flatten()) }}
                                                    Peralatan</span>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary shadow-sm"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#equipment-{{ $categorySlug }}">
                                                    <i class="bi bi-eye"></i> Lihat Detail
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="p-0">
                                                <div class="collapse p-3 fade" id="equipment-{{ $categorySlug }}">
                                                    <table class="table table-bordered">
                                                        <thead class="table-dark text-center">
                                                            <tr>
                                                                <th>Nama Peralatan</th>
                                                                <th>Jumlah</th>
                                                                <th>Lampiran</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($subCategories->flatten() as $equipment)
                                                                <tr class="text-center">
                                                                    <td class="fw-semibold">{{ $equipment->nama }}
                                                                    </td>
                                                                    <td><span
                                                                            class="badge bg-success">{{ $equipment->jumlah }}
                                                                            Unit</span></td>
                                                                    <td>
                                                                        @php $lampiran = $equipment->lampiran_foto @endphp
                                                                        @if ($lampiran)
                                                                            <a href="{{ asset('storage/' . $lampiran) }}"
                                                                                class="btn btn-outline-primary btn-sm shadow-sm"
                                                                                target="_blank">
                                                                                <i class="bi bi-file-earmark-image"></i>
                                                                                Lihat
                                                                            </a>
                                                                        @else
                                                                            <span class="text-muted">Tidak Ada</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Tahapan JSA -->
                        <h5 class="fw-bold text-primary mb-2 mt-4">Tahapan JSA</h5>
                        <div class="table-responsive mb-2">
                            <table class="table table-bordered table-hover align-middle shadow-sm">
                                <thead class="text-white text-center fw-bold table-dark">
                                    <tr>
                                        <th class="py-3 text-start ps-4">Tahapan</th>
                                        <th class="py-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($groupedJsaRecords as $tahapan => $jsaGroup)
                                        @php $tahapanId = Str::slug($tahapan); @endphp
                                        <tr class="text-center">
                                            <td class="text-start ps-4 fw-bold text-primary">
                                                <i class="bi bi-flag-fill me-2 text-warning"></i>
                                                {{ ucfirst($tahapan) }}
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary shadow-sm"
                                                    data-bs-toggle="collapse" data-bs-target="#jsa-{{ $tahapanId }}"
                                                    data-bs-parent=".table-responsive">
                                                    <i class="bi bi-eye"></i> Lihat Detail
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="p-0">
                                                <div class="collapse mt-2 p-3 rounded shadow-sm"
                                                    id="jsa-{{ $tahapanId }}" style="background: #f8f9fa;">
                                                    <table class="table table-bordered">
                                                        <thead class="table-dark text-center">
                                                            <tr>
                                                                <th>No.</th>
                                                                <th>Aktifitas</th>
                                                                <th>Potensi Bahaya</th>
                                                                <th>Upaya Pengendalian Bahaya & Risiko</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($jsaGroup as $jsa)
                                                                @php $sub = $jsa->subTahapan ?? collect(); @endphp
                                                                @forelse ($sub as $index => $subTahapan)
                                                                    <tr class="text-center">
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td class="fw-semibold text-dark">
                                                                            {{ $subTahapan->sub_tahapan ?? '-' }}
                                                                        </td>
                                                                        <td class="text-danger fw-bold">
                                                                            {{ $subTahapan->identifikasi_bahaya ?? '-' }}
                                                                        </td>
                                                                        <td class="text-success fw-bold">
                                                                            {{ $subTahapan->pengendalian_risiko ?? '-' }}
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td class="text-center">1</td>
                                                                        <td colspan="3" class="text-center text-muted">
                                                                            Tidak ada data sub-tahapan
                                                                        </td>
                                                                    </tr>
                                                                @endforelse
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-center text-muted">Belum ada data JSA</td>
                                            </tr>
                                        @endforelse
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('scripts')
        <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/js/flat-pickr/flatpickr.js') }}"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                initInductionPickers();
            });

            function initInductionPickers() {
                document.querySelectorAll("input[data-type='induction_date']").forEach(function(input) {
                    if (input._flatpickr) return;

                    let start = input.dataset.start;
                    let end = input.dataset.end;

                    if (!start || !end) {
                        console.warn("Tanggal mulai atau akhir tidak ditemukan.");
                        return;
                    }

                    let startDate = new Date(start);
                    startDate.setDate(startDate.getDate() + 1);

                    flatpickr(input, {
                        dateFormat: "Y-m-d",
                        minDate: startDate,
                        maxDate: end,
                        defaultDate: input.value || null,
                        allowInput: true
                    });
                });
            }
        </script>
        <script>
            document.addEventListener("click", async function(event) {
                let button = event.target.closest(
                    ".btn-approve, .btn-reject, .btn-approve-penyelesaian, .btn-reject-penyelesaian, .btn-approve-pembatalan, .btn-reject-pembatalan"
                );
                if (!button) return;

                let url = button.getAttribute("data-url");
                let isApprove = button.classList.contains("btn-approve") || button.classList.contains(
                    "btn-approve-penyelesaian") || button.classList.contains("btn-approve-pembatalan");
                let isPenyelesaian = button.classList.contains("btn-approve-penyelesaian") || button.classList
                    .contains("btn-reject-penyelesaian");
                let isPembatalan = button.classList.contains("btn-approve-pembatalan") || button.classList.contains(
                    "btn-reject-pembatalan");
                let actionText = isApprove ? "menyetujui" : "menolak";

                let timelineContent = button.closest(".timeline-content");
                let textarea = timelineContent?.querySelector("textarea") || timelineContent?.querySelector(
                    "textarea.approval-note");
                let keterangan = textarea ? textarea.value.trim() : "";

                let requestData = {
                    keterangan
                };

                // Ambil field tambahan (jika ada)
                let extraFields = button.getAttribute("data-extra-fields");
                if (extraFields) {
                    extraFields.split(",").forEach(field => {
                        field = field.trim();
                        let inputEl = timelineContent?.querySelector(`[name="${field}"]`);
                        if (inputEl) {
                            requestData[field] = inputEl.value.trim();
                        }
                    });
                }

                let jenis = isPembatalan ? "pembatalan" : (isPenyelesaian ? "penyelesaian" : "Work Permit");

                Swal.fire({
                    title: `Konfirmasi ${isApprove ? "Approve" : "Reject"}?`,
                    text: `Apakah Anda yakin ingin ${actionText} ${jenis} ini?`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: isApprove ? "#3085d6" : "#d33",
                    cancelButtonColor: "#aaa",
                    confirmButtonText: `Ya, ${isApprove ? "Approve" : "Reject"}!`,
                    cancelButtonText: "Batal"
                }).then(async (result) => {
                    if (!result.isConfirmed) return;

                    try {
                        let response = await fetch(url, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute("content"),
                            },
                            body: JSON.stringify(requestData),
                        });

                        let data = await response.json();

                        if (!response.ok || !data.success) {
                            throw new Error(data.message || "Terjadi kesalahan, silakan coba lagi.");
                        }

                        Swal.fire({
                            title: "Berhasil!",
                            text: `${jenis.charAt(0).toUpperCase() + jenis.slice(1)} telah ${isApprove ? "disetujui" : "ditolak"}.`,
                            icon: "success",
                            confirmButtonText: "OK",
                        }).then(() => location.reload());

                    } catch (error) {
                        console.error("Error:", error);
                        Swal.fire({
                            title: "Error!",
                            text: error.message,
                            icon: "error",
                            confirmButtonText: "OK",
                        });
                    }
                });
            });
        </script>


    @endsection
