@extends('layouts.master')

@section('title', 'Detail Jadwal Pengukuran')
@section('header', 'Detail Jadwal Pengukuran')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/js-datatables/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flatpickr/flatpickr.min.css') }}">
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-sm-6 col-12">
                        <h2>Detail Jadwal Pengukuran</h2>
                    </div>
                    <div class="col-sm-6 col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="iconly-Home icli svg-color"></i></a></li>
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Jadwal Pengukuran</li>
                        </ol>
                    </div>
                </div>
            </div>

            @if (session('error'))
                <div class="alert alert-warning">
                    {{ session('error') }}
                </div>
            @endif

            <div class="row">
                <div class="col-lg-12 mx-auto">
                    <div class="card shadow-lg border-0">
                        <div class="card-header bg-primary text-white text-center py-3">
                            <h1 class="mb-0">Data Jadwal Pengukuran</h1>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold fs-6">Status</label>
                                    <input class="form-control fw-bold bg-primary text-white" type="text"
                                        value="{{ ucfirst($jadwal->status) }}" readonly />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold fs-6">Tanggal Pengukuran</label>
                                    <input class="form-control fw-bold bg-primary text-white" type="text"
                                        value="{{ \Carbon\Carbon::parse($jadwal->tanggal_pengukuran)->translatedFormat('d F Y') }}"
                                        readonly />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold fs-6">Waktu</label>
                                    <input class="form-control fw-bold bg-primary text-white" type="text"
                                        value="{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}"
                                        readonly />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold fs-6">Catatan</label>
                                    <textarea class="form-control fw-bold bg-primary text-white" rows="2" readonly>{{ $jadwal->catatan ?? '-' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 mt-2">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white text-center py-3">
                            <h1 class="mb-0">Daftar Lokasi & Divisi</h1>
                        </div>
                        <div class="card-body">
                            @forelse ($jadwal->lokasi as $lokasi)
                                <div class="mb-4 pb-3 border-bottom">
                                    <h5 class="fw-bold text-primary">{{ $lokasi->nama_lokasi }}</h5>
                                    @if ($lokasi->divisis->count())
                                        <div class="mt-2">
                                            <h6 class="fw-bold text-muted mb-2">Divisi:</h6>
                                            <div class="row row-cols-1 row-cols-md-2 g-3">
                                                @foreach ($lokasi->divisis as $divisi)
                                                    <div class="col">
                                                        <div class="border rounded px-3 py-2 h-100">
                                                            <label class="form-label small text-muted mb-1">Nama Divisi</label>
                                                            <input class="form-control bg-white fw-semibold" type="text"
                                                                value="{{ $divisi->nama_divisi }}" readonly />
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <p class="mt-2"><em class="text-muted">Tidak ada divisi untuk lokasi ini.</em></p>
                                    @endif
                                </div>
                            @empty
                                <p><em>Tidak ada data lokasi.</em></p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
