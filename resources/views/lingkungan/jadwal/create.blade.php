@extends('layouts.master')
@section('title', 'Tambah Jadwal Pengukuran')
@section('header', 'Tambah Jadwal Pengukuran')
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
                        <h3 class="fw-bold">Tambah Jadwal Pengukuran Lingkungan</h3>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#"><i class="iconly-Home icli svg-color"></i></a>
                            </li>
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Tambah Jadwal</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 fw-semibold">Form Jadwal Pengukuran Lingkungan</h5>
                </div>

                <div class="card-body">
                    <form id="jadwalPengukuranForm" method="POST" action="{{ route('lingkungan.jadwal.store') }}">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Pilih Lokasi
                                    Pengukuran <span class="text-danger">*</span></label>
                                <select id="lokasi_ids" name="lokasi_ids[]" class="form-control select2" multiple>
                                    @foreach ($lokasiPengukuran as $lokasi)
                                        <option value="{{ $lokasi->id }}">{{ $lokasi->nama_lokasi }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="tanggal_pengukuran" class="form-label fw-bold">Tanggal Pengukuran <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control datepicker" id="tanggal_pengukuran"
                                    name="tanggal_pengukuran" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Jam Mulai <span class="text-danger">*</span></label>
                                <input type="text" class="form-control timepicker" id="jam_mulai" name="jam_mulai">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Jam Selesai <span class="text-danger">*</span></label>
                                <input type="text" class="form-control timepicker" id="jam_selesai" name="jam_selesai">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">Catatan (Optional)</label>
                                <textarea class="form-control" id="catatan" name="catatan" rows="3"
                                    placeholder="Tuliskan catatan tambahan jika diperlukan..."></textarea>
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <a href="{{ route('lingkungan.jadwal.index') }}" class="btn btn-secondary border">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/flat-pickr/flatpickr.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
            $('.datepicker').flatpickr({
                dateFormat: "Y-m-d",
                minDate: "today"
            });
            $('.timepicker').flatpickr({
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true
            });

            $('#jadwalPengukuranForm').submit(function(e) {
                e.preventDefault();

                if ($('#lokasi_ids').val() == null || $('#lokasi_ids').val().length === 0) {
                    Swal.fire('Gagal', 'Minimal pilih satu lokasi pengukuran', 'error');
                    return;
                }

                if ($('#tanggal_pengukuran').val() == '') {
                    Swal.fire('Gagal', 'Tanggal pengukuran harus diisi', 'error');
                    return;
                }

                if ($('#jam_mulai').val() == '' || $('#jam_selesai').val() == '') {
                    Swal.fire('Gagal', 'Jam mulai dan selesai harus diisi', 'error');
                    return;
                }

                let formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    url: $(this).attr('action'),
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.btn-primary').attr('disabled', true).text('Menyimpan...');
                    },
                    success: function(response) {
                        Swal.fire('Berhasil', 'Data berhasil disimpan', 'success')
                            .then(() => {
                                window.location.href =
                                    "{{ route('lingkungan.jadwal.index') }}";
                            });
                    },
                    error: function(xhr) {
                        $('.btn-primary').attr('disabled', false).text('Simpan');

                        if (xhr.status === 422) {
                            let res = xhr.responseJSON;

                            if (res.custom_error && res.lokasi_bentrok) {
                                Swal.fire({
                                    title: 'Gagal',
                                    html: 'Lokasi berikut sudah dijadwalkan pada tanggal tersebut:<br><ul>' +
                                        res.lokasi_bentrok.map(nama =>
                                            `<li>${nama}</li>`).join('') +
                                        '</ul>',
                                    icon: 'error'
                                });
                            } else if (res.errors) {
                                let pesan = Object.values(res.errors).flat().join('<br>');
                                Swal.fire('Gagal', pesan, 'error');
                            } else {
                                Swal.fire('Gagal', 'Validasi gagal. Silakan periksa inputan.',
                                    'error');
                            }
                        } else {
                            Swal.fire('Gagal', 'Terjadi kesalahan saat menyimpan', 'error');
                        }
                    }

                });
            });
        });
    </script>
@endsection
