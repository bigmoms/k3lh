@extends('layouts.master')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('style')
    {{-- <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatables.css')}}"> --}}
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
                            <li class="breadcrumb-item active">Edit Role</li>
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
                            <form id="formTambah" action="{{ route('role.update',$role) }}" method="POST">
                                @csrf
                                @method("PUT")
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') ?? $role->name }}" autofocus>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
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
    {{-- @include('admin.roles.create') --}}
@endsection

@section('scripts')
{{-- <script src="{{asset('assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script> --}}
{{-- <script src="{{ asset('js/roles.js') }}"></script> --}}
<script>
    $(function () {

        // $('#formTambah').submit(function(e) {
        //     e.preventDefault();
        //     let formData    = $(this).serialize();
        //     var formAction  = $(this).attr("action");
        //     $.ajax({
        //         url: formAction,
        //         type: "POST",
        //         data: formData,
        //         success: function(res) {
        //             // console.log(response);
        //             if (res=='Ok'){
        //                 Swal.fire({
        //                     icon: 'success',
        //                     title: 'Berhasil!',
        //                     text: 'Data sudah disimpan!',
        //                     timer: 2000,
        //                     showConfirmButton: false
        //                 }).then(() => {
        //                     window.location.reload();
        //                 });
        //             }else{
        //                 Swal.fire({
        //                     icon: 'error',
        //                     title: 'Gagal!',
        //                     text: 'Data gagal disimpan!',
        //                     timer: 2000,
        //                     showConfirmButton: false
        //                 }).then(() => {
        //                     window.location.reload();
        //                 });
        //             }
        //         },
        //         error: function(xhr) {
        //             let errors = xhr.responseJSON.errors;
        //             $.each(errors, function(key, value) {
        //                 $('#' + key).addClass('is-invalid').next(
        //                     '.invalid-feedback').text(value[0]);
        //             });
        //         }
        //     });
        // });

    });
</script>
@endsection
