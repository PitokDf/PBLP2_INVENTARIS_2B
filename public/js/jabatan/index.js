$(document).ready(function () {
    // proses read data
    $('#table_jabatan').DataTable({
        "processing": true,
        "paging": true,
        "searching": true,
        "responsive": true,
        "language": {
            "search": "cari"
        },
        "ajax": {
            "url": "/getAllJabatan", // Ganti dengan URL endpoint Anda
            "type": "GET"
        },
        "columns": [
            {
                "data": null,
                "render": function (_data, _type, _row, meta) {
                    return meta.row + 1; // Nomor urut otomatis berdasarkan posisi baris
                }
            },
            { "data": "jabatan", "orderable": true },
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
        reloadTable(table_jabatan);
    })

    function clearErrorMsg() {
        $('#jabatan_error').text('');
        $('#jabatan').removeClass('is-invalid');
    }

    function clerInput(modal) {
        $('#modalJabatan input').val('');
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
        showModal(modal = "modalJabatan", title = "Add Jabatan", form = "btnCreateForm", icon = "<i class='fas fa-save'></i> Simpan");
    });

    $(document).on('click', '#btnCreateForm', function () {
        var data = new FormData();
        data.append('jabatan', $('#jabatan').val());

        $.ajax({
            type: "POST",
            url: "/jabatan",
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function (response) {
                clearErrorMsg();
                clerInput();
                reloadTable(table_jabatan);
                $('#modalJabatan').modal('hide');
                Swal.fire({
                    title: "Created!",
                    text: response.message,
                    icon: "success"
                });
            },
            error: function (errors) {
                console.log(errors)
                if (errors.status === 422) {
                    clearErrorMsg();
                    if (errors.responseJSON.jabatan) {
                        $('#jabatan').addClass('is-invalid');
                        $('#jabatan_error').text(errors.responseJSON.jabatan);
                    }
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
        showModal(modal = "modalJabatan", title = "Edit Jabatan", form = "btnEditForm", icon = "<i class='fas fa-pen'></i> Update");
        const url = "/jabatan/" + $(this).attr('id') + "/edit";
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function (response) {
                console.log(response)
                if (response.status === 200) {
                    const data = response.data;
                    $('#id').val(data.id);
                    $('#jabatan').val(data.jabatan);
                }
            },
            error: function (errors) { console.log(errors) }
        });
    });

    // melakukan proses update data
    $(document).on('click', '#btnEditForm', function () {
        var data = new FormData();
        data.append('_method', 'PUT');
        data.append('jabatan', $('#jabatan').val());

        const url = "/jabatan/" + $('#id').val()
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function (response) {
                clearErrorMsg();
                clerInput();
                reloadTable(table_jabatan);
                $('#modalJabatan').modal('hide');
                Swal.fire({
                    title: "Updated!",
                    text: response.message,
                    icon: "success"
                });
            },
            error: function (errors) {
                if (errors.status === 422) {
                    clearErrorMsg();
                    if (errors.responseJSON.jabatan) {
                        $('#jabatan').addClass('is-invalid');
                        $('#jabatan_error').text(errors.responseJSON.jabatan);
                    }
                }
            }
        });
    });

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
                var url = '/jabatan/' + $(this).data('id');
                $.ajax({
                    type: "DELETE",
                    url: url,
                    dataType: "json",
                    success: function (response) {
                        response.status === 200 ? (Swal.fire({
                            title: "Deleted!",
                            text: response.message,
                            icon: "success"
                        }), reloadTable(table_jabatan)) : ''
                    },
                    error: function (xhr, stattus, error) {
                        if (xhr.status === 500) {
                            Swal.fire({
                                title: "Ops !!",
                                text: 'Something went wrong.',
                                icon: "error",
                                confirmButtonText: "Ok"
                            });
                        }
                        console.error(xhr + "\n" + stattus + "\n" + error)
                    }
                });
            }
        });
    });
});