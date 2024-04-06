


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
        $('#labelPass').text('Password');
        showModal(modal = "modalUser", title = "Add User", form = "btnCreateform", icon = "<i class='fas fa-save'></i> Simpan");

    });

    $(document).on('click', '#btnCreateform', function () {
        var formData = $('#form').serialize();
        url = "user";
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            dataType: "json",
            beforeSend: function () {
                $('#btnCreateform').text('Simpan...');
            },
            success: function (response) {
                if (response.status == 200) {
                    $('#btnCreateform').text('Simpan');
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
                $('#btnCreateform').text('Simpan');
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
        url = "user/" + $(this).attr('id') + "/edit";
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function (response) {
                console.log(response.data[0])
                $('#id').val(response.data[0].id_user);
                $('#name').val(response.data[0].name);
                $('#email').val(response.data[0].email);
                $('#role').val(response.data[0].role);
                if (response.data[0].role == 1) {
                    $('.role').css('display', 'none')
                } else {
                    $('.role').css('display', 'block')
                }
                $('#labelPass').text('Ganti password (optional)');
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
        url = "user/" + id;
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
                clearErrorMsg();
                console.error(xhr.responseJSON.password)
                var errorMessage = xhr.responseJSON.errors;
                $('#email_error').text(xhr.responseJSON.email);
                $('#pass_error').text(xhr.responseJSON.password);
                if (errorMessage.email) {
                    $('#email_error').text(errorMessage.email);
                } else {
                    $('#email_error').text(responseJSON.email);
                }
                $('#name_error').text(errorMessage.name);
                $('#role_error').text(errorMessage.role);
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
                var url = 'user/' + $(this).data('id');
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

    $('.showImport').click(function () {
        $('#modalImport').modal('show');
        $('.action').html("<i class='fas fa-solid fa-file-import'></i> Import");
        $('.action').attr('id', "btnImport");
    });

    // Menangani proses import
    $(document).on('click', '#btnImport', function () {
        var data = new FormData();
        data.append('file', $('#file').prop('files')[0]);
        $.ajax({
            type: "POST",
            url: "importUser",
            data: data,
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function () {
                $('#btnImport').text('proses...');
            },
            success: function (response) {
                $("#modalImport").modal('hide');
                Swal.fire({
                    title: "Imported!",
                    text: response.message,
                    icon: "success"
                });
                reloadTable(tableUsers);
                $('.action').html("<i class='fas fa-solid fa-file-import'></i> Import");
            }, error: function (xhr) {
                console.error(xhr.responseJSON)
                $('.action').html("<i class='fas fa-solid fa-file-import'></i> Import");
                alert('check file .csv/.xlsx anda, pastikan terdapat coloumn nama, email, role(1=admin, 2=pimpinan,3=dosen, 4=mahasiswa, 5=staff), dan password')
            }
        });
    });

    // menangani proses export
    $('.btnExport').click(function () {
        // Membuat permintaan AJAX GET
        $.ajax({
            type: "GET",
            url: "exportUser",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            beforeSend: function () {
                $('.btnExport').text('sedang memproses..');
            },
            success: function () {
                $('.btnExport').text('Export');
                alert('file berhasil diexport, silahkan check pada donwloads browser anda.')
            },
            error: function (xhr, status, error) {
                // Menampilkan pesan jika terjadi kesalahan saat mengunduh file
                alert("Terjadi kesalahan saat mengunduh file: " + error);
            }
        });
    });


});