import { reloadTable } from "./reloadTable";

$(document).ready(function () {
    $('#table_dosen').DataTable({
        "processing": true,
        "paging": true,
        "searching": true,
        "responsive": true,
        "language": {
            "search": "cari"
        },
        "ajax": {
            "url": "getAllDataDosen",
            "type": "GET"
        },
        "columns": [
            {
                "data": null,
                "render": function (_data, _type, _row, meta) {
                    return meta.row + 1; // Nomor urut otomatis berdasarkan posisi baris
                }
            },
            { "data": "name", "orderable": true },
            { "data": "nip", "orderable": true },
            {
                "data": null,
                "render": function (_data, _type, row) {
                    return row.jabatan ? row.jabatan.jabatan : '<strong style="color:red;">not found</strong>';
                },
                "orderable": true
            },
            { "data": "phone_number", "orderable": true },
            { "data": "email", "orderable": true },
            {
                "data": null,
                "render": function (_data, _type, row) {
                    return "<button type='button' data-id='" + row.id_dosen + "' class='btn btn-sm btn-danger btnDelete'><i class='fas a-solid fa-trash'></i></button> <button class='btn btn-sm btn-warning btnEdit' id='" + row.id_dosen + "'><i class='fas fa-regular fa-pen'></i></button>"
                }
                , "orderable": false
            }
        ]
    });

    function showModal(modal, title, form, icon) {
        $("#" + modal).modal('show');
        $('.modal-title').text(title);
        $('.action').attr('id', form);
        $('.action').html(icon);
    }

    function clearErrorMsg() {
        $('#name_error').text('');
        $('#name').removeClass('is-invalid');
        $('#nip_error').text('');
        $('#nip').removeClass('is-invalid');
        $('#jabatan_error').text('');
        $('#jabatan').removeClass('is-invalid');
        $('#no_telpn_error').text('');
        $('#no_telpn').removeClass('is-invalid');
        $('#email_error').text('');
        $('#email').removeClass('is-invalid');
        $('#dir_foto_error').text('');
    }

    function clearInput() {
        $('#modalDosen input').val('');
        $('#modalDosen input[type="file"]').val(null);
        $('#img-preview').attr('src', '/images/download.png');
    }

    $('#btnCreate').on('click', function () {
        if ($('.action').attr('id') != 'btnCreateform') {
            clearErrorMsg();
            clearInput();
        }
        showModal('modalDosen', 'Form Add Dosen', 'btnCreateform', "<i class='fas fa-save'></i> Simpan");
    });

    $(document).on('click', '#btnCreateform', function () {
        var data = new FormData();
        data.append('name', $('#name').val());
        data.append('nip', $('#nip').val());
        data.append('jabatan', $('#jabatan').val());
        data.append('no_telpn', $('#no_telpn').val());
        data.append('email', $('#email').val());
        if ($('#file_image')[0].files.length > 0) {
            data.append('dir_foto', $('#file_image')[0].files[0]);
        }

        $.ajax({
            type: "POST",
            url: "dosen",
            data: data,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                if (response.status == 200) {
                    clearInput();
                    clearErrorMsg();
                    reloadTable(table_dosen);
                    $('#modalDosen').modal('hide');
                    Swal.fire({
                        title: "Created!",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "Yes"
                    });
                }
            },
            error: function (xhr) {
                console.log(xhr);
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    clearErrorMsg();
                    if (errors.name) {
                        $('#name_error').text(errors.name);
                        $('#name').addClass('is-invalid');
                    }
                    if (errors.nip) {
                        $('#nip_error').text(errors.nip);
                        $('#nip').addClass('is-invalid');
                    }
                    if (errors.jabatan) {
                        $('#jabatan_error').text(errors.jabatan);
                        $('#jabatan').addClass('is-invalid');
                    }
                    if (errors.no_telpn) {
                        $('#no_telpn_error').text(errors.no_telpn);
                        $('#no_telpn').addClass('is-invalid');
                    }
                    if (errors.email) {
                        $('#email_error').text(errors.email);
                        $('#email').addClass('is-invalid');
                    }
                    if (errors.dir_foto) {
                        $('#dir_foto_error').text(errors.dir_foto);
                    }
                }
            }
        });
    });

    $(document).on('click', '.btnEdit', function () {
        showModal('modalDosen', 'Form Edit Dosen', 'btnEditform', "<i class='fas fa-regular fa-pen'></i> Update");
        clearErrorMsg();
        var url = "dosen/" + $(this).attr('id') + "/edit";
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function (response) {
                if (response.status === 200) {
                    $('#id').val(response.data.id_dosen);
                    $('#name').val(response.data.name);
                    $('#nip').val(response.data.nip);
                    $('#jabatan').val(response.data.jabatan_id);
                    $('#no_telpn').val(response.data.phone_number);
                    $('#email').val(response.data.email);
                    $('#img-preview').attr('src', (response.data.photo_dir ?? '/images/download.png'));
                }
            },
            error: function (xhr) {
                console.log(xhr)
            }
        });
    });

    $(document).on('click', '#btnEditform', function () {
        var data = new FormData();
        data.append('name', $('#name').val());
        data.append('_method', 'PUT');
        data.append('nip', $('#nip').val());
        data.append('jabatan', $('#jabatan').val());
        data.append('phone_number', $('#no_telpn').val());
        data.append('email', $('#email').val());
        if ($('#file_image')[0].files.length > 0) {
            data.append('dir_foto', $('#file_image')[0].files[0]);
        }

        $.ajax({
            type: "POST",
            url: "dosen/" + $('#id').val(),
            data: data,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                if (response.status == 200) {
                    clearInput();
                    clearErrorMsg();
                    reloadTable(table_dosen);
                    $('#modalDosen').modal('hide');
                    Swal.fire({
                        title: "Update!",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "Ok"
                    });
                }
            },
            error: function (xhr) {
                console.log(xhr);
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    clearErrorMsg();
                    if (errors.name) {
                        $('#name_error').text(errors.name);
                        $('#name').addClass('is-invalid');
                    }
                    if (errors.nip) {
                        $('#nip_error').text(errors.nip);
                        $('#nip').addClass('is-invalid');
                    }
                    if (errors.jabatan) {
                        $('#jabatan_error').text(errors.jabatan);
                        $('#jabatan').addClass('is-invalid');
                    }
                    if (errors.phone_number) {
                        $('#no_telpn_error').text(errors.phone_number);
                        $('#no_telpn').addClass('is-invalid');
                    }
                    if (errors.email) {
                        $('#email_error').text(errors.email);
                        $('#email').addClass('is-invalid');
                    }
                    if (errors.dir_foto) {
                        $('#dir_foto_error').text(errors.dir_foto);
                    }
                }
            }
        });
    });

    // menangani proses delete data
    $(document).on('click', '.btnDelete', function () {
        Swal.fire({
            title: "Yakin ingin menghapus?",
            icon: "warning",
            text: "Data yang berelasi juga akan dihapus",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes"
        }).then((result) => {
            if (result.isConfirmed) {
                var url = 'dosen/' + $(this).data('id');
                $.ajax({
                    type: "DELETE",
                    url: url,
                    dataType: "json",
                    success: function (response) {
                        Swal.fire({
                            title: "Deleted!",
                            text: response.message,
                            icon: "success"
                        });
                        reloadTable(table_dosen);
                    },
                    error: function (xhr, stattus, error) {
                        console.error(xhr + "\n" + stattus + "\n" + error)
                    }
                });
            }
        });
    });
});