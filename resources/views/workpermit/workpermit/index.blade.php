@extends('layouts.master')
@section('title', 'Data Pekerjaan')
@section('header', 'Data Pekerjaan')
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
                        <h2>Data Pekerjaan Tersedia</h2>
                    </div>
                    <div class="col-sm-6 col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:;"><i
                                        class="iconly-Home icli svg-color"></i></a></li>
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Data Pekerjaan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="card-body">
                            <ul class="nav nav-status mb-4" id="statusTabs">
                                <li class="nav-item">
                                    <a class="nav-link active" data-status="draft" href="#">Draft <span
                                            class="tab-count" data-tab="draft">0</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-status="submitted" href="#">Diajukan <span
                                            class="tab-count" data-tab="submitted">0</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-status="approved" href="#">Disetujui / Aktif <span
                                            class="tab-count" data-tab="approved">0</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-status="rejected" href="#">Ditolak <span
                                            class="tab-count" data-tab="rejected">0</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-status="cancelled" href="#">Dibatalkan <span
                                            class="tab-count" data-tab="cancelled">0</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-status="completed" href="#">Selesai <span
                                            class="tab-count" data-tab="completed">0</span></a>
                                </li>
                            </ul>
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

    <!-- Modal Pembatalan -->
    <div class="modal fade" id="modalPembatalan" tabindex="-1" aria-labelledby="modalPembatalanLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form id="formPembatalan" method="POST" action="">
                @csrf
                <input type="hidden" name="purchase_order_id" id="pembatalanPoId">
                <div class="modal-content shadow rounded-3 border-0">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="modalPembatalanLabel"><i class="fas fa-times-circle me-2"></i>Ajukan
                            Pembatalan</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <h6 class="mb-3 fw-semibold text-secondary">Informasi Pekerjaan</h6>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="border p-2 rounded">
                                        <small class="text-muted">No PO</small>
                                        <div class="fw-bold" id="modalNoPO">-</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border p-2 rounded">
                                        <small class="text-muted">Nama Pekerjaan</small>
                                        <div class="fw-bold" id="modalNamaPekerjaan">-</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border p-2 rounded">
                                        <small class="text-muted">Vendor</small>
                                        <div class="fw-bold" id="modalVendor">-</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border p-2 rounded">
                                        <small class="text-muted">Tanggal</small>
                                        <div class="fw-bold" id="modalTanggal">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="alasanPembatalan" class="form-label fw-semibold">Alasan Pembatalan <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" name="alasan" id="alasanPembatalan" rows="4"
                                placeholder="Tuliskan alasan pembatalan dengan jelas..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-danger"> Ajukan
                            Pembatalan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var fetchUrl = "{{ route('permit.po.fetch') }}";
    </script>
    <script>
        let currentStatus = 'draft';
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
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            order: [
                [2, 'desc']
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

        function loadStatusCounts() {
            $.ajax({
                url: fetchUrl,
                type: "GET",
                data: {
                    count_only: true
                },
                success: function(data) {
                    for (const status in data) {
                        $(`.tab-count[data-tab="${status}"]`).text(data[status]);
                    }
                },
                error: function() {
                    console.error("Gagal memuat jumlah data per status");
                }
            });
        }

        $('#statusTabs .nav-link').on('click', function(e) {
            e.preventDefault();
            $('#statusTabs .nav-link').removeClass('active');
            $(this).addClass('active');
            currentStatus = $(this).data('status');
            dataTable.ajax.reload();
        });

        $(document).ready(function() {
            loadStatusCounts();

            $('#dataTable').on('draw.dt', function() {
                loadStatusCounts();
            });
        });
    </script>

    <script>
        $(document).on('click', '.ajukanPembatalanBtn', function() {
            let id = $(this).data('id');
            let no_po = $(this).data('no_po');
            let nama = $(this).data('nama');
            let vendor = $(this).data('vendor');
            let mulai = $(this).data('mulai');
            let akhir = $(this).data('akhir');
            let mulaiFormatted = moment(mulai).format('DD-MM-YYYY');
            let akhirFormatted = moment(akhir).format('DD-MM-YYYY');
            $('#modalTanggal').text(mulaiFormatted + ' s/d ' + akhirFormatted);
            $('#pembatalanPoId').val(id);
            $('#modalNoPO').text(no_po);
            $('#modalNamaPekerjaan').text(nama);
            $('#modalVendor').text(vendor);
            $('#alasanPembatalan').val('');
            $('#modalPembatalan').modal('show');
        });
    </script>
    <script>
        $('#formPembatalan').on('submit', function(e) {
            e.preventDefault();

            let form = $(this);
            let url = "{{ route('permit.pembatalan.store') }}";

            $.ajax({
                url: url,
                method: "POST",
                data: form.serialize(),
                beforeSend: function() {
                    form.find('button[type="submit"]').prop('disabled', true).text('Mengirim...');
                },
                success: function(response) {
                    $('#modalPembatalan').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    $('#dataTable').DataTable().ajax.reload(null, false);
                },
                error: function(xhr) {
                    let msg = xhr.responseJSON?.message || 'Terjadi kesalahan';
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: msg,
                    });
                },
                complete: function() {
                    form.find('button[type="submit"]').prop('disabled', false).text('Ajukan');
                }
            });
        });
    </script>

    <script>
        $(document).on('click', '.btnSelesaikan', function(e) {
            e.preventDefault();

            const url = $(this).data('url');

            Swal.fire({
                title: 'Yakin ingin menyelesaikan pekerjaan?',
                text: "Tindakan ini akan menandai pekerjaan sebagai selesai.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Selesaikan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
    </script>

@endsection
