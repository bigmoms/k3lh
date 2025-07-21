@extends('layouts.master')
@section('title', 'Tambah Hasil Inspeksi')
@section('header', 'Tambah Hasil Inspeksi')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flatpickr/flatpickr.min.css') }}">
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h3 class="fw-bold mb-0">Tambah Hasil Inspeksi K3LH</h3>
                    </div>
                    <div class="col-md-6 text-end">
                        <ol class="breadcrumb mb-0 bg-transparent p-0">
                            <li class="breadcrumb-item"><a href="#"><i class="iconly-Home icli svg-color"></i></a>
                            </li>
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Tambah Hasil Inspeksi</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Form Tambah Hasil Inspeksi</h5>
                        </div>
                        <div class="card-body">
                            <form id="hasilInspeksiForm" method="POST" action="{{ route('inspeksi.hasil.store') }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label for="jadwal_inspeksi_id" class="form-label fw-semibold">Pilih Jadwal Inspeksi
                                        <span class="text-danger">*</span></label>
                                    <select id="jadwal_inspeksi_id" name="jadwal_inspeksi_id" class="form-select select2"
                                        required>
                                        <option value="" disabled selected>Pilih Jadwal</option>
                                        @foreach ($jadwalInspeksi as $jadwal)
                                            <option value="{{ $jadwal->id }}"
                                                data-tanggal="{{ $jadwal->tanggal_inspeksi }}">
                                                {{ tanggalIndo($jadwal->tanggal_inspeksi) }} -
                                                {{ $jadwal->divisiInspeksi->nama_divisi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <hr class="my-4">

                                <div id="titikInspeksiContainer"></div>

                                <div class="d-flex gap-2 mt-3">
                                    <button type="button" id="addTitikInspeksi" class="btn btn-primary">
                                        <i class="fas fa-plus me-1"></i> Tambah Titik
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-1"></i> Simpan Semua
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card mt-4 shadow-sm border-0">
                        <div class="card-header bg-primary">
                            <h5 class="mb-0">Checklist Materi Inspeksi</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th rowspan="2" class="align-middle">Materi</th>
                                            <th colspan="2">Check</th>
                                            <th rowspan="2" class="align-middle">Catatan</th>
                                        </tr>
                                        <tr>
                                            <th>TS</th>
                                            <th>S</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-start">
                                        @foreach ($kategoriInspeksi as $kategori)
                                            <tr>
                                                <td colspan="4" class="fw-bold text-primary bg-primary">
                                                    {{ $kategori->nama_kategori }}
                                                </td>
                                            </tr>
                                            @forelse ($kategori->subKategori as $sub)
                                                <tr>
                                                    <td>{{ $sub->nama_sub_kategori }}</td>
                                                    <td class="text-center">
                                                        <input type="radio" name="cek_materi[{{ $sub->id }}][status]"
                                                            value="TS">
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="radio"
                                                            name="cek_materi[{{ $sub->id }}][status]" value="S">
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            name="cek_materi[{{ $sub->id }}][catatan]"
                                                            class="form-control" placeholder="Catatan jika ada">
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-muted text-center">Tidak ada subkategori
                                                    </td>
                                                </tr>
                                            @endforelse
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4 shadow-sm border-0">
                        <div class="card-header bg-primary">
                            <h5 class="mb-0">Data Titik Inspeksi Sementara</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="tabelTitikSementara">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th>No</th>
                                            <th>Hasil Inspeksi</th>
                                            <th>Gambar</th>
                                            <th>Saran Perbaikan</th>
                                            <th>Target Penyelesaian</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center align-middle">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/flat-pickr/flatpickr.js') }}"></script>

    <script>
        const kategoriInspeksi = @json($kategoriInspeksiData);
    </script>


    <script>
        $(document).ready(function() {
            let dataTitik = [];
            let counter = 1;

            $('.select2').select2({
                placeholder: "Cari Jadwal...",
                allowClear: true,
                minimumInputLength: 2
            });

            $('#addTitikInspeksi').click(function() {
                const selectedOption = $('#jadwal_inspeksi_id option:selected');
                const tanggalInspeksi = selectedOption.data('tanggal');

                if (!tanggalInspeksi) {
                    Swal.fire('Perhatian', 'Silakan pilih Jadwal Inspeksi terlebih dahulu.', 'warning');
                    return;
                }

                const newTitikForm = `
        <div class="card mb-4 border rounded-3 shadow-sm titik-form-item">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h6 class="mb-0 text-primary fw-semibold">Titik Inspeksi Baru</h6>
                    <span class="badge rounded-pill bg-dark text-dark border">#${counter}</span>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Hasil Inspeksi <span class="text-danger">*</span></label>
                    <textarea class="form-control hasil_inspeksi" rows="3" placeholder="Contoh: Terdapat kabel terbuka di area mesin..."></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Upload Gambar (Opsional)</label>
                    <input type="file" class="form-control gambar" accept="image/*">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Saran Perbaikan <span class="text-danger">*</span></label>
                    <textarea class="form-control saran_perbaikan" rows="2" placeholder="Contoh: Tutup kabel dengan pelindung standar..."></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Target Penyelesaian <span class="text-danger">*</span></label>
                    <input type="text" class="form-control datepicker target_penyelesaian">
                </div>

                <div class="text-end">
                    <button type="button" class="btn btn-sm btn-success saveTitikInspeksi">
                        <i class="fas fa-save me-1"></i> Simpan Titik
                    </button>
                </div>
            </div>
        </div>
    `;
                var $newForm = $(newTitikForm);
                $('#titikInspeksiContainer').append($newForm);

                $newForm.find('.datepicker').flatpickr({
                    dateFormat: "Y-m-d",
                    minDate: tanggalInspeksi
                });
            });

            $(document).on('click', '.saveTitikInspeksi', function() {
                const container = $(this).closest('.titik-form-item');
                const hasilInspeksi = container.find('.hasil_inspeksi').val();
                const gambarInput = container.find('.gambar')[0];
                const gambarFile = gambarInput.files[0];
                const saranPerbaikan = container.find('.saran_perbaikan').val();
                const targetPenyelesaian = container.find('.target_penyelesaian').val();

                if (!hasilInspeksi || !saranPerbaikan || !targetPenyelesaian) {
                    Swal.fire('Lengkapi Data', 'Semua field wajib diisi, kecuali gambar.', 'warning');
                    return;
                }

                const gambarPreview = gambarFile ?
                    `<img src="${URL.createObjectURL(gambarFile)}" class="img-thumbnail" style="max-height: 80px;" alt="Preview">` :
                    '<span class="text-muted">Tidak ada</span>';

                dataTitik.push({
                    no: counter++,
                    hasilInspeksi,
                    gambarPreview,
                    saranPerbaikan,
                    targetPenyelesaian,
                    gambarFile
                });

                renderTable();
                container.remove();
            });

            function renderTable() {
                const tbody = $('#tabelTitikSementara tbody');
                tbody.html('');

                dataTitik.forEach((item, index) => {
                    const row = `
            <tr>
                <td>${item.no}</td>
                <td>${item.hasilInspeksi}</td>
                <td class="text-center">${item.gambarPreview}</td>
                <td>${item.saranPerbaikan}</td>
                <td>${item.targetPenyelesaian}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger deleteTitik" data-index="${index}">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
        `;
                    tbody.append(row);
                });
            }

            $(document).on('click', '.deleteTitik', function() {
                const index = $(this).data('index');
                dataTitik.splice(index, 1);
                renderTable();
            });

            $('#hasilInspeksiForm').submit(function(e) {
                e.preventDefault();
                var form = this;
                var formData = new FormData(form);

                let isValid = true;
                let errorMessage = '';

                for (const kategori of kategoriInspeksi) {
                    for (const sub of kategori.subKategori) {
                        let selectedStatus = $(`input[name="cek_materi[${sub.id}][status]"]:checked`).val();
                        let catatan = $(`input[name="cek_materi[${sub.id}][catatan]"]`).val().trim();

                        if (!selectedStatus) {
                            isValid = false;
                            errorMessage = "Semua materi harus dipilih (TS atau S).";
                        } else if (selectedStatus === 'TS' && catatan === '') {
                            isValid = false;
                            errorMessage =
                                `Jika memilih TS, kolom catatan wajib diisi untuk materi: '${sub.nama_sub_kategori}'.`;
                        }

                        if (!isValid) break;
                    }
                    if (!isValid) break;
                }

                if (!isValid) {
                    Swal.fire('Validasi Gagal', errorMessage, 'warning');
                    return;
                }

                if (dataTitik.length === 0) {
                    Swal.fire('Error', 'Minimal 1 titik inspeksi harus disimpan.', 'error');
                    return;
                }

                $('input[name^="cek_materi"]').each(function() {
                    let name = $(this).attr('name');
                    let value = $(this).val();
                    let checked = $(this).is(':radio') ? $(this).is(':checked') : true;

                    if (checked) {
                        formData.append(name, value);
                    }
                });

                dataTitik.forEach(function(item) {
                    formData.append('hasil_inspeksi[]', item.hasilInspeksi);
                    formData.append('saran_perbaikan[]', item.saranPerbaikan);
                    formData.append('target_penyelesaian[]', item.targetPenyelesaian);
                    if (item.gambarFile) {
                        formData.append('hasil_gambar[]', item.gambarFile);
                    }
                });

                $.ajax({
                    type: "POST",
                    url: $(form).attr('action'),
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.btn-success').attr('disabled', true).text('Menyimpan...');
                    },
                    success: function(response) {
                        Swal.fire('Berhasil', 'Data berhasil disimpan', 'success')
                            .then(() => {
                                window.location.href = "/inspeksi/hasil-inspeksi";
                            });
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal', 'Terjadi kesalahan saat menyimpan', 'error');
                        $('.btn-success').attr('disabled', false).text('Simpan Semua');
                    }
                });
            });

        });
    </script>


@endsection
