@extends('layouts.master')
@section('title', 'Lokasi Divisi')
@section('header', 'Lokasi Divisi')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-sm-6 col-12">
                        <h2>Lokasi Divisi</h2>
                    </div>
                    <div class="col-sm-6 col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="iconly-Home icli svg-color"></i></a>
                            </li>
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Lokasi</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <button class="btn btn-primary" id="btnTambahLokasi">Tambah Lokasi</button>
                            </div>

                            <div class="table-responsive">
                                <table id="lokasiTable" class="display table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Lokasi</th>
                                            <th>Divisi/Departemen</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah/Edit Lokasi -->
    <div class="modal fade" id="modalTambahLokasi" tabindex="-1" aria-labelledby="modalTambahLokasiLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="formTambahLokasi" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahLokasiLabel">Tambah Lokasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="namaLokasi" class="form-label">Nama Lokasi</label>
                            <input type="text" name="nama_lokasi" id="namaLokasi" class="form-control"
                                placeholder="Masukkan nama lokasi" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal Divisi/Departemen -->
    <div class="modal fade" id="divisiModal" tabindex="-1" role="dialog" aria-labelledby="divisiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kelola Divisi di Lokasi: <span id="namaLokasiModal"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="divisiCheckboxList">
                        <p>Memuat divisi...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="btnSimpanDivisi">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const fetchUrl = "{{ route('divisi.lokasi.fetch') }}";

        $(document).ready(function() {
            const table = $('#lokasiTable').DataTable({
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
                        data: 'nama_lokasi',
                        name: 'nama_lokasi'
                    },
                    {
                        data: 'daftar_divisi',
                        name: 'daftar_divisi',
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
                language: {
                    emptyTable: "Tidak ada data tersedia",
                    zeroRecords: "Data tidak ditemukan",
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    paginate: {
                        first: "Awal",
                        last: "Akhir",
                        next: ">",
                        previous: "<"
                    }
                }
            });

            $('#btnTambahLokasi').on('click', function() {
                $('#formTambahLokasi')[0].reset();
                $('#formTambahLokasi').removeAttr('data-id');
                $('#modalTambahLokasiLabel').text('Tambah Lokasi');
                $('#formTambahLokasi button[type=submit]').text('Simpan');
                $('#modalTambahLokasi').modal('show');
            });

            $('#lokasiTable').on('click', '.edit-lokasi', function() {
                const id = $(this).data('id');
                $.get(`/lingkungan/lokasi-divisi/${id}`, function(res) {
                    $('#formTambahLokasi').attr('data-id', id);
                    $('#namaLokasi').val(res.nama_lokasi);
                    $('#modalTambahLokasiLabel').text('Edit Lokasi');
                    $('#formTambahLokasi button[type=submit]').text('Perbarui');
                    $('#modalTambahLokasi').modal('show');
                }).fail(function() {
                    Swal.fire('Gagal', 'Gagal mengambil data lokasi', 'error');
                });
            });

            $('#formTambahLokasi').submit(function(e) {
                e.preventDefault();
                const id = $(this).attr('data-id');
                const isEdit = !!id;
                const url = isEdit ? `/lingkungan/lokasi-divisi/${id}` :
                    "{{ route('divisi.lokasi.store') }}";
                const method = isEdit ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    type: method,
                    data: $(this).serialize(),
                    success: function() {
                        $('#modalTambahLokasi').modal('hide');
                        $('#formTambahLokasi')[0].reset();
                        $('#formTambahLokasi').removeAttr('data-id');
                        table.ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: isEdit ? 'Lokasi berhasil diperbarui' :
                                'Lokasi berhasil ditambahkan',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    },
                    error: function() {
                        Swal.fire('Gagal', isEdit ? 'Gagal memperbarui lokasi' :
                            'Gagal menambahkan lokasi', 'error');
                    }
                });
            });

            $('#lokasiTable').on('click', '.delete-lokasi', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'Hapus Lokasi?',
                    text: "Data yang dihapus tidak dapat dikembalikan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/lingkungan/lokasi-divisi/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function() {
                                table.ajax.reload();
                                Swal.fire('Terhapus!', 'Data berhasil dihapus.',
                                    'success');
                            },
                            error: function() {
                                Swal.fire('Gagal', 'Gagal menghapus lokasi', 'error');
                            }
                        });
                    }
                });
            });

            $('#lokasiTable').on('click', '.show-divisi', function() {
                const lokasiId = $(this).data('id');
                $('#divisiModal').data('lokasiId', lokasiId);

                $.get(`/lingkungan/lokasi-divisi/${lokasiId}/divisi`, function(response) {
                    $('#namaLokasiModal').text(response.lokasi.nama_lokasi);
                    const selectedNames = response.divisis.map(item => item.nama_divisi
                        .toLowerCase());

                    $.get('http://115.85.65.125:8084/microservices/public/api/v1/divisions',
                        function(data) {
                            if (data.status === 1 && Array.isArray(data.data)) {
                                const html = data.data.map(item => {
                                    const checked = selectedNames.includes(item.name
                                        .toLowerCase()) ? 'checked' : '';
                                    return `
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="divisi_ids[]" value="${item.id}" id="divisi_${item.id}" ${checked}>
                                    <label class="form-check-label" for="divisi_${item.id}">${item.name}</label>
                                </div>`;
                                }).join('');
                                $('#divisiCheckboxList').html(html);
                            } else {
                                $('#divisiCheckboxList').html(
                                    '<p class="text-muted">Tidak ada divisi tersedia</p>');
                            }
                            $('#divisiModal').modal('show');
                        }).fail(() => {
                        $('#divisiCheckboxList').html(
                            '<p class="text-danger">Gagal mengambil data divisi dari API</p>'
                        );
                    });
                }).fail(() => {
                    Swal.fire('Gagal', 'Gagal memuat data divisi lokasi', 'error');
                });
            });

            $('#btnSimpanDivisi').on('click', function() {
                const lokasiId = $('#divisiModal').data('lokasiId');
                const checkedIds = $('#divisiCheckboxList input:checked').map(function() {
                    return $(this).val();
                }).get();

                $.post(`/lingkungan/lokasi-divisi/${lokasiId}/divisi`, {
                    _token: "{{ csrf_token() }}",
                    divisi_ids: checkedIds
                }).done(res => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: res.message || 'Divisi berhasil diperbarui',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    $('#divisiModal').modal('hide');
                    table.ajax.reload();
                }).fail(() => {
                    Swal.fire('Gagal', 'Gagal menyimpan divisi', 'error');
                });
            });
        });
    </script>

@endsection
