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
                    <h2>Edit Role</h2>
                </div>
                <div class="col-sm-6 col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="iconly-Home icli svg-color"></i></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Edit User</li>
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
                        <form id="formTambah" action="{{ route('user.update',$user) }}" method="POST">
                            @csrf
                            @method("PUT")
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-md-12">
                                        <label for="name">User name</label>
                                        <input id="name" type="text" class="form-control" required name="name" value="{{ old('name') ?? $user->name }}" autofocus>
                                        @error('name')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" value="{{ old('email') ?? $user->email }}" class="form-control" required name="email">
                                        @error('email')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-check-input primary" id="vdrcheck" {{ $user->is_vendor=='1' ? 'checked' : '' }} name="vdrcheck" type="checkbox" value="1">
                                        <label class="form-check-label" for="vdrcheck">Vendor</label>
                                        <select id="vendor_id" name="vendor_id" class="form-control" >
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-check-label" for="vdrcheck">Unit Kerja</label>
                                        <select id="divisi_id" name="divisi_id" class="form-control" >
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-check-label" for="vdrcheck">Tanggung Jawab Lokasi</label>
                                        <select id="lokasi_id" name="lokasi_id" class="form-control" >
                                        </select>
                                    </div>
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
    </script>
@endsection
