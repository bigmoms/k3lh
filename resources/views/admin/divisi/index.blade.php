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
                    <h2>Divisi</h2>
                </div>
                <div class="col-sm-6 col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="iconly-Home icli svg-color"></i></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Divisi dan Unit Kerja</li>
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
                        <a href="{{ route ('divisi.sinkron')}}"  class="btn btn-primary btn-uppercase">Sinkronisasi</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="display">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nama Divisi</th>
                                        <th>Kode</th>
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
    {{-- @include('admin.users.create') --}}
</div>
@endsection



@section('scripts')
    <script src="{{asset('assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
    <script>
        $(function () {
            var table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('divisi.index') }}",
                columns: [
                    {data: 'id', name: 'id',orderable: true,},
                    {data: 'nama_divisi', name: 'nama_divisi'},
                    {data: 'code', name: 'email'},
                ]
            });

            //Edit User
            $('body').on('click touchstart','.edit', function(){
                let id = $(this).data("id");
                let url = window.location.href;
                //redirect to
                window.location.href = url+"/"+id+"/edit";
            })

            //Assign User Role
            $('body').on('click touchstart','.assignRole', function(){
                let id = $(this).data("id");
                let url = window.location.href;
                //redirect to
                window.location.href = url+"/"+id+"/assign-role";
            })

            // //Assign User Permission
            // $('body').on('click touchstart','.assignPermission', function(){
            //     let id = $(this).data("id");
            //     let url = window.location.href;
            //     //redirect to
            //     window.location.href = url+"/"+id+"/assign-permission";
            // })

            //Delete item
            $('body').on('click touchstart','.delete', function(){
                let id = $(this).data("id");
                Swal.fire({
                    title: 'Delete This User!',
                    text: "Are you sure you want to delete this user?",
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
    </script>

@endsection
