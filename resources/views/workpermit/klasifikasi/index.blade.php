@extends('layouts.master')
@section('title', 'Data Klasifikasi Pekerjaan')
@section('header', 'Data Klasifikasi Pekerjaan')
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
                        <h2>Data Klasifikasi Pekerjaan</h2>
                    </div>
                    <div class="col-sm-6 col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:;"><i
                                        class="iconly-Home icli svg-color"></i></a>
                            </li>
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Data Klasifikasi Pekerjaan</li>
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
                            <a href="{{ route('admin.klasifikasi.create') }}" class="btn btn-primary btn-uppercase">Tambah
                                Data</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dataTable" class="display">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Klasifikasi</th>
                                            <th>APD yang Diperlukan</th>
                                            <th>Perlengkapan Darurat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
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
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/klasifikasi.js') }}"></script>
    <script>
        var FetchUrl = "{{ route('admin.klasifikasi.fetch') }}";
    </script>
@endsection
