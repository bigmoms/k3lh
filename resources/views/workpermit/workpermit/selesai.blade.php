@extends('layouts.master')
@section('title', 'Data Pekerjaan Selesai')
@section('header', 'Data Pekerjaan Selesai')
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
                        <h2>Data Pekerjaan Selesai</h2>
                    </div>
                    <div class="col-sm-6 col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:;"><i
                                        class="iconly-Home icli svg-color"></i></a></li>
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Data Pekerjaan Selesai</li>
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
                                <table id="dataTable" class="display">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Vendor</th>
                                            <th>No PO</th>
                                            <th>Nama Pekerjaan</th>
                                            <th>Jenis</th>
                                            <th>Area</th>
                                            <th>Lokasi</th>
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Akhir</th>
                                            <th>Status</th>
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
        var fetchUrl = "{{ route('permit.po.fetchselesai') }}";
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
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'vendor',
                    name: 'vendor'
                },
                {
                    data: 'no_po',
                    name: 'no_po'
                },
                {
                    data: 'nama_pekerjaan',
                    name: 'nama_pekerjaan'
                },
                {
                    data: 'jenis_pekerjaan',
                    name: 'jenis_pekerjaan'
                },
                {
                    data: 'area_pekerjaan',
                    name: 'area_pekerjaan'
                },
                {
                    data: 'lokasi_pekerjaan',
                    name: 'lokasi_pekerjaan'
                },
                {
                    data: 'tanggal_mulai',
                    name: 'tanggal_mulai'
                },
                {
                    data: 'tanggal_akhir',
                    name: 'tanggal_akhir'
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
                },
            ],
            order: [
                [0, 'asc']
            ],
            language: {
                processing: `<div class="spinner-border text-primary"></div>`,
                emptyTable: "Tidak ada data yang tersedia",
                zeroRecords: "Data tidak ditemukan",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoFiltered: "(disaring dari _MAX_ total data)",
                search: "Cari:",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "»",
                    previous: "«"
                }
            }
        });
    </script>
@endsection
