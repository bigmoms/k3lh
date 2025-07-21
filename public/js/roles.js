(function ($) {
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ordering: true,
        ajax: {
            url: FetchUrl,
            type: "GET",
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'menus', name: 'menus' },
            { data: 'permission', name: 'permission' },
            {
                data: 'is_active',
                render: function (data, type, row) {
                    return `<input type="checkbox" class="toggle-status" data-id="${row.id}" ${data == 'Aktif' ? 'checked' : ''}>`;
                }
            },
            { data: 'action', orderable: false, searchable: false }
        ],
        order: [[1, 'asc']]
    });

    $(document).on('change', '.toggle-status', function () {
        let userId = $(this).data('id');
        let status = $(this).is(':checked') ? 1 : 0;
        $.ajax({
            url: `/admin/roles/${userId}/toggle-status`,
            type: 'POST',
            data: {
                is_active: status
            },
            success: function (response) {
                Swal.fire({
                    title: "Sukses!",
                    text: response.message,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
            },
            error: function () {
                Swal.fire("Error!", "Terjadi kesalahan saat memperbarui status.",
                    "error");
            }
        });
    });
});
})(jQuery);
