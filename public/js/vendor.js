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
            { data: 'kd_vendor', name: 'kd_vendor' },
            { data: 'vendor_name', name: 'vendor_name' },
            { data: 'address', name: 'address' },
            { data: 'phone', name: 'phone' },
            { data: 'email', name: 'email' },
            { data: 'direksi', name: 'direksi' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[1, 'asc']],
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
})(jQuery);
