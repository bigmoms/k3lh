@extends('layouts.master')
@section('title', 'Kategori & Subkategori Inspeksi')
@section('header', 'Kategori & Subkategori Inspeksi')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-sm-6 col-12">
                        <h2>Kategori & Subkategori Inspeksi</h2>
                    </div>
                    <div class="col-sm-6 col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="iconly-Home icli svg-color"></i></a>
                            </li>
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Kategori</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <button class="btn btn-primary" id="btnTambahKategori">Tambah Kategori</button>
                            </div>

                            <div class="table-responsive">
                                <table id="kategoriTable" class="display table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Kategori</th>
                                            <th>Subkategori</th>
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

    <!-- Modal Tambah Kategori -->
    <div class="modal fade" id="modalTambahKategori" tabindex="-1" aria-labelledby="modalTambahKategoriLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="formTambahKategori" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahKategoriLabel">Tambah Kategori Inspeksi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="namaKategori" class="form-label">Nama Kategori</label>
                            <input type="text" name="nama_kategori" id="namaKategori" class="form-control"
                                placeholder="Masukkan nama kategori" required>
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
    <!-- End Modal Tambah Kategori -->

    <div class="modal fade" id="subkategoriModal" tabindex="-1" role="dialog" aria-labelledby="subkategoriModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kelola Subkategori: <span id="namaKategoriModal"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group mb-3" id="subkategoriList">
                    </ul>
                    <input type="hidden" id="subkategoriIdEdit">

                    <div class="input-group">
                        <input type="text" id="inputSubkategori" class="form-control"
                            placeholder="Tambah subkategori baru">
                        <button class="btn btn-primary" id="btnTambahSub">Tambah</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Kategori -->
    <div class="modal fade" id="modalEditKategori" tabindex="-1" aria-labelledby="modalEditKategoriLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="formEditKategori">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Kategori Inspeksi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editKategoriId" name="id">
                        <div class="mb-3">
                            <label for="editNamaKategori" class="form-label">Nama Kategori</label>
                            <input type="text" name="nama_kategori" id="editNamaKategori" class="form-control"
                                placeholder="Masukkan nama kategori" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection

@section('scripts')
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script>
        var fetchUrl = "{{ route('inspeksi.kategori.fetch') }}";
    </script>
    <script>
        $(document).ready(function() {
            let table = $('#kategoriTable').DataTable({
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
                        data: 'nama_kategori',
                        name: 'nama_kategori'
                    },
                    {
                        data: 'daftar_subkategori',
                        name: 'daftar_subkategori',
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

            $('#btnTambahKategori').on('click', function() {
                $('#formTambahKategori')[0].reset();
                $('#modalTambahKategori').modal('show');
            });

            $('#kategoriTable').on('click', '.show-subkategori', function() {
                var kategoriId = $(this).data('id');
                $('#subkategoriModal').data('kategoriId', kategoriId);
                $.ajax({
                    url: "{{ route('inspeksi.kategori.subkategori.fetch', ':id') }}".replace(':id',
                        kategoriId),
                    method: 'GET',
                    success: function(response) {
                        if (response.length > 0) {

                            var subkategoriHtml = '';
                            $.each(response, function(index, subkategori) {
                                subkategoriHtml += `
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        ${subkategori.nama_sub_kategori}
                                      <div class="btn-group btn-group-sm" role="group">
                                        <button class="btn btn-warning btnEditSubkategori" data-id="${subkategori.id}" data-nama="${subkategori.nama_sub_kategori}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button class="btn btn-danger btnHapusSubkategori ms-1" data-id="${subkategori.id}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                    </li>`;
                            });
                            $('#subkategoriList').html(subkategoriHtml);
                        } else {
                            $('#subkategoriList').html(
                                '<li class="list-group-item">Tidak ada subkategori</li>');
                        }

                        $('#subkategoriModal').modal('show');

                        var kategoriNama = response.length > 0 ? response[0].kategori
                            .nama_kategori : 'Tidak ada kategori';
                        $('#namaKategoriModal').text(kategoriNama);
                    },
                    error: function(error) {
                        alert('Terjadi kesalahan saat memuat subkategori');
                    }
                });
            });

            $('#btnTambahSub').on('click', function() {
                var kategoriId = $('#subkategoriModal').data('kategoriId');
                var namaSubkategori = $('#inputSubkategori').val();
                var subkategoriId = $('#subkategoriIdEdit').val();

                if (namaSubkategori === '') {
                    alert('Nama subkategori tidak boleh kosong!');
                    return;
                }

                let url, method;
                let data = {
                    _token: "{{ csrf_token() }}",
                    nama_sub_kategori: namaSubkategori
                };

                if (subkategoriId) {
                    // Edit
                    url = "{{ route('inspeksi.kategori.subkategori.update', ':id') }}".replace(':id',
                        subkategoriId);
                    method = 'PUT';
                    data._method = 'PUT';
                } else {
                    // Tambah
                    url = "{{ route('inspeksi.kategori.subkategori.store', ':id') }}".replace(':id',
                        kategoriId);
                    method = 'POST';
                }

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: data,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#inputSubkategori').val('');
                            $('#subkategoriIdEdit').val('');
                            $('#subkategoriModal').modal('hide');
                            $('#kategoriTable').DataTable().ajax.reload();
                        });
                    },
                    error: function(error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan saat menyimpan subkategori',
                            confirmButtonText: 'Tutup'
                        });
                    }
                });
            });

            $('#formTambahKategori').submit(function(e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    type: "POST",
                    url: "{{ route('inspeksi.kategori.store') }}",
                    data: formData,
                    success: function(response) {
                        $('#modalTambahKategori').modal('hide');
                        $('#kategoriTable').DataTable().ajax.reload();
                        toastr.success('Kategori berhasil ditambahkan');
                    },
                    error: function(xhr) {
                        toastr.error('Gagal menambahkan kategori');
                    }
                });
            });

        });
    </script>
    <script>
        $('#kategoriTable').on('click', '.delete-kategori', function() {
            let id = $(this).data('id');

            Swal.fire({
                title: 'Hapus Kategori?',
                text: 'Data kategori dan seluruh subkategori akan dihapus!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/inspeksi/kategori-inspeksi/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            Swal.fire('Berhasil', res.message, 'success');
                            $('#kategoriTable').DataTable().ajax.reload();
                        },
                        error: function() {
                            Swal.fire('Gagal', 'Terjadi kesalahan saat menghapus kategori',
                                'error');
                        }
                    });
                }
            });
        });

        // Hapus Subkategori
        $('#subkategoriList').on('click', '.btnHapusSubkategori', function() {
            var subkategoriId = $(this).data('id');

            Swal.fire({
                title: 'Yakin hapus subkategori ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('inspeksi.kategori.subkategori.destroy', ':id') }}".replace(
                            ':id', subkategoriId),
                        method: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire('Berhasil', response.message, 'success');
                            $('#subkategoriModal').modal('hide');
                            $('#kategoriTable').DataTable().ajax.reload();
                        },
                        error: function() {
                            Swal.fire('Gagal', 'Gagal menghapus subkategori', 'error');
                        }
                    });
                }
            });
        });

        // Saat klik tombol edit
        $('#kategoriTable').on('click', '.edit-kategori', function() {
            let id = $(this).data('id');
            let nama = $(this).data('nama');

            $('#editKategoriId').val(id);
            $('#editNamaKategori').val(nama);
            $('#modalEditKategori').modal('show');
        });

        // Submit edit kategori
        $('#formEditKategori').on('submit', function(e) {
            e.preventDefault();
            let id = $('#editKategoriId').val();
            let nama_kategori = $('#editNamaKategori').val();

            $.ajax({
                url: "{{ url('inspeksi/kategori-inspeksi') }}/" + id,
                method: "POST",
                data: {
                    _method: "PUT",
                    _token: "{{ csrf_token() }}",
                    nama_kategori: nama_kategori
                },
                success: function(response) {
                    $('#modalEditKategori').modal('hide');
                    $('#kategoriTable').DataTable().ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Kategori berhasil diperbarui'
                    });
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan saat memperbarui kategori'
                    });
                }
            });
        });

        $('#subkategoriList').on('click', '.btnEditSubkategori', function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');

            $('#subkategoriIdEdit').val(id);
            $('#inputSubkategori').val(nama).focus();
        });
    </script>
@endsection
