@extends('layouts.master')
@section('title', 'Maintenance')
@section('header', 'Maintenance')
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-sm-6 col-12">
                        <h2>Dashboard</h2>
                    </div>
                    <div class="col-sm-6 col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="iconly-Home icli svg-color"></i></a>
                            </li>
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Under Construction</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row starter-main">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header card-no-border pb-0">
                            <div class="card-body" style="place-items: center;">
                                <img src="{{ asset('maintenance.png') }}" alt="Maintenance Mode"
                                    style="max-width: 400px;">
                                <h2 class="mt-4">Sistem Sedang dalam Perawatan</h2>
                                <p class="text-muted">Kami sedang melakukan pemeliharaan sistem untuk meningkatkan layanan.
                                    Mohon
                                    maaf atas ketidaknyamanannya.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>
    </div>

@endsection
