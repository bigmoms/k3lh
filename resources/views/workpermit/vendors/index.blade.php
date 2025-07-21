@extends('layouts.master')
@section('title', 'Data Vendor')
@section('header', 'Data Vendor')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatables.css')}}">
@endsection
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-sm-6 col-12">
                        <h2>Data Vendor</h2>
                    </div>
                    <div class="col-sm-6 col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="iconly-Home icli svg-color"></i></a>
                            </li>
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Data Vendor</li>
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
                            <a href="{{ route ('admin.vendors.sinkron')}}"  class="btn btn-primary btn-uppercase">Sinkronisasi</a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dataTable" class="display">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Vendor</th>
                                            <th>Nama Vendor</th>
                                            <th>Alamat</th>
                                            <th>Telepon</th>
                                            <th>Email</th>
                                            <th>Direksi</th>
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
<script src="{{asset('assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('js/vendor.js') }}"></script>
    <script>
        var FetchUrl = "{{ route('admin.vendors.index') }}";
    </script>
@endsection
