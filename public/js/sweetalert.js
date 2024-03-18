document.addEventListener('contextmenu', function (e) {
    e.preventDefault();
});


$(document).ready(function () {
    var role = ['Admin', 'Pimpinan', 'Dosen', 'Mahasiswa', 'Staff'];
    $('#tableUsers').DataTable({
        "processing": true,
        "paging": true,
        "searching": true,
        "responsive": true,
        "language": {
            "search": "cari"
        },
        "ajax": {
            "url": "getAllDataUser", // Ganti dengan URL endpoint Anda
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
            { "data": "email", "orderable": true },
            {
                "data": "role",
                "render": function (data) {
                    return role[data - 1];
                }, "orderable": true
            },
            {
                "data": null,
                "render": function (_data, _type, row) {
                    // if (row.role == 1) {
                    //     return "<button type='button' class='btn btn-sm btn-danger' style='cursor: not-alowed' disabled><i class='fas a-solid fa-trash'></i></button> <button class='btn btn-sm btn-warning btnEdit' disabled><i class='fas fa-regular fa-pen'></i></button>"
                    // } else {
                    return "<button type='button' data-id='" + row.id_user + "' class='btn btn-sm btn-danger btnDelete'><i class='fas a-solid fa-trash'></i></button> <button class='btn btn-sm btn-warning btnEdit' id='" + row.id_user + "'><i class='fas fa-regular fa-pen'></i></button>"
                    // }
                }
                , "orderable": false
            } // Contoh tombol aksi
        ]
    });

    var url = "";

    function clearErrorMsg() {
        $('#name_error').text('');
        $('#email_error').text('');
        $('#role_error').text('');
        $('#pass_error').text('');
    }

    function clerInput(modal) {
        $('.role').css('display', 'block')
        $("#" + modal + " input").val('');
        $("#" + modal + " select").val($('#' + modal + " select option:first").val());
    }

    function showModal(modal, title, form, icon) {
        $("#" + modal).modal('show');
        $('.modal-title').text(title);
        $('.action').attr('id', form);
        $('.action').html(icon);
    }

    $('#btnCreate').click(function () {
        if ($('.action').attr('id') != 'btnCreateform') {
            clerInput(modal = "modalUser");
        }
        showModal(modal = "modalUser", title = "Add User", form = "btnCreateform", icon = "<i class='fas fa-save'></i> Simpan");

    });

    $(document).on('click', '#btnCreateform', function () {
        var formData = $('#form').serialize();
        url = "users";
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            dataType: "json",
            success: function (response) {
                if (response.status == 200) {
                    clerInput(modal = "modalUser");
                    clearErrorMsg();
                    reloadTable(tableUsers);
                    $('#modalUser').modal('hide');
                    Swal.fire({
                        title: "Insert!",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "Yes"
                    })
                }
            },
            error: function (xhr) {
                console.error(xhr);
                clearErrorMsg();
                var errorMessage = xhr.responseJSON.errors;
                $('#name_error').text(errorMessage.name);
                $('#email_error').text(errorMessage.email);
                $('#role_error').text(errorMessage.role);
                $('#pass_error').text(errorMessage.password);
            }
        });
    });

    $(document).on('click', '.btnEdit', function () {
        showModal(modal = "modalUser", title = "Edit User", form = "btnEditform", icon = "<i class='fas fa-regular fa-pen'></i> Update");
        clearErrorMsg();
        url = "users/" + $(this).attr('id') + "/edit";
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function (response) {
                $('#id').val(response.data[0].id_user);
                $('#name').val(response.data[0].name);
                $('#email').val(response.data[0].email);
                $('#role').val(response.data[0].role);
                if (response.data[0].role == 1) {
                    $('.role').css('display', 'none')
                } else {
                    $('.role').css('display', 'block')
                }
                $('#password').val(response.data[0].password);
            },
            error: function (xhr) {
                var errorMessage = xhr.responseJSON.errors;
                $('#name_error').text(errorMessage.name);
                $('#email_error').text(errorMessage.email);
                $('#role_error').text(errorMessage.role);
                $('#pass_error').text(errorMessage.password);
            }
        });
    });

    $(document).on('click', '#btnEditform', function () {
        var formData = $('#form').serialize();
        var id = $('#id').val();
        url = "users/" + id;
        console.log(url + formData)

        $.ajax({
            type: "PUT",
            url: url,
            data: formData,
            dataType: "json",
            success: function (response) {
                if (response.status == 200) {
                    clerInput(modal = "modalUser");
                    clearErrorMsg();
                    reloadTable(tableUsers);
                    $('#modalUser').modal('hide');
                    Swal.fire({
                        title: "Updated!",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "Yes"
                    });
                }
            },
            error: function (xhr) {
                console.error(xhr.responseJSON.email)
                $('#email_error').text(xhr.responseJSON.email);
                var errorMessage = xhr.responseJSON.errors;
                $('#name_error').text(errorMessage.name);
                $('#email_error').text(errorMessage.email);
                $('#role_error').text(errorMessage.role);
                $('#pass_error').text(errorMessage.password);
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
                var url = 'users/' + $(this).data('id');
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
                        reloadTable(tableUsers);
                    },
                    error: function (xhr, stattus, error) {
                        console.error(xhr + "\n" + stattus + "\n" + error)
                    }
                });
            }
        });
    });
});