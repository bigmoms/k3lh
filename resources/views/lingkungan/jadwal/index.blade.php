@extends('layouts.master')
@section('title', 'Data Jadwal Pengukuran')
@section('header', 'Data Jadwal Pengukuran')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/js-datatables/style.css') }}">
    <style>
        .nav-status {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            background-color: #fff;
            padding: 10px;
            border-radius: 8px;
        }

        .nav-status .nav-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-weight: 500;
            color: #374151;
            background-color: #f3f4f6;
            border: 1px solid #e5e7eb;
            padding: 8px 14px;
            border-radius: 999px;
            font-size: 14px;
            transition: all 0.2s ease-in-out;
            text-decoration: none;
        }

        .nav-status .nav-link:hover {
            background-color: #e5e7eb;
            color: #1f2937;
        }

        .nav-status .nav-link.active {
            background-color: #3b82f6;
            color: white;
            border-color: #3b82f6;
            box-shadow: 0 2px 6px rgba(59, 130, 246, 0.3);
        }

        .nav-status .nav-link .tab-count {
            background-color: rgba(0, 0, 0, 0.05);
            padding: 2px 8px;
            font-size: 12px;
            border-radius: 999px;
            font-weight: 600;
            color: #6b7280;
        }

        .nav-status .nav-link.active .tab-count {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
        }
    </style>
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-sm-6 col-12">
                        <h2>Data Jadwal Pengukuran</h2>
                    </div>
                    <div class="col-sm-6 col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:;"><i
                                        class="iconly-Home icli svg-color"></i></a></li>
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Data Jadwal Pengukuran</li>
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

                            @if (!Auth::user()->lokasiLingkungan()->exists())
                                <div class="mb-3">
                                    <a href="{{ route('lingkungan.jadwal.create') }}" class="btn btn-primary">Tambah Jadwal
                                        Pengukuran</a>
                                </div>
                            @endif

                            <ul class="nav nav-status mb-4" id="statusTabs">
                                <li class="nav-item">
                                    <a class="nav-link active" data-status="dijadwalkan" href="#">Dijadwalkan <span
                                            class="tab-count" data-tab="dijadwalkan">0</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-status="selesai" href="#">Selesai <span class="tab-count"
                                            data-tab="selesai">0</span></a>
                                </li>
                            </ul>
                            <div class="table-responsive">
                                <table id="dataTable" class="display">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Jam</th>
                                            <th>Lokasi</th>
                                            <th>Status</th>
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
        var fetchUrl = "{{ route('lingkungan.jadwal.fetch') }}";
        var currentStatus = 'dijadwalkan';
        var countUrl = "{{ route('lingkungan.jadwal.statusCount') }}";
    </script>
    <script>
        function updateTabCounts() {
            $.get(countUrl, function(data) {
                $('[data-tab="dijadwalkan"]').text(data.dijadwalkan ?? 0);
                $('[data-tab="selesai"]').text(data.selesai ?? 0);
            }).fail(function() {
                console.error("Gagal memuat jumlah status");
            });
        }
        let dataTable = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: fetchUrl,
                type: "GET",
                data: function(d) {
                    d.status = currentStatus;
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'tanggal',
                    name: 'tanggal'
                },
                {
                    data: 'jam',
                    name: 'jam'
                },
                {
                    data: 'lokasi',
                    name: 'lokasi'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'dibuat_oleh',
                    name: 'dibuat_oleh'
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
            drawCallback: function() {
                updateTabCounts();
            },
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

        $('#statusTabs .nav-link').on('click', function(e) {
            e.preventDefault();
            $('#statusTabs .nav-link').removeClass('active');
            $(this).addClass('active');
            currentStatus = $(this).data('status');
            dataTable.ajax.reload();
        });

        $(document).ready(function() {
            updateTabCounts();
        });
    </script>
@endsection
