@extends('layouts.master')
@section('title', 'Lihat Hasil Pengukuran Lingkungan Kerja')
@section('header', 'Lihat Hasil Pengukuran Lingkungan Kerja')

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/select2.css') }}">
    <style>
        .section-title {
            font-size: 22px;
            font-weight: 600;
            color: #333;
        }

        .info-text {
            color: #666;
            font-size: 14px;
        }

        .lokasi-card {
            border: 1px solid #e1e5ec;
            border-radius: 8px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06);
            margin-bottom: 24px;
        }

        .lokasi-header {
            background: #f5f8fc;
            padding: 16px 20px;
            border-bottom: 1px solid #e0e0e0;
            font-weight: 600;
            font-size: 18px;
            color: #0056b3;
        }

        .table thead {
            background: #f9f9f9;
            font-size: 13px;
        }

        .table td,
        .table th {
            vertical-align: middle !important;
            text-align: center;
            font-size: 13px;
        }

        .confirmation-section {
            padding: 20px;
            background: #f0fdf4;
            border: 1px solid #d1fadf;
            border-radius: 8px;
            text-align: center;
        }

        .confirmed-alert {
            padding: 20px;
            background: #fef9c3;
            border: 1px solid #fcd34d;
            border-radius: 8px;
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <h2 class="section-title">Hasil Pengukuran Lingkungan Kerja</h2>
                    </div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#"><i class="iconly-Home icli svg-color"></i></a>
                        </li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Lihat Hasil</li>
                    </ol>
                </div>
            </div>

            @php
                $user = Auth::user()->load('lokasiLingkungan');
                $userLokasiIds = $user->lokasiLingkungan->pluck('id')->toArray();
                $konfirmasi = $jadwal->konfirmasi_lokasi ?? [];
            @endphp

            <div class="row">
                @foreach ($jadwal->lokasi as $lokasi)
                    @php $sudahDikonfirmasi = isset($konfirmasi[$lokasi->id]); @endphp

                    <div class="col-12">
                        <div class="lokasi-card">
                            <div class="lokasi-header">
                                Lokasi: {{ $lokasi->nama_lokasi }}
                                <p class="info-text mb-0">Tanggal Pengukuran:
                                    {{ \Carbon\Carbon::parse($jadwal->tanggal_pengukuran)->translatedFormat('d F Y') }}
                                </p>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Divisi</th>
                                            @foreach (['Cahaya', 'Suhu', 'Kelembaban', 'Kebisingan'] as $param)
                                                <th colspan="4">{{ $param }}</th>
                                            @endforeach
                                            <th rowspan="2">Catatan</th>
                                        </tr>
                                        <tr>
                                            @foreach (range(1, 4) as $group)
                                                @foreach (range(1, 3) as $i)
                                                    <th>{{ $i }}</th>
                                                @endforeach
                                                <th>Rata²</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($lokasi->divisis as $divisi)
                                            @php $hasil = $pengukurans[$divisi->id]->first() ?? null; @endphp
                                            <tr>
                                                <td class="text-start">{{ $divisi->nama_divisi }}</td>
                                                @foreach (['cahaya', 'suhu', 'kelembaban', 'kebisingan'] as $param)
                                                    @foreach (range(1, 3) as $i)
                                                        <td>{{ $hasil?->{$param . '_' . $i} ?? '-' }}</td>
                                                    @endforeach
                                                    <td class="fw-bold text-primary">
                                                        {{ $hasil?->{$param . '_rata2'} ?? '-' }}</td>
                                                @endforeach
                                                <td class="text-start">{{ $hasil?->catatan ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-end align-items-center mt-3 flex-wrap gap-2 mb-2 me-3">
                                <div>
                                    @if ($sudahDikonfirmasi)
                                        <div class="alert alert-success mb-0 py-2 px-3">
                                            Telah dikonfirmasi oleh
                                            <strong>{{ $konfirmasi[$lokasi->id]['nama'] ?? 'User' }}</strong>
                                            pada
                                            {{ \Carbon\Carbon::parse($konfirmasi[$lokasi->id]['tanggal'])->translatedFormat('d F Y H:i') }}
                                        </div>
                                    @elseif (in_array($lokasi->id, $userLokasiIds))
                                        <form action="{{ route('pengukuran.konfirmasi', $jadwal->id) }}" method="POST"
                                            class="mb-0 form-konfirmasi">
                                            @csrf
                                            <input type="hidden" name="lokasi_id" value="{{ $lokasi->id }}">
                                            <button type="button" class="btn btn-success btn-sm btn-konfirmasi">
                                                <i class="bi bi-check-circle"></i> Konfirmasi Lokasi Ini
                                            </button>
                                        </form>
                                    @endif
                                </div>
                                <div>
                                    <a href="{{ route('lingkungan.hasil.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="bi bi-arrow-left-circle"></i> Kembali
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.btn-konfirmasi').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Konfirmasi?',
                    text: "Yakin Anda sudah menerima hasil pengukuran ini?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, konfirmasi!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.closest('.form-konfirmasi').submit();
                    }
                });
            });
        });
    </script>
@endsection
