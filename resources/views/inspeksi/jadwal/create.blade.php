@extends('layouts.master')
@section('title', 'Tambah Jadwal Inspeksi')
@section('header', 'Tambah Jadwal Inspeksi')

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/flatpickr/flatpickr.min.css') }}">
@endsection

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h3 class="fw-bold">Tambah Jadwal Inspeksi K3LH</h3>
                </div>
                <div class="col-md-6 text-md-end">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#"><i class="iconly-Home icli svg-color"></i></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Tambah Jadwal</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0 fw-semibold">Form Jadwal Inspeksi</h5>
            </div>
            <div class="card-body">
                <form id="jadwalInspeksiForm" method="POST" action="{{ route('inspeksi.jadwal.store') }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Pilih Divisi <span class="text-danger">*</span></label>
                            <select id="divisi_inspeksi_id" name="divisi_inspeksi_id" class="form-select select2">
                                <option value="" disabled selected>Pilih Divisi</option>
                                @foreach ($divisiInspeksi as $divisi)
                                    <option value="{{ $divisi->id }}">{{ $divisi->nama_divisi }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tanggal Inspeksi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control datepicker" id="tanggal_inspeksi" name="tanggal_inspeksi">
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
                            <textarea class="form-control" id="catatan" name="catatan" rows="3" placeholder="Tuliskan catatan tambahan jika diperlukan..."></textarea>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <a href="{{ route('inspeksi.jadwal.index') }}" class="btn btn-secondary border">Batal</a>
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
    $(function () {
        $('#divisi_inspeksi_id').select2({
            placeholder: "Pilih Divisi",
            allowClear: true,
            width: '100%'
        });

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

        $('#jadwalInspeksiForm').on('submit', function (e) {
            e.preventDefault();

            const form = $(this);
            const btnSubmit = form.find('button[type=submit]');

            const divisi = $('#divisi_inspeksi_id').val();
            const tanggal = $('#tanggal_inspeksi').val();
            const jamMulai = $('#jam_mulai').val();
            const jamSelesai = $('#jam_selesai').val();

            if (!divisi || !tanggal || !jamMulai || !jamSelesai) {
                Swal.fire('Gagal', 'Harap lengkapi semua data yang wajib diisi.', 'error');
                return;
            }

            const formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    btnSubmit.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
                },
                success: function () {
                    Swal.fire('Berhasil', 'Data berhasil disimpan.', 'success').then(() => {
                        window.location.href = "{{ route('inspeksi.jadwal.index') }}";
                    });
                },
                error: function (xhr) {
                    btnSubmit.prop('disabled', false).text('Simpan');
                    let message = 'Terjadi kesalahan saat menyimpan data.';
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        message = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                    }
                    Swal.fire('Gagal', message, 'error');
                }
            });
        });
    });
</script>
@endsection
