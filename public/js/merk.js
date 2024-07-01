$(document).ready(function () {
    // proses read data
    $('#table_merk').DataTable({
        "processing": true,
        "paging": true,
        "searching": true,
        "responsive": true,
        "language": {
            "search": "cari"
        },
        "ajax": {
            "url": "/getAllMerk",
            "type": "GET"
        },
        "columns": [
            {
                "data": null,
                "render": function (_data, _type, _row, meta) {
                    return meta.row + 1; // Nomor urut otomatis berdasarkan posisi baris
                }
            },
            { "data": "merk", "orderable": true },
            {
                "data": null,
                "render": function (_data, _type, row) {
                    return "<button type='button' data-id='" + row.id + "' class='btn btn-sm btn-danger btnDelete'><i class='fas a-solid fa-trash'></i></button> <button class='btn btn-sm btn-warning btnEdit' id='" + row.id + "'><i class='fas fa-regular fa-pen'></i></button>"
                }
                , "orderable": false
            } // Contoh tombol aksi
        ]
    });

    $('.btn-refresh').click(function () {
        reloadTable(table_merk);
    })

    function clearErrorMsg() {
        $('#merk_error').text('');
        $('#merk').removeClass('is-invalid');
    }

    function clerInput() {
        $('#modalMerk input').val('');
    }

    function showModal(modal, title, form, icon) {
        $("#" + modal).modal('show');
        $('.modal-title').text(title);
        $('.action').attr('id', form);
        $('.action').html(icon);
    }

    $(document).on('click', '#btnCreate', function () {
        if ($('.action').attr('id') != 'btnCreateForm') {
            clearErrorMsg();
            clerInput();
        }
        showModal(modal = "modalMerk", title = "Add Merk", form = "btnCreateForm", icon = "<i class='fas fa-save'></i> Simpan");
    });

    $(document).on('click', '#btnCreateForm', function () {
        AjaxPostIncludeSerialize('/merk-barang', $('#form').serialize(), function (res) {
            if (res.status == 200) {
                clearErrorMsg();
                clerInput();
                reloadTable(table_merk);
                $('#modalMerk').modal('hide');
                Swal.fire({
                    title: "Created!",
                    text: res.message,
                    icon: "success"
                });
            }

            if (res.status == 422) {
                clearErrorMsg();
                if (res.responseJSON.errors.merk) {
                    $('#merk').addClass('is-invalid');
                    $('#merk_error').text(res.responseJSON.errors.merk);
                }
            }
        });
    });

    // proses show modal dengan mengisi input sesuai id yang dikirim ke server
    $(document).on('click', '.btnEdit', function () {
        if ($('.action').attr('id') == 'btnCreateForm') {
            clearErrorMsg();
            clerInput();
        }
        showModal(modal = "modalMerk", title = "Edit Merk", form = "btnEditForm", icon = "<i class='fas fa-pen'></i> Update");
        const url = "/merk-barang/" + $(this).attr('id') + "/edit";
        AjaxGetData(url, function (res) {
            if (res.status == 200) {
                const data = res.data;
                $('#id').val(data.id);
                $('#merk').val(data.merk);
            }
        });
    });

    // melakukan proses update data
    $(document).on('click', '#btnEditForm', function () {
        var data = new FormData();
        data.append('_method', 'PUT');
        data.append('merk', $('#merk').val());
        const url = "/merk-barang/" + $('#id').val();

        AjaxPostIncludeData(url, data, function (res, errors) {
            if (res.status === 200) {
                clearErrorMsg();
                clerInput();
                reloadTable(table_merk);
                $('#modalMerk').modal('hide');
                Swal.fire({
                    title: "Updated!",
                    text: res.message,
                    icon: "success"
                });
            }
            if (errors) {
                if (errors.status === 422) {
                    clearErrorMsg();
                    if (errors.responseJSON.errors.merk) {
                        $('#merk').addClass('is-invalid');
                        $('#merk_error').text(errors.responseJSON.errors.merk);
                    }
                }
            }
        });
    });

    // Proses Delete Data
    $(document).on('click', '.btnDelete', function () {
        Swal.fire({
            title: "Yakin ingin menghapus?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes"
        }).then((result) => {
            if (result.isConfirmed) {
                var url = '/merk-barang/' + $(this).data('id');
                var data = new FormData();
                data.append('_method', 'DELETE');
                AjaxPostIncludeData(url, data, function (res, errors) {
                    res.status === 200 ? (Swal.fire({
                        title: "Deleted!",
                        text: res.message,
                        icon: "success"
                    }), reloadTable(table_merk)) : ''
                    if (errors) {
                        if (errors.status === 500) {
                            Swal.fire({
                                title: "Ops !!",
                                text: 'Something went wrong.',
                                icon: "error",
                                confirmButtonText: "Ok"
                            });
                        }
                    }
                });
            }
        });
    });
});