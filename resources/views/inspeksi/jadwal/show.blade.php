@extends('layouts.master')
@section('title', 'Detail Jadwal Inspeksi')
@section('header', 'Detail Jadwal Inspeksi')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/js-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/flatpickr/flatpickr.min.css') }}">
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h3 class="fw-bold">Detail Jadwal Inspeksi K3LH</h3>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#"><i class="iconly-Home icli svg-color"></i></a>
                            </li>
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Jadwal Inspeksi</li>
                        </ol>
                    </div>
                </div>
            </div>

            @if (session('error'))
                <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white text-center py-3">
                            <h5 class="mb-0 fw-semibold">Informasi Jadwal Inspeksi</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Tanggal Inspeksi</label>
                                    <input type="text" class="form-control bg-primary text-white fw-bold"
                                        value="{{ tanggalIndo($jadwalInspeksi->tanggal_inspeksi) }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Jam Inspeksi</label>
                                    <input type="text" class="form-control bg-primary text-white fw-bold"
                                        value="{{ \Carbon\Carbon::parse($jadwalInspeksi->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwalInspeksi->jam_selesai)->format('H:i') }}"
                                        readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Lokasi Inspeksi</label>
                                    <input type="text" class="form-control bg-primary text-white fw-bold"
                                        value="{{ $jadwalInspeksi->divisiInspeksi->lokasi->nama_lokasi ?? '-' }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Divisi</label>
                                    <input type="text" class="form-control bg-primary text-white fw-bold"
                                        value="{{ $jadwalInspeksi->divisiInspeksi->nama_divisi }}" readonly>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Catatan</label>
                                    <textarea class="form-control bg-primary text-white fw-bold" rows="2" readonly>{{ $jadwalInspeksi->catatan ?? '-' }}</textarea>
                                </div>
                            </div>
                            <div class="mt-4 text-end">
                                <a href="{{ route('inspeksi.jadwal.index') }}" class="btn btn-secondary"> Kembali
                                </a>

                                <a href="{{ route('inspeksi.hasil.show', encodeId($jadwalInspeksi->id)) }}"
                                    class="btn btn-primary"> Lihat Hasil Inspeksi
                                </a>
                                {{-- @if($selesaiInspeksi)
                                <a href="{{ route('inspeksi.jadwal.previewNotaDinas', encodeId($jadwalInspeksi->id)) }}"
                                    class="btn btn-danger" target="_blank">
                                    <i class="fas fa-file-pdf me-2"></i> Preview Nota Dinas
                                </a>
                                @endif --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
