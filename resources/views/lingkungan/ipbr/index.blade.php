@extends('layouts.master')
@section('title', 'Data IPBR')
@section('header', 'Data IPBR')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/js-datatables/style.css') }}">
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-sm-6 col-12">
                        <h2>Data Identifikasi Bahaya dan Penilaian Resiko</h2>
                    </div>
                    <div class="col-sm-6 col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="iconly-Home icli svg-color"></i></a>
                            </li>
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Data IPBR</li>
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
                            @if (Auth::user()->lokasiLingkungan()->exists())
                                <div class="mb-3">
                                    <a href="{{ route('lingkungan.ipbr.create') }}" class="btn btn-primary">Tambah Data
                                        IPBR</a>
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table id="dataTable" class="display">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Lokasi</th>
                                            <th>Tahun</th>
                                            <th>Dibuat Oleh</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div><!-- row -->
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script>
        var fetchUrl = "{{ route('lingkungan.ipbr.fetch') }}";
    </script>
    <script>
        let dataTable = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: fetchUrl,
                type: "GET",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'lokasi',
                    name: 'lokasi'
                },
                {
                    data: 'tahun',
                    name: 'tahun'
                },
                {
                    data: 'dibuat_oleh',
                    name: 'dibuat_oleh'
                },
                {
                    data: 'action',
                    name: 'action',

                },
            ],
            order: [
                [2, 'desc']
            ],
            language: {
                processing: `<div class="spinner-border text-primary"></div>`,
                emptyTable: "Tidak ada data tersedia",
                zeroRecords: "Data tidak ditemukan",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                infoFiltered: "(disaring dari _MAX_ total)",
                search: "Cari:",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "»",
                    previous: "«"
                }
            }
        });
    </script>
@endsection
