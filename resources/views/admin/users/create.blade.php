@extends('layouts.master')
<meta name="csrf-token" content="{{ csrf_token() }}">

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
                    <h2>Tambah User</h2>
                </div>
                <div class="col-sm-6 col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="iconly-Home icli svg-color"></i></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Tambah User</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-body">
                        <form id="formTambah" action="{{ route('user.store') }}" method="POST">
                            @csrf
                            <div class="card">
                                <div class="card-body">
                                    @include('admin.users.form-control')
                                </div>
                                <div class="card-footer">
                                    <div class="col-12">
                                        <button type="button" class="btn btn-primary" onclick="kembali();">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
        function kembali(){
            window.location.href = "{{ route('user.index') }}";
        }
        $('#vendor_id').prop('disabled', true);
        $('#vdrcheck').change(function() {
            if ($(this).is(':checked')) {
                $('#vendor_id').prop('disabled', false);
            } else {
                $('#vendor_id').prop('disabled', true);
            }
        });
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

        $("#divisi_id").select2({
            placeholder: "Cari Divisi...",
            allowClear: true,
            minimumInputLength: 2,
            ajax: {
                url: "{{ route('divisi.search') }}",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.data.map(divisi => ({
                            id: divisi.id,
                            text: divisi.nama_divisi,
                        }))
                    };
                }
            },
        });

        $("#lokasi_id").select2({
            placeholder: "Cari Lokasi...",
            allowClear: true,
            minimumInputLength: 2,
            ajax: {
                url: "{{ route('lokasi.search') }}",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.data.map(lokasi => ({
                            id: lokasi.id,
                            text: lokasi.nama_lokasi,
                        }))
                    };
                }
            },
        });
    </script>
@endsection
