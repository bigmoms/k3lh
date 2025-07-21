@extends('layouts.master')
@section('title', 'Tambah Data Pekerjaan')
@section('header', 'Tambah Data Pekerjaan')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flatpickr/flatpickr.min.css') }}">
@endsection
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-sm-6 col-12">
                        <h2>Tambah Data Pekerjaan</h2>
                    </div>
                    <div class="col-sm-6 col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:;"><i
                                        class="iconly-Home icli svg-color"></i></a>
                            </li>
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Data Pekerjaan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-body">
                                <form id="purchaseOrderForm">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label for="no_po" class="form-label">No PO<small><span style="color: red">*</span></small></label>
                                        <input type="text" class="form-control" id="no_po" name="no_po"
                                            value="{{ $no_po ?? '' }}" readonly>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="nama_pekerjaan" class="form-label">Nama Pekerjaan<small><span style="color: red">*</span></small></label>
                                        <input type="text" class="form-control" id="nama_pekerjaan" name="nama_pekerjaan"
                                            required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="vendor_id">Vendor<small><span style="color: red">*</span></small></label>
                                        <select id="vendor_id" class="form-control" required>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="jenis_pekerjaan" class="form-label">Jenis Pekerjaan Vendor<small><span style="color: red">*</span></small></label>
                                        <select class="form-control" id="jenis_pekerjaan" name="jenis_pekerjaan" required>
                                            <option value="" disabled selected>Pilih Jenis Pekerjaan</option>
                                            <option value="jasa_perorangan">Jasa Perorangan</option>
                                            <option value="jasa_non_perorangan">Jasa Non Perorangan</option>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Klasifikasi Pekerjaan<small><span style="color: red">*</span></small></label>
                                        <div>
                                            @foreach ($jobClassifications as $classification)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="job_classifications[]" value="{{ $classification->id }}"
                                                        id="classification_{{ $classification->id }}">
                                                    <label class="form-check-label"
                                                        for="classification_{{ $classification->id }}">
                                                        {{ $classification->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="area_pekerjaan" class="form-label">Area Pekerjaan<small><span style="color: red">*</span></small></label>
                                        <input type="text" class="form-control" id="area_pekerjaan" name="area_pekerjaan"
                                            required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="lokasi_pekerjaan" class="form-label">Lokasi Pekerjaan<small><span style="color: red">*</span></small></label>
                                        <input type="text" class="form-control" id="lokasi_pekerjaan"
                                            name="lokasi_pekerjaan" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="detail_pekerjaan" class="form-label">Detail Pekerjaan<small><span style="color: red">*</span></small></label>
                                        <textarea class="form-control" id="detail_pekerjaan" name="detail_pekerjaan" rows="3" required></textarea>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai<small><span style="color: red">*</span></small></label>
                                        <input type="text" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                                            required>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="tanggal_akhir" class="form-label">Tanggal Akhir<small><span style="color: red">*</span></small></label>
                                        <input type="text" class="form-control" id="tanggal_akhir"
                                            name="tanggal_akhir" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mt-5">
                                        <a href="{{ route('purchasing.po.index') }}" class="btn btn-secondary">Batal</a>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
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
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var tanggalAkhir = flatpickr("#tanggal_akhir", {
                dateFormat: "d-m-Y",
                clickOpens: false,
                disable: [() => true]
            });

            var tanggalMulai = flatpickr("#tanggal_mulai", {
                dateFormat: "d-m-Y",
                defaultDate: new Date(),
                onClose: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length > 0) {
                        let selected = selectedDates[0];

                        let minEndDate = new Date(selected);
                        minEndDate.setDate(minEndDate.getDate() + 1);

                        tanggalAkhir.set("minDate", minEndDate);
                        tanggalAkhir.set("disable", []);
                        tanggalAkhir.set("clickOpens", true);

                        document.getElementById("tanggal_akhir").value = "";
                        document.getElementById("tanggal_akhir").disabled = false;
                    }
                }
            });

            // $("#vendor_id").select2({
            //     placeholder: "Cari Vendor...",
            //     allowClear: true,
            //     minimumInputLength: 2,
            //     ajax: {
            //         url: "{{ route('admin.vendors.search') }}",
            //         dataType: "json",
            //         delay: 250,
            //         data: function(params) {
            //             return {
            //                 q: params.term
            //             };
            //         },
            //         processResults: function(data) {
            //             return {
            //                 results: data.data.map(vendor => ({
            //                     id: vendor.kd_vendor,
            //                     text: vendor.vendor_name,
            //                 }))
            //             };
            //         }
            //     },
            //     templateResult: function(item) {
            //         if (!item.id) {
            //             return item.text;
            //         }
            //         return $(
            //             `<div style="display: flex; align-items: center;">
        //     <div>
        //         <strong>${item.text}</strong><br>
        //         <small class="text-muted">Kode: ${item.id}</small>
        //     </div>
        // </div>`
            //         );
            //     },
            //     templateSelection: function(item) {
            //         return item.text || "Pilih Vendor";
            //     }
            // });

            $("#vendor_id").select2({
                placeholder: "Cari Vendor...",
                allowClear: true,
                minimumInputLength: 2,
                ajax: {
                    url: "{{ route('admin.vendors.search') }}",
                    dataType: "json",
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.data.map(vendor => ({
                                id: vendor.id,
                                text: vendor.vendor_name,
                            }))
                        };
                    }
                },
            });

            $("#purchaseOrderForm").submit(function(e) {
                e.preventDefault();
                let formData = $("#purchaseOrderForm").serializeArray();
                formData.push({
                    name: "vendor_id",
                    value: $("#vendor_id").val()
                });
                let submitButton = $("button[type=submit]");
                submitButton.prop("disabled", true).text("Menyimpan...");
                $.ajax({
                    url: "{{ route('purchasing.po.store') }}",
                    type: "POST",
                    data: formData,
                    beforeSend: function() {
                        $("button[type=submit]").prop("disabled", true).text("Menyimpan...");
                    },
                    success: function(response) {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Purchase Order berhasil ditambah!",
                            icon: "success",
                            confirmButtonText: "OK"
                        }).then(() => {
                            window.location.href =
                                "{{ route('purchasing.po.index') }}";
                        });
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = "";
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            let inputField = $('#' + key);
                            inputField.addClass('is-invalid');
                            if (!inputField.next('.invalid-feedback').length) {
                                inputField.after('<div class="invalid-feedback">' +
                                    value[0] + '</div>');
                            } else {
                                inputField.next('.invalid-feedback').text(value[0]);
                            }
                        });

                        Swal.fire({
                            title: "Gagal!",
                            html: errorMessage,
                            icon: "error",
                            confirmButtonText: "Coba Lagi"
                        });
                    },
                    complete: function() {
                        $("button[type=submit]").prop("disabled", false).text("Simpan");
                    }
                });
            });
        });
    </script>
@endsection
