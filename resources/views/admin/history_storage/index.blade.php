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
                        <div class="card-body">
                            <div class="table-responsive">
                                <table width="100%" id="mrx" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Nama File</th>
                                            <th>File</th>
                                            <th>Keterangan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
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
                ajax: "{{ url('admin/history_storage/json') }}",
                columns: [{
                        data: 'id',
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'nama_file'
                    },
                    {
                        data: 'path_file',
                        className: 'text-center'
                    },
                    {
                        data: 'keterangan'
                    },
                    {
                        data: 'status',
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

        function terimax(id) {
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data yang diapprove tidak dapat dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('admin/history_storage/terima') }}/" + id,
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.status) {
                                $('#mrx').DataTable().ajax.reload(null, false);
                                Toast.fire({
                                    icon: 'success',
                                    title: response.message
                                });
                            } else {
                                Toast.fire({
                                    icon: 'error',
                                    title: response.message
                                });
                            }
                        },
                        error: function(xhr) {
                            Toast.fire({
                                icon: 'error',
                                title: 'Terjadi kesalahan saat menghapus data.'
                            });
                        }
                    });
                }
            });
        }

        function tolakx(id) {
            Swal.fire({
                title: 'Tolak Kontrak',
                input: 'textarea',
                inputLabel: 'Alasan Penolakan',
                inputPlaceholder: 'Tulis alasan penolakan di sini...',
                inputAttributes: {
                    'aria-label': 'Tulis alasan penolakan di sini'
                },
                inputValidator: (value) => {
                    if (!value) {
                        return 'Alasan penolakan wajib diisi!';
                    }
                },
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Tolak',
                cancelButtonText: 'Batal',
                preConfirm: (keterangan) => {
                    return $.ajax({
                        url: "{{ url('admin/history_storage/tolak') }}/" + id,
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            keterangan: keterangan
                        }
                    }).then(response => {
                        if (!response.status) {
                            throw new Error(response.message);
                        }
                        return response;
                    }).catch(error => {
                        Swal.showValidationMessage(`Request gagal: ${error.message}`);
                    });
                }
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    $('#mrx').DataTable().ajax.reload(null, false);
                    Toast.fire({
                        icon: 'success',
                        title: result.value.message
                    });
                }
            });
        }
    </script>
@endsection
