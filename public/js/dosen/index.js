
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
            "url": "getAllDataDosen", // Ganti dengan URL endpoint Anda
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
                    return row.jabatan.jabatan
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

    var url = "";

    function clearErrorMsg() {
        $('#name_error').text('');
        $('#nip_error').text('');
        $('#jabatan_error').text('');
        $('#no_telpn_error').text('');
        $('#email_error').text('');
        $('#dir_foto_error').text('');
        $('#name').removeClass('is-invalid');
        $('#nip').removeClass('is-invalid');
        $('#jabatan').removeClass('is-invalid');
        $('#no_telpn').removeClass('is-invalid');
        $('#email').removeClass('is-invalid');
        $('#dir_foto').removeClass('is-invalid');

    }

    function clerInput(modal) {
        $('.role').css('display', 'block')
        $("#" + modal + " input").val('');
        $("#" + modal + " select").val('');
    }

    function showModal(modal, title, form, icon) {
        $("#" + modal).modal('show');
        $('.modal-title').text(title);
        $('.action').attr('id', form);
        $('.action').html(icon);
    }

    var server = "http://127.0.0.1:8000/";
    $('#btnCreate').click(function () {
        var modal = "modalDosen";
        $('#img-preview').css('display', 'block');
        $('#img-preview').attr('src', 'images/download.png');
        console.log($('#img-preview'))
        if ($('.action').attr('id') != 'btnCreateform') {
            clearErrorMsg();
            clerInput(modal);
        }
        showModal(modal, title = "Add Data Dosen", form = "btnCreateform", icon = "<i class='fas fa-save'></i> Simpan");
    });

    // proses yang akan menangani proses create data dan mengembalikan error saat terjadi error
    $(document).on('click', '#btnCreateform', function () {
        var formData = new FormData(document.getElementById('form'));
        url = "dosen";
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                if (response.status == 200) {
                    clerInput(modal = "modalDosen");
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
                console.info(xhr)
                var errorMessage = xhr.responseJSON.errors;
                clearErrorMsg();
                if (errorMessage.name) {
                    $('#name_error').text(errorMessage.name);
                    $('#name').addClass('is-invalid');
                }
                if (errorMessage.nip) {
                    $('#nip_error').text(errorMessage.nip);
                    $('#nip').addClass('is-invalid');
                }
                if (errorMessage.jabatan) {
                    $('#jabatan_error').text(errorMessage.jabatan);
                    $('#jabatan').addClass('is-invalid');
                }
                if (errorMessage.no_telpn) {
                    $('#no_telpn_error').text(errorMessage.no_telpn);
                    $('#no_telpn').addClass('is-invalid');
                }
                if (errorMessage.email) {
                    $('#email_error').text(errorMessage.email);
                    $('#email').addClass('is-invalid');
                }
                if (errorMessage.dir_foto) {
                    $('#dir_foto_error').text(errorMessage.dir_foto);
                    $('#dir_foto').addClass('is-invalid');
                }
            }
        });
    });

    // saat btn edit diclick maka akan melakakuan request ke server dengan mengirimkan id dan server akan mengembalikan data yang sesuai dengan id yang dikirimkan
    $(document).on('click', '.btnEdit', function () {
        showModal(modal = "modalDosen", title = "Edit Data Dosen", form = "btnEditform", icon = "<i class='fas fa-regular fa-pen'></i> Update");
        clearErrorMsg();
        url = "dosen/" + $(this).attr('id') + "/edit";
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function (response) {
                console.log(response)
                $('#id').val(response.data.id_dosen);
                $('#name').val(response.data.name);
                $('#nip').val(response.data.nip);
                $('#jabatan').val(response.data.jabatan_id);
                $('#no_telpn').val(response.data.phone_number);
                $('#email').val(response.data.email);
                $('#img-preview').css('display', 'block');
                if (response.data.photo_dir) {
                    $('#img-preview').attr('src', "storage/dosen/" + response.data.photo_dir);
                }
            },
            error: function (xhr) {
                console.log(xhr)
                var errorMessage = xhr.responseJSON.errors;
                $('#name_error').text(errorMessage.name);
                $('#nip_error').text(errorMessage.nip);
                $('#jabatan_error').text(errorMessage.jabatan);
                $('#no_telpn_error').text(errorMessage.no_telpn);
                $('#email_error').text(errorMessage.email);
                $('#dir_foto_error').text(errorMessage.dir_foto);
            }
        });
    });

    $(document).on('click', '#btnEditform', function () {
        var formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('name', $('#name').val());
        formData.append('nip', $('#nip').val());
        formData.append('jabatan', $('#jabatan').val());
        formData.append('no_telpn', $('#no_telpn').val());
        formData.append('email', $('#email').val());
        formData.append('dir_foto', $('#file_image')[0].files[0]);
        var id = $('#id').val();
        url = "dosen/" + id;

        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                if (response.status == 200) {
                    clerInput(modal = "modalDosen");
                    clearErrorMsg();
                    reloadTable(table_dosen);
                    $('#modalDosen').modal('hide');
                    Swal.fire({
                        title: "Updated!",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "Yes"
                    });
                }
            },
            error: function (xhr) {
                console.log(xhr)
                var errorMessage = xhr.responseJSON.errors;
                clearErrorMsg();
                if (errorMessage.name) {
                    $('#name_error').text(errorMessage.name);
                    $('#name').addClass('is-invalid');
                }
                if (errorMessage.nip) {
                    $('#nip_error').text(errorMessage.nip);
                    $('#nip').addClass('is-invalid');
                }
                if (errorMessage.jabatan) {
                    $('#jabatan_error').text(errorMessage.jabatan);
                    $('#jabatan').addClass('is-invalid');
                }
                if (errorMessage.no_telpn) {
                    $('#no_telpn_error').text(errorMessage.no_telpn);
                    $('#no_telpn').addClass('is-invalid');
                }
                if (errorMessage.email) {
                    $('#email_error').text(errorMessage.email);
                    $('#email').addClass('is-invalid');
                }
                if (errorMessage.dir_foto) {
                    $('#dir_foto_error').text(errorMessage.dir_foto);
                    $('#dir_foto').addClass('is-invalid');
                }
            }
        });
    });


    // menangani proses delete data
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