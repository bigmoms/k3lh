@extends('layouts.master')
@section('title', 'Dashboard SHE Officer')
@section('header', 'Dashboard SHE Officer')
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-md-6 col-12">
                    <h2>Dashboard</h2>
                </div>
                <div class="col-md-6 col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="iconly-Home icli svg-color"></i></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">SHE Officer</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- Summary --}}
            <div class="col-lg-3 col-sm-6">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h6>Total PO</h6>
                        <h3 class="text-primary">{{ $totalPo }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h6>Total Work Permit</h6>
                        <h3 class="text-success">{{ $totalWorkPermit }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h6>PO Aktif</h6>
                        <h3 class="text-info">{{ $poAktif }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h6>PO Selesai</h6>
                        <h3 class="text-secondary">{{ $poSelesai }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Jadwal dan Grafik --}}
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5>Jadwal Kerja Bulan Ini</h5>
                    </div>
                    <div class="card-body">
                        <h1 class="text-center text-warning">{{ $jadwalBulanIni }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5>Grafik Work Permit Bulanan</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chartPermit"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header"><h5>PO Dibatalkan</h5></div>
                    <ul class="list-group list-group-flush">
                        @forelse ($poTanpaWp as $po)
                            <li class="list-group-item">
                                <strong>{{ $po->no_po }}</strong> - {{ $po->nama_pekerjaan }}
                                <div class="text-muted">{{ $po->vendor->vendor_name ?? '-' }}</div>
                            </li>
                        @empty
                            <li class="list-group-item text-muted text-center">Semua PO sudah punya WP.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header"><h5>WP Ditolak</h5></div>
                    <ul class="list-group list-group-flush">
                        @forelse ($wpDitolak as $wp)
                            <li class="list-group-item">
                                WP No: <strong>{{ $wp->no_dokumen ?? '-' }}</strong> <br>
                                Vendor: {{ $wp->vendor->nama_perusahaan ?? '-' }}
                            </li>
                        @empty
                            <li class="list-group-item text-muted text-center">Tidak ada WP yang ditolak.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        {{-- Jadwal Pending SHE --}}
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header"><h5>Jadwal Menunggu Approve SHE</h5></div>
                    <ul class="list-group list-group-flush">
                        @forelse ($jadwalMenungguSHE as $jadwal)
                            <li class="list-group-item">
                                PO: {{ $jadwal->purchaseOrder->no_po ?? '-' }} <br>
                                Periode: {{ $jadwal->periode_laporan }}
                            </li>
                        @empty
                            <li class="list-group-item text-muted text-center">Tidak ada yang menunggu approval SHE.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            {{-- Approval Terakhir --}}
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header"><h5>Approval SHE Terakhir</h5></div>
                    <ul class="list-group list-group-flush">
                        @forelse ($approvalTerakhir as $approval)
                            <li class="list-group-item">
                                WP: {{ $approval->workPermit->no_dokumen ?? '-' }} <br>
                                Disetujui oleh: {{ $approval->approver->name ?? '-' }} <br>
                                Tgl: {{ $approval->approved_at->format('d/m/Y H:i') }}
                            </li>
                        @empty
                            <li class="list-group-item text-muted text-center">Belum ada approval SHE terbaru.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        {{-- Pengajuan Pembatalan & Penyelesaian --}}
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header"><h5>Pengajuan Pembatalan</h5></div>
                    <ul class="list-group list-group-flush">
                        @forelse ($pembatalan as $item)
                            <li class="list-group-item">
                                PO: {{ $item->purchaseOrder->no_po ?? '-' }} <br>
                                Status: <strong>{{ ucfirst($item->status) }}</strong>
                            </li>
                        @empty
                            <li class="list-group-item text-muted text-center">Tidak ada pengajuan pembatalan.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header"><h5>Pengajuan Penyelesaian</h5></div>
                    <ul class="list-group list-group-flush">
                        @forelse ($penyelesaian as $item)
                            <li class="list-group-item">
                                PO: {{ $item->purchaseOrder->no_po ?? '-' }} <br>
                                Status: <strong>{{ ucfirst($item->status) }}</strong>
                            </li>
                        @empty
                            <li class="list-group-item text-muted text-center">Tidak ada pengajuan penyelesaian.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('chartPermit').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(range(1,12)) !!},
                datasets: [{
                    label: 'Work Permit',
                    data: {!! json_encode($monthlyWorkPermit->values()) !!},
                    backgroundColor: '#4e73df'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });
    </script>
@endsection
