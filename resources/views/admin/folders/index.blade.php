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
                            @if (isRoles() == 1)
                                <button onclick="modal()" class="btn btn-sm btn-primary">Tambah Folder</button>
                            @endif
                        </div>
                        <div class="card-body">
                            @include('admin.folders.tree', ['folders' => $folders])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="modal-x" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog  modal-md">
            <div class="modal-content">
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

    <!-- Modal -->
    <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="height: 90vh;"> {{-- Tinggi total modal --}}
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Preview PDF</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 d-flex" style="flex: 1 1 auto; overflow: hidden;">
                    <iframe id="pdfFrame" src="" class="w-100 h-100 border-0"></iframe>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        function showPdf(fileUrl) {
            const modal = new bootstrap.Modal(document.getElementById('pdfModal'));
            document.getElementById('pdfFrame').src = fileUrl;
            modal.show();
        }

        function modal(id) {
            $("#modal-x").modal('show');
            $("#view-modal").load("{{ url('admin/folders/modal') }}?id=" + id);
        }

        $('#btn-submit').on('click', () => {
            var form = document.getElementById('form-data');
            $.ajax({
                type: 'POST',
                url: "{{ url('admin/folders/store') }}",
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
                        location.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.message,
                        });
                    }
                }
            });
        });

        function pengajuan(id) {
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
                        url: "{{ url('admin/folders/pengajuan') }}",
                        data: {
                            id: id
                        },
                        success: function(res) {
                            if (res.status == true) {
                                // location.assign("{{ url('admin/history_storage') }}")
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
