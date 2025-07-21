@extends('layouts.master')
@section('title', $title ?? '')
@section('header', $title ?? '')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-sm-6 col-12">
                        <h2>{{ $title ?? '' }}</h2>
                    </div>
                    <div class="col-sm-6 col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:;"><i
                                        class="iconly-Home icli svg-color"></i></a></li>
                            <li class="breadcrumb-item active">{{ $title ?? '' }}</li>
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
                            <button onclick="modal(0)" class="btn btn-sm btn-primary">Tambah Data</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table width="100%" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="3" class="text-center">Kesimpulan</th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th>2025</th>
                                            <th>P</th>
                                        </tr>
                                        <tr>
                                            <th>FIT</th>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <th>FIT CATATAN</th>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <th>FIT RESTRIKSI</th>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <th>SEMENTARA TIDAK FIT</th>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal-x" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content  modal-md">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-data" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div id="view-modal"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button id="btn-submit" type="button" class="btn btn-sm btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            getJson();
        });


        function getJson() {
            $('#mrx').DataTable({
                responsive: true,
                ajax: "{{ url('admin/mcu/json') }}",
                columns: [{
                        data: 'id',
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'nik'
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'keterangan'
                    },
                    {
                        data: 'tanggal'
                    },
                    {
                        data: 'file_mcu',
                        className: 'text-center'
                    },
                    {
                        data: 'action',
                        className: 'text-center'
                    },
                ],
                language: {
                    paginate: {
                        previous: '<<',
                        next: '>>'
                    }
                }
            });
        }

        function modal(id) {
            $("#modal-x").modal('show');
            $("#view-modal").load("{{ url('admin/mcu/modal') }}?id=" + id);
        }

        $('#btn-submit').on('click', () => {
            var form = document.getElementById('form-data');
            $.ajax({
                type: 'POST',
                url: "{{ url('admin/mcu/import') }}",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                beforeSend: function() {
                    $('#btn-submit').hide();
                },
                error: function(msg) {
                    $('#btn-submit').show();
                    var data = msg.responseJSON;
                    $.each(data.errors, function(key, value) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Berhasil!',
                            text: value[0],
                        });
                    });
                },
                success: function(res) {
                    if (res.status == true) {
                        $("#modal-x").modal('hide');
                        $('#mrx').DataTable().ajax.reload(null, false);
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.message,
                        });
                    }
                }
            });
        });

        function hapus(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda tidak bisa mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'GET',
                        url: "{{ url('admin/mcu/hapus') }}",
                        data: {
                            id: id
                        },
                        success: function(res) {
                            if (res.status == true) {
                                $('#mrx').DataTable().ajax.reload(null, false);
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: res.message,
                                });
                            }
                        },
                    });
                }
            });
        }
    </script>
@endsection
