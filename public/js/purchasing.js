(function ($) {
    $(document).ready(function () {
        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: FetchUrl,
                type: "GET",
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'vendor', name: 'vendor' },
                { data: 'no_po', name: 'no_po' },
                { data: 'nama_pekerjaan', name: 'nama_pekerjaan' },
                { data: 'jenis_pekerjaan', name: 'jenis_pekerjaan' },
                { data: 'area_pekerjaan', name: 'area_pekerjaan' },
                { data: 'lokasi_pekerjaan', name: 'lokasi_pekerjaan' },
                {
                    data: 'tanggal_mulai',
                    name: 'tanggal_mulai',
                    render: function (data) {
                        return moment(data).format('DD-MM-YYYY');
                    }
                },
                {
                    data: 'tanggal_akhir',
                    name: 'tanggal_akhir',
                    render: function (data) {
                        return moment(data).format('DD-MM-YYYY');
                    }
                },
                { data: 'status', name: 'status', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[0, 'desc']],
            language: {
                processing: `<div class="spinner-border"></div>`,
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
    });

    $(document).on('click', '.btn-cancel', function (e) {
        e.preventDefault();
        const id = $(this).data('id');

        Swal.fire({
            title: 'Yakin batalkan PO ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Batalkan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/purchase-orders/cancel/${id}`,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (res) {
                        Swal.fire('Berhasil!', res.message || 'PO berhasil dibatalkan.',
                            'success');
                        $('#dataTable').DataTable().ajax.reload();
                    },
                    error: function () {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat membatalkan PO.',
                            'error');
                    }
                });
            }
        });
    });

    // $(document).on('click', '.btn-cancel', function (e) {
    //     e.preventDefault();
    //     let id = $(this).data('id');
    //     if (confirm('Apakah Anda yakin ingin membatalkan PO ini?')) {
    //         $.ajax({
    //             url: `/admin/purchase-orders/cancel/${id}`,
    //             type: 'POST',
    //             data: {
    //                 _token: $('meta[name="csrf-token"]').attr('content'),
    //             },
    //             success: function (response) {
    //                 alert(response.message);
    //                 $('#dataTable').DataTable().ajax.reload();
    //             },
    //             error: function () {
    //                 alert('Terjadi kesalahan.');
    //             }
    //         });
    //     }
    // });
})(jQuery);
