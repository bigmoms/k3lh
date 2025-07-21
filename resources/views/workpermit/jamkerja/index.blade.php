@extends('layouts.master')
@section('title', 'Data Jam Kerja Aman')
@section('header', 'Data Jam Kerja Aman')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/js-datatables/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select2.css') }}">
    <style>
        .card {
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
            background-color: #fff;
        }

        .table th,
        .table td {
            padding: 15px;
            vertical-align: middle;
        }

        .table thead {
            background-color: #f8f9fa;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        .alert-info {
            background-color: #e9f7fe;
            border-color: #b6e3f3;
            color: #31708f;
        }

        .select2-container .select2-selection--single {
            height: 40px;
            border-radius: 5px;
            border: 1px solid #ced4da;
        }

        .select2-selection__rendered {
            font-size: 16px;
        }

        .breadcrumb {
            background-color: transparent;
            padding: 0;
        }

        .breadcrumb-item a {
            color: #007bff;
        }

        .breadcrumb-item.active {
            color: #6c757d;
        }

        .spinner {
            display: none;
        }

        .table-container {
            position: relative;
        }

        .table-container .spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }
    </style>
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-sm-6 col-12">
                        <h2>Data Jam Kerja Aman Tersedia</h2>
                    </div>
                    <div class="col-sm-6 col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="iconly-Home icli svg-color"></i></a>
                            </li>
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Data Jam Kerja Aman</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">

            <!-- Table -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header px-4">
                            <div class="row align-items-end">
                                <div class="col-md-6 col-lg-5">
                                    <label for="no_po" class="form-label fw-semibold mb-2">Filter Berdasarkan Nomor PO</label>
                                    <select id="no_po" class="form-control select2" style="height: 44px;">
                                        <option value="">-- Pilih Nomor PO --</option>
                                        @foreach ($listPo as $po)
                                            <option value="{{ $po->no_po }}">
                                                {{ $po->no_po }} ({{ \Carbon\Carbon::parse($po->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($po->tanggal_akhir)->format('d M Y') }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="alert alert-info" id="info-msg" style="display:none;">
                                        Data akan muncul setelah memilih nomor PO dari filter di bawah.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-container">
                                <div class="spinner">
                                    <div class="spinner-border text-primary"></div>
                                </div>
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Vendor</th>
                                                <th>No PO</th>
                                                <th>Nama Pekerjaan</th>
                                                <th>Lokasi Pekerjaan</th>
                                                <th style="min-width: 170px;">Periode</th>
                                                <th>Status</th>
                                                <th>Approve SHE</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
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
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            let fetchUrl = "{{ route('permit.jamkerja.fetch') }}";
            $("#no_po").select2({
                placeholder: "Cari PO...",
                minimumInputLength: 2,
            });

            const table = $('#dataTable').DataTable({
                processing: false,
                serverSide: true,
                bDestroy: true,
                ajax: {
                    url: fetchUrl,
                    data: function(d) {
                        d.no_po = $('#no_po').val();
                    },
                    beforeSend: function() {
                        if ($('#no_po').val()) {
                            $('.spinner').show();
                            $('#info-msg').hide();
                        }
                    },
                    complete: function() {
                        $('.spinner').hide();
                    },
                    dataSrc: function(json) {
                        if (!$('#no_po').val()) {
                            $('#dataTable').find('tbody').html(
                                '<tr><td colspan="9" class="text-center">Tunggu sampai memilih PO untuk melihat data</td></tr>'
                            );
                            return [];
                        }
                        return json.data;
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'vendor_name',
                        name: 'vendor_name'
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
                        data: 'lokasi_pekerjaan',
                        name: 'lokasi_pekerjaan'
                    },
                    {
                        data: 'periode',
                        name: 'periode'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center'
                    },
                    {
                        data: 'approval_status',
                        name: 'approval_status',
                        className: 'text-center'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                ],
                order: [
                    [0, 'asc']
                ],
                language: {
                    emptyTable: "Tidak ada data yang tersedia",
                    zeroRecords: "filter po terlebih dahulu",
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
                },
                initComplete: function(settings, json) {
                    if (!$('#no_po').val()) {
                        $('#info-msg').show();
                        $('#table-card').hide();
                    }
                }
            });

            const refreshTable = () => {
                if ($('#no_po').val() !== '') {
                    $('.spinner').show();
                    $('#table-card').show();
                    $('#info-msg').hide();
                    table.ajax.reload();
                } else {
                    table.clear().draw();
                    $('#table-card').hide();
                    $('#info-msg').show();
                }
            };
            $('#no_po').on('change', function() {
                refreshTable();
            });
            if ($('#no_po').val() === '') {
                $('#table-card').hide();
                $('#info-msg').show();
            }
        });
    </script>
@endsection
