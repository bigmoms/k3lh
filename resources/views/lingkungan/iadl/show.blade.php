@extends('layouts.master')
@section('title', 'Detail IADL')
@section('header', 'Detail Identifikasi Aspek Dampak Lingkungan')

@section('content')
    <div class="page-body">
        <div class="container-fluid py-4">
            <div class="container-fluid" style="margin-top: -18px">
                <div class="page-title">
                    <div class="row align-items-center">
                        <div class="col-md-6 col-12">
                            <h2 class="mb-0">Detail Identifikasi Aspek Dampak Lingkungan</h2>
                        </div>
                        <div class="col-md-6 col-12 text-md-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="iconly-Home icli svg-color"></i></a>
                                </li>
                                <li class="breadcrumb-item">Dashboard</li>
                                <li class="breadcrumb-item active">Detail IADL</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST"
                action="{{ $tampilForm ? route('lingkungan.iadl.update-peraturan', ['id' => $batchId ?? 'dummy']) : '#' }}">
                @csrf
                @method('PUT')

                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Lokasi</label>
                                <input type="text" class="form-control bg-primary" value="{{ $lokasi->nama_lokasi }}"
                                    readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tahun</label>
                                <input type="text" class="form-control bg-primary" value="{{ $tahun }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle text-nowrap">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">Aktifitas</th>
                                        <th rowspan="2">Aspek Lingkungan</th>
                                        <th rowspan="2">Dampak Lingkungan</th>
                                        <th rowspan="2">Risiko Lingkungan</th>
                                        <th rowspan="2">N / AB / E</th>
                                        <th rowspan="2">No. Dampak</th>
                                        <th colspan="3">Nilai Risiko Awal</th>
                                        <th rowspan="2">Tingkat Risiko Awal</th>
                                        <th rowspan="2">Pengendalian Saat Ini</th>
                                        <th colspan="3">Nilai Risiko Setelah Pengendalian</th>
                                        <th rowspan="2">Tingkat Risiko Akhir</th>
                                        <th rowspan="2">Peluang</th>
                                        <th rowspan="2">Peraturan Perundangan</th>
                                        <th rowspan="2">Pengendalian Lanjutan</th>
                                        <th rowspan="2">Status</th>
                                    </tr>
                                    <tr>
                                        <th>L</th>
                                        <th>C</th>
                                        <th>TOT</th>
                                        <th>L</th>
                                        <th>C</th>
                                        <th>TOT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach ($groupedData as $aktivitasId => $kegiatanList)
                                        @foreach ($kegiatanList as $index => $item)
                                            <tr>
                                                @if ($index === 0)
                                                    <td class="text-center fw-bold" rowspan="{{ $kegiatanList->count() }}">
                                                        {{ $no++ }}</td>
                                                    <td rowspan="{{ $kegiatanList->count() }}">
                                                        {{ $item->aktivitas->aktifitas }}
                                                    </td>
                                                @endif

                                                <td>{{ $item->aspek_lingkungan }}</td>
                                                <td>{{ $item->dampak_lingkungan }}</td>
                                                <td>{{ $item->risiko_lingkungan }}</td>
                                                <td class="text-center">{{ $item->na_be }}</td>
                                                <td class="text-center">{{ $item->no_dampak }}</td>
                                                <td class="text-center">{{ $item->l_awal }}</td>
                                                <td class="text-center">{{ $item->c_awal }}</td>
                                                <td class="text-center">{{ $item->total_awal }}</td>
                                                <td class="text-center">{{ $item->tingkat_risiko_awal }}</td>
                                                <td>{{ $item->pengendalian_saat_ini }}</td>
                                                <td class="text-center">{{ $item->l_akhir }}</td>
                                                <td class="text-center">{{ $item->c_akhir }}</td>
                                                <td class="text-center">{{ $item->total_akhir }}</td>
                                                <td
                                                    class="text-center fw-bold {{ $item->tingkat_risiko_akhir === 'H' ? 'text-danger' : '' }}">
                                                    {{ $item->tingkat_risiko_akhir }}</td>
                                                <td>{{ $item->peluang }}</td>

                                                @if ($tampilForm)
                                                    <td>
                                                        @if (!$item->peraturan_perundangan)
                                                            <textarea name="data[{{ $item->id }}][peraturan_perundangan]" class="form-control editable"
                                                                data-id="{{ $item->id }}" data-field="peraturan_perundangan" placeholder="Isi peraturan...">{{ old("data.{$item->id}.peraturan_perundangan") }}</textarea>
                                                        @else
                                                            {{ $item->peraturan_perundangan }}
                                                        @endif
                                                    </td>
                                                @else
                                                    <td>{{ $item->peraturan_perundangan }}</td>
                                                @endif

                                                <td>{{ $item->pengendalian_lanjutan }}</td>
                                                <td class="text-center">
                                                    @if ($item->status === 'prioritas')
                                                        <span class="badge bg-danger">Prioritas</span>
                                                    @elseif ($item->status === 'non_prioritas')
                                                        <span class="badge bg-secondary">Non Prioritas</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @if ($isInternal && $dataHighRisk->count())
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-danger text-white fw-semibold">
                            Risiko Tinggi Ditemukan
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Silakan tentukan status prioritas untuk item berikut:</p>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-danger text-center">
                                        <tr>
                                            <th>No</th>
                                            <th>Aktifitas</th>
                                            <th>Aspek Lingkungan</th>
                                            <th>Dampak Lingkungan</th>
                                            <th>No Dampak</th>
                                            <th>Tingkat Risiko Akhir</th>
                                            <th>Peraturan Perundangan</th>
                                            <th>Pengendalian Lanjutan</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataHighRisk as $index => $item)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>{{ $item->aktivitas->aktifitas }}</td>
                                                <td>{{ $item->aspek_lingkungan }}</td>
                                                <td>{{ $item->dampak_lingkungan }}</td>
                                                <td>{{ $item->no_dampak }}</td>
                                                <td class="text-center text-danger fw-bold">
                                                    {{ $item->tingkat_risiko_akhir }}
                                                </td>
                                                <td>{{ $item->peraturan_perundangan }}</td>
                                                <td>{{ $item->pengendalian_lanjutan }}</td>
                                                <td>
                                                    <select name="data[{{ $item->id }}][status]" class="form-select">
                                                        <option value="">- Pilih -</option>
                                                        <option value="prioritas"
                                                            {{ old("data.{$item->id}.status", $item->status) === 'prioritas' ? 'selected' : '' }}>
                                                            Prioritas</option>
                                                        <option value="non_prioritas"
                                                            {{ old("data.{$item->id}.status", $item->status) === 'non_prioritas' ? 'selected' : '' }}>
                                                            Non Prioritas</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('lingkungan.iadl.download', $encodedId) }}" target="_blank" class="btn btn-danger">
                        <i class="fas fa-file-pdf me-1"></i>Download PDF
                    </a>

                    @if ($tampilForm)
                        <button type="button" class="btn btn-primary" id="submit-btn" data-batch="{{ $batchId }}">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                    @endif

                    <a href="{{ route('lingkungan.iadl.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const submitBtn = document.getElementById('submit-btn');
            if (!submitBtn) return;

            const batchId = submitBtn.dataset.batch;

            submitBtn.addEventListener('click', function() {
                const data = {};

                document.querySelectorAll('.editable').forEach(textarea => {
                    const id = textarea.dataset.id;
                    const field = textarea.dataset.field;
                    const value = textarea.value.trim();
                    if (!data[id]) data[id] = {};
                    data[id][field] = value;
                });

                document.querySelectorAll('select[name^="data["]').forEach(select => {
                    const match = select.name.match(/^data\[(\d+)]\[(\w+)]$/);
                    if (match) {
                        const id = match[1];
                        const field = match[2];
                        if (!data[id]) data[id] = {};
                        data[id][field] = select.value;
                    }
                });

                fetch(`/lingkungan/iadl/${batchId}/peraturan`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            data
                        })
                    })
                    .then(res => {
                        if (!res.ok) throw new Error('Gagal menyimpan data');
                        return res.json();
                    })
                    .then(result => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: result.message || 'Data berhasil diperbarui.',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = "{{ route('lingkungan.iadl.index') }}";
                        });
                    })
                    .catch(() => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan saat menyimpan data.',
                        });
                    });
            });
        });
    </script>
@endsection
