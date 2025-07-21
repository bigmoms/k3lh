@extends('layouts.master')
<meta name="csrf-token" content="{{ csrf_token() }}">


@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatables.css')}}">
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-sm-6 col-12">
                        <h2>Data Role</h2>
                    </div>
                    <div class="col-sm-6 col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="iconly-Home icli svg-color"></i></a></li>
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Data Role</li>
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
                            <a href="#modalTambah" data-bs-toggle="modal" class="btn btn-primary btn-uppercase">Tambah Role</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dataTable" class="display">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Menus</th>
                                            <th>Permission</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.roles.create')
@endsection

@section('scripts')
<script src="{{asset('assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
{{-- <script src="{{ asset('js/roles.js') }}"></script> --}}
<script>
    $(function () {

        $('#formTambah').submit(function(e) {
            e.preventDefault();
            let formData    = $(this).serialize();
            var formAction  = $(this).attr("action");
            $.ajax({
                url: formAction,
                type: "POST",
                data: formData,
                success: function(res) {
                    // console.log(response);
                    if (res=='Ok'){
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data sudah disimpan!',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.reload();
                        });
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Data gagal disimpan!',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.reload();
                        });
                    }
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

            var table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('role.index') }}",
                columns: [
                    {data: 'id', name: 'id',orderable: true,},
                    {data: 'name', name: 'name'},
                    {data: 'menus', name: 'menus'},
                    {data: 'permission', name: 'permission'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                drawCallback: function () {
                    console.log('Callback');
                    $('body').tooltip({ selector: '[data-bs-toggle="tooltip"]' });
                },
            });

            // toolinit();

            //Edit User
            $('body').on('click touchstart','.edit', function(){
                let id = $(this).data("id");
                let url = window.location.href;
                //redirect to
                window.location.href = url+"/"+id+"/edit";
            })

            //Assign Permission item
            $('body').on('click touchstart','.assign', function(){
                let id = $(this).data("id");
                let url = window.location.href;
                //redirect to
                window.location.href = url+"/"+id+"/assign-permission";
            })

            //Delete item
            $('body').on('click touchstart','.delete', function(){
                let id = $(this).data("id");
                Swal.fire({
                    title: 'Delete This Role!',
                    text: "Are you sure you want to delete this role?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "DELETE",
                            url: window.location.href+'/'+id,
                            success: function (data) {
                                table.draw();
                                Swal.fire({
                                    icon: data.icon,
                                    title: data.title,
                                    text: data.message,
                                })
                            },
                            error: function (data) {
                                Swal.fire({
                                    icon: data.responseJSON.icon,
                                    title: data.responseJSON.title,
                                    text: data.responseJSON.message,
                                })
                            }
                        });
                    }
                })
            });
    });

    function toolinit(){
        const tooltipTriggerList = document.querySelectorAll(
            '[data-bs-toggle="tooltip"]'
        );
        const tooltipList = [...tooltipTriggerList].map(
            (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
        );
    }
</script>
{{-- <script src="{{asset('assets/js/tooltip.js') }}"></script> --}}
@endsection
