@extends('layouts.master')

@section('title', 'Detail Hasil Inspeksi')
@section('header', 'Detail Hasil Inspeksi')

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
                        <h2>Detail Hasil Inspeksi K3LH</h2>
                    </div>
                    <div class="col-sm-6 col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:;"><i
                                        class="iconly-Home icli svg-color"></i></a></li>
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Hasil Inspeksi</li>
                        </ol>
                    </div>
                </div>
            </div>

            @php
                $jadwal = $hasilInspeksiList->first()->jadwalInspeksi ?? null;
                $divisi = $jadwal->divisiInspeksi ?? null;
            @endphp

            <div class="row">
                <div class="col-lg-12 mx-auto">
                    <div class="card shadow-lg border-0">
                        <div class="card-header bg-primary text-white text-center py-3">
                            <h1 class="mb-0">Data Inspeksi</h1>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold fs-6">Tanggal Inspeksi</label>
                                    <input class="form-control fw-bold bg-primary" type="text"
                                        value="{{ \Carbon\Carbon::parse($jadwal->tanggal_inspeksi)->format('d M Y') }}"
                                        readonly />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold fs-6">Lokasi Inspeksi</label>
                                    <input class="form-control fw-bold bg-primary" type="text"
                                        value="{{ $jadwal->divisiInspeksi->nama_divisi ?? '-' }}" readonly />
                                </div>
                            </div>
                            @if ($jadwal->status_akhir == 'selesai')
                                <div class="alert alert-success mt-3">
                                    Hasil Perbaikan Inspeksi ini telah diverifikasi pada
                                    {{ $jadwal->verifikasi_tanggal->format('d M Y H:i') }}.
                                </div>
                                <a href="{{ route('inspeksi.previewPdf', $jadwal->id) }}" target="_blank"
                                    class="btn btn-secondary">
                                    <i class="fas fa-print"></i> Print Hasil Inspeksi
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                @if ($jadwal->cekMateriInspeksi->count())
                    <div class="col-lg-12 mx-auto">
                        <div class="card shadow-lg border-0">
                            <div class="card-header bg-primary text-white text-center">
                                <h1>Checklist Materi Inspeksi</h1>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered align-middle text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th rowspan="2" style="width: 60%">Materi</th>
                                            <th colspan="2" style="width: 20%">Check</th>
                                            <th rowspan="2" style="width: 20%">Catatan</th>
                                        </tr>
                                        <tr>
                                            <th style="width: 10%">TS</th>
                                            <th style="width: 10%">S</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-start">
                                        @php
                                            $grouped = $jadwal->cekMateriInspeksi->groupBy(
                                                fn($item) => $item->subKategori->kategori->nama_kategori ?? 'Lainnya',
                                            );
                                        @endphp

                                        @foreach ($grouped as $kategori => $items)
                                            <tr>
                                                <td colspan="4" class="fw-bold text-primary bg-primary">{{ $kategori }}</td>
                                            </tr>

                                            @foreach ($items as $cek)
                                                <tr>
                                                    <td>{{ $cek->subKategori->nama_sub_kategori ?? '-' }}</td>
                                                    <td class="text-center">
                                                        <input type="radio" {{ $cek->status === 'TS' ? 'checked' : '' }}
                                                            disabled>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="radio" {{ $cek->status === 'S' ? 'checked' : '' }}
                                                            disabled>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            value="{{ $cek->catatan ?? '-' }}" readonly>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-lg-12 mx-auto mt-2">
                    <div class="card shadow border-0">
                        <div class="card-header bg-primary text-white text-center py-3">
                            <h1 class="mb-0">Hasil dan Tindak Lanjut Inspeksi</h1>
                        </div>
                        <div class="card-body table-responsive" style="overflow-x: auto;">
                            <table class="table table-bordered mb-2" id="datatable-hasil-tindaklanjut"
                                style="min-width: 1500px;">
                                <thead class="table-light text-center">
                                    @php
                                        $user = Auth::user();
                                        $isInspeksiUser = $jadwal->divisiInspeksi->users->contains('id', $user->id);
                                    @endphp

                                    <tr>
                                        <th>No</th>
                                        <th>Hasil Inspeksi</th>
                                        <th>Saran Perbaikan</th>
                                        <th>Target Penyelesaian</th>
                                        <th>Status</th>
                                        <th>Foto</th>
                                        <th>Telah Diperbaiki</th>
                                        <th>Catatan Perbaikan</th>
                                        <th>Foto Perbaikan</th>
                                        @if ($isInspeksiUser)
                                            <th>Catatan Perbaikan</th>
                                            <th>Aksi</th>
                                        @endif
                                    </tr>


                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach ($hasilInspeksiList as $hasil)
                                        @if ($hasil->tindakLanjut->isEmpty())
                                            <tr>
                                                <td class="text-center">{{ $no++ }}</td>
                                                <td>{{ $hasil->hasil_inspeksi }}</td>
                                                <td class="text-center text-muted" colspan="4">Belum ada tindak lanjut
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" name="telah_diperbaiki" disabled>
                                                </td>
                                                <td class="text-center">
                                                    <input type="file" name="foto_perbaikan" disabled>
                                                </td>
                                                @if (Auth::user()->divisi_inspeksi_id)
                                                    <td class="text-center">-</td>
                                                @endif
                                            </tr>
                                        @else
                                            @foreach ($hasil->tindakLanjut as $tindak)
                                                <tr>
                                                    <td class="text-center">{{ $no++ }}</td>
                                                    <td>{{ $hasil->hasil_inspeksi }}</td>
                                                    <td>{{ $tindak->saran_perbaikan }}</td>
                                                    @php
                                                        $target = \Carbon\Carbon::parse(
                                                            $tindak->target_penyelesaian,
                                                        )->startOfDay();
                                                        $now = \Carbon\Carbon::now()->startOfDay();
                                                        $hari = $now->diffInDays($target, false);
                                                    @endphp
                                                    <td class="text-center">
                                                        {{ $hari > 0 ? $hari . ' hari dari sekarang' : ($hari < 0 ? abs($hari) . ' hari yang lalu' : 'Hari ini') }}
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($tindak->status == 'selesai')
                                                            <span class="badge bg-success">Selesai</span>
                                                        @else
                                                            <span class="badge bg-warning text-dark">Belum Selesai</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($hasil->hasil_gambar)
                                                            <a href="{{ asset('storage/' . $hasil->hasil_gambar) }}"
                                                                target="_blank">
                                                                <img src="{{ asset('storage/' . $hasil->hasil_gambar) }}"
                                                                    alt="Foto" class="img-thumbnail" width="100">
                                                            </a>
                                                        @endif
                                                    </td>

                                                    <td class="text-center">
                                                        <input type="checkbox" disabled
                                                            {{ $tindak->status == 'selesai' ? 'checked' : '' }}>
                                                    </td>

                                                    <td class="text-center">
                                                        @if ($tindak->catatan_perbaikan)
                                                            {{ $tindak->catatan_perbaikan }}
                                                        @else
                                                            <span class="text-muted">Belum ada catatan perbaikan</span>
                                                        @endif
                                                    </td>

                                                    <td class="text-center">
                                                        @if ($tindak->foto_perbaikan)
                                                            <a href="{{ asset('storage/' . $tindak->foto_perbaikan) }}"
                                                                target="_blank">
                                                                <img src="{{ asset('storage/' . $tindak->foto_perbaikan) }}"
                                                                    width="100" class="img-thumbnail">
                                                            </a>
                                                        @else
                                                            <span class="text-muted">Belum ada foto perbaikan</span>
                                                        @endif
                                                    </td>

                                                    @if ($isInspeksiUser)
                                                        <td class="text-center">
                                                            @if ($tindak->catatan_perbaikan)
                                                                {{ $tindak->catatan_perbaikan }}
                                                            @elseif (!$tindak->foto_perbaikan)
                                                                <form
                                                                    action="{{ route('inspeksi.inspeksi.perbaikan', $tindak->id) }}"
                                                                    method="POST" enctype="multipart/form-data"
                                                                    class="d-flex flex-column gap-2 align-items-start">
                                                                    @csrf
                                                                    <textarea name="catatan_perbaikan" class="form-control" rows="2" placeholder="Catatan perbaikan" required>{{ old('catatan_perbaikan') }}</textarea>
                                                                @else
                                                                    <span class="text-muted">-</span>
                                                            @endif
                                                        </td>

                                                        <td>
                                                            @if (!$tindak->foto_perbaikan)
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        name="telah_diperbaiki"
                                                                        {{ $tindak->status == 'selesai' ? 'checked' : '' }}
                                                                        required>
                                                                    <label class="form-check-label">Telah
                                                                        Diperbaiki</label>
                                                                </div>

                                                                <input type="file" name="foto_perbaikan"
                                                                    accept=".jpg,.png,.jpeg" required
                                                                    class="form-control mt-1">

                                                                <button type="submit"
                                                                    class="btn btn-success btn-sm mt-2">Kirim</button>
                                                                </form>
                                                            @else
                                                                <span class="text-muted">Sudah melakukan perbaikan</span>
                                                            @endif
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>

                            @if ($jadwal->status_akhir !== 'selesai' && $semuaTindakLanjutSudahSelesai && !Auth::user()->divisiInspeksi()->exists())
                                <form id="formSelesaikanInspeksi"
                                    action="{{ route('inspeksi.inspeksi.selesaikan', $jadwal->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="button" id="btnSelesaikanInspeksi" class="btn btn-primary mt-3">
                                        Verifikasi Hasil Inspeksi
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).on('submit', '.form-perbaikan', function(e) {
            e.preventDefault();

            let form = $(this);
            let formData = new FormData(this);

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false,
                        willClose: () => {
                            location.reload();
                        }
                    });

                    if (response.foto_perbaikan_url) {
                        form.find('input[name="foto_perbaikan"]').prop('disabled', true);
                        form.find('.preview-foto').html(
                            `<a href="${response.foto_perbaikan_url}" target="_blank">
                        <img src="${response.foto_perbaikan_url}" width="100" class="mt-2 img-thumbnail">
                    </a>`
                        );
                        form.find('button[type="submit"]').remove();
                    }

                    if (response.status === 'selesai') {
                        let statusCell = form.closest('tr').find('.status-cell');
                        statusCell.html('<span class="badge bg-success">Selesai</span>');

                        form.find('input[name="telah_diperbaiki"]')
                            .prop('checked', true)
                            .prop('disabled', true);
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal menyimpan perbaikan. Pastikan semua input valid.',
                    });
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('btnSelesaikanInspeksi');
            const form = document.getElementById('formSelesaikanInspeksi');

            if (btn && form) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Yakin menyelesaikan inspeksi ini?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, selesaikan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            }
        });
    </script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                timer: 2500,
                showConfirmButton: false,
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: "{{ session('error') }}",
                timer: 2500,
                showConfirmButton: false,
            });
        </script>
    @endif

@endsection
