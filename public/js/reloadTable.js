function reloadTable(id_table) {
    $(id_table).DataTable().ajax.reload();
}

$(document).on('click', '#btn_refresh', function () {
    $('#' + $(this).data('table')).DataTable().ajax.reload();
});