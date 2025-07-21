@extends('layouts.master')
@section('title', 'Edit Data Pekerjaan')
@section('header', 'Edit Data Pekerjaan')

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
                        <h2>Edit Data Pekerjaan</h2>
                    </div>
                    <div class="col-sm-6 col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:;"><i
                                        class="iconly-Home icli svg-color"></i></a></li>
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Edit Data Pekerjaan</li>
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
                                        <label for="no_po" class="form-label">Nomor PO</label>
                                        <input type="text" class="form-control" id="no_po" name="no_po"
                                            value="{{ old('no_po', $purchaseOrder->no_po) }}" readonly>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="nama_pekerjaan" class="form-label">Nama Pekerjaan</label>
                                        <input type="text" class="form-control" id="nama_pekerjaan" name="nama_pekerjaan"
                                            value="{{ old('nama_pekerjaan', $purchaseOrder->nama_pekerjaan) }}" required>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label>Vendor</label>
                                        <select id="vendor_id" class="form-control select2" name="vendor_id" required>
                                            @foreach ($vendors as $vendor)
                                                <option value="{{ $vendor->id }}">{{ $vendor->vendor_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="jenis_pekerjaan" class="form-label">Jenis Pekerjaan Vendor</label>
                                        <select class="form-control" id="jenis_pekerjaan" name="jenis_pekerjaan" required>
                                            <option value="jasa_perorangan"
                                                {{ $purchaseOrder->jenis_pekerjaan == 'jasa_perorangan' ? 'selected' : '' }}>
                                                Jasa Perorangan</option>
                                            <option value="jasa_non_perorangan"
                                                {{ $purchaseOrder->jenis_pekerjaan == 'jasa_non_perorangan' ? 'selected' : '' }}>
                                                Jasa Non Perorangan</option>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Klasifikasi Pekerjaan</label>
                                        <div>
                                            @foreach ($jobClassifications as $classification)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="job_classifications[]" value="{{ $classification->id }}"
                                                        id="classification_{{ $classification->id }}"
                                                        {{ in_array($classification->id, $selectedClassifications) ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="classification_{{ $classification->id }}">
                                                        {{ $classification->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="area_pekerjaan" class="form-label">Area Pekerjaan</label>
                                        <input type="text" class="form-control" id="area_pekerjaan" name="area_pekerjaan"
                                            value="{{ old('area_pekerjaan', $purchaseOrder->area_pekerjaan) }}" required>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="lokasi_pekerjaan" class="form-label">Lokasi Pekerjaan</label>
                                        <input type="text" class="form-control" id="lokasi_pekerjaan"
                                            name="lokasi_pekerjaan"
                                            value="{{ old('lokasi_pekerjaan', $purchaseOrder->lokasi_pekerjaan) }}"
                                            required>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="detail_pekerjaan" class="form-label">Detail Pekerjaan</label>
                                        <textarea class="form-control" id="detail_pekerjaan" name="detail_pekerjaan" rows="3" required>{{ old('detail_pekerjaan', $purchaseOrder->detail_pekerjaan) }}</textarea>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                        <input type="text" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                                            value="{{ old('tanggal_mulai', $purchaseOrder->tanggal_mulai) }}" required>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                                        <input type="text" class="form-control" id="tanggal_akhir" name="tanggal_akhir"
                                            value="{{ old('tanggal_akhir', $purchaseOrder->tanggal_akhir) }}" required>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="mt-5">
                                        <a href="{{ route('purchasing.po.index') }}" class="btn btn-secondary">Batal</a>
                                        <button type="submit" class="btn btn-primary">Update</button>
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
                }
            });

            flatpickr("#tanggal_mulai", {
                dateFormat: "d-m-Y",
                defaultDate: new Date(),
                onClose: function(selectedDates, dateStr, instance) {
                    tanggalAkhir.set("minDate", dateStr);
                }
            });
            var tanggalAkhir = flatpickr("#tanggal_akhir", {
                dateFormat: "d-m-Y"
            });

            let po = @json($purchaseOrder);
            $('#no_po').val(po.no_po);
            $('#nama_pekerjaan').val(po.nama_pekerjaan);
            $('#jenis_pekerjaan').val(po.jenis_pekerjaan);
            $('#area_pekerjaan').val(po.area_pekerjaan);
            $('#lokasi_pekerjaan').val(po.lokasi_pekerjaan);
            $('#detail_pekerjaan').val(po.detail_pekerjaan);
            $('#tanggal_mulai').val(po.tanggal_mulai.split('T')[0]);
            $('#tanggal_akhir').val(po.tanggal_akhir.split('T')[0]);

            if (po.vendor_id) {
                let vendorText =
                "{{ $purchaseOrder->vendor->vendor_name ?? '' }}";
                let vendorOption = new Option(vendorText, po.vendor_id, true, true);
                $("#vendor_id").append(vendorOption).trigger('change');
            }

            $('#purchaseOrderForm').submit(function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('purchasing.po.update', encodeId($purchaseOrder->id)) }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href =
                            "{{ route('purchasing.po.index') }}";
                        });
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $('#' + key).addClass('is-invalid').next(
                                '.invalid-feedback').text(value[0]);
                        });
                    }
                });
            });
        });
    </script>
@endsection
