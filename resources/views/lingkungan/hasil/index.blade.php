@extends('layouts.master')
@section('title', 'Data Hasil Pengukuran Lingkungan')
@section('header', 'Data Hasil Pengukuran Lingkungan')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-sm-6 col-12">
                        <h2>Data Hasil Pengukuran Lingkungan</h2>
                    </div>
                    <div class="col-sm-6 col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:;"><i
                                        class="iconly-Home icli svg-color"></i></a></li>
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Hasil Pengukuran Lingkungan</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                @if (!Auth::user()->lokasiLingkungan()->exists())
                                    <div class="mb-3">
                                        <a href="{{ route('lingkungan.hasil.create') }}" class="btn btn-primary">Tambah
                                            Hasil
                                            Pengukuran Lingkungan</a>
                                    </div>
                                @endif
                                <div class="table-responsive">
                                    <table id="hasilPengukuranTable" class="display">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal Pengukuran</th>
                                                <th>Divisi</th>
                                                <th>Lokasi</th>
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
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script>
        var fetchUrl = "{{ route('lingkungan.hasil.fetch') }}";
    </script>
    <script>
        $(document).ready(function() {
            $('#hasilPengukuranTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: fetchUrl,
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'divisi',
                        name: 'divisi'
                    },
                    {
                        data: 'lokasi',
                        name: 'lokasi'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],

                order: [
                    [1, 'desc']
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
        });
    </script>
@endsection
