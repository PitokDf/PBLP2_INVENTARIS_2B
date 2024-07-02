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
            "url": "getAllDataUser",
            "type": "GET"
        },
        "columns": [
            {
                "data": null,
                "render": function (_data, _type, _row, meta) {
                    return meta.row + 1; // Nomor urut otomatis berdasarkan posisi baris
                }
            },
            { "data": "username", "orderable": true },
            { "data": "email", "orderable": true },
            {
                "data": null, "render": function (_data, _type, row) {
                    if (row.email_verified_at !== null) return `<span class="badge bg-success"  style="text-align: center;">verified</span>`;
                    else return `<span class="badge bg-danger"  style="text-align: center;">unverified</span>`;
                }
            },
            {
                "data": "role",
                "render": function (data) {
                    return role[data - 1];
                }, "orderable": true
            },
            {
                "data": null,
                "render": function (_data, _type, row) {
                    return "<button type='button' data-id='" + row.id_user + "' class='btn btn-sm btn-danger btnDelete'><i class='fas a-solid fa-trash'></i></button> <button class='btn btn-sm btn-warning btnEdit' id='" + row.id_user + "'><i class='fas fa-regular fa-pen'></i></button>"
                }
                , "orderable": false
            } // Contoh tombol aksi
        ]
    });

    var url = "";

    function setKondisiNormal() {
        $('#kondisi').html('');
        $('#role').attr('disabled', false);
        $('#email').attr('readonly', false);
    }

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
            clearErrorMsg();
            clerInput(modal = "modalUser");
            setKondisiNormal();
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
                $('.action').html('Memproses...');
            },
            success: function (response) {
                if (response.status == 200) {
                    $('.action').html(`<i class='fas fa-save'></i> Simpan`);
                    clerInput(modal = "modalUser");
                    clearErrorMsg();
                    reloadTable(tableUsers);
                    setKondisiNormal();
                    $('#modalUser').modal('hide');
                    Swal.fire({
                        title: "Created!",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "Yes"
                    })
                }
            },
            error: function (xhr) {
                console.error(xhr);
                $('.action').html(`<i class='fas fa-save'></i> Simpan`);
                clearErrorMsg();
                var errorMessage = xhr.responseJSON.errors;
                $('#name_error').text(errorMessage.name);
                $('#email_error').text(errorMessage.email);
                $('#role_error').text(errorMessage.role);
                $('#pass_error').text(errorMessage.password);
            }
        });
    });

    $(document).on('change', '#nip', function () {
        $('#email').attr('readonly', false)
        $('#email').val('')
        AjaxGetData('/getEmailDosen/' + $(this).val(), function (res) {
            res.status === 200 ? ($('#email').val(res.email), $('#email').attr('readonly', true), $('#name').val(res.nama)) : ''
            res.status === 404 ? $('#email').attr('readonly', false) : ''
        });
    });
    $(document).on('change', '#nim', function () {
        $('#email').attr('readonly', false)
        $('#email').val('')
        AjaxGetData('/getNamaMahasiswa/' + $(this).val(), function (res) {
            res.status === 200 ? $('#name').val(res.nama) : ''
        });
    });

    function fetchingNip() {
        $('#kondisi').html(`
            <div class="mb-3">
                <label for="nip" class="form-label">NIP</label>
                <select id="nip" name="nip" class="form-control">
                <option value="">-- Pilih nip --</option>
                </select>
                <span id="nip_error" class="text-danger"></span>
            </div>
            `);

        $.ajax({
            type: "GET",
            url: "/getDosenNip",
            dataType: "json",
            success: function (response) {
                if (response.status === 200) {
                    $.each(response.data, function (indexInArray, data) {
                        $('#nip').append(`
                            <option value="${data.id_dosen}">${data.nip} - ${data.name} - ${data.jabatan ? data.jabatan.jabatan : 'not found'}</option>
                            `);
                        $('#nip').selectpicker('refresh');
                    });
                }
            }
        });

        $('#nip').selectpicker({
            liveSearch: true
        });
    }
    function fetchingNim() {
        $('#kondisi').html(`
            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <select id="nim" name="nim" class="form-control">
                <option value="">-- Pilih nim --</option>
                </select>
                <span id="nim_error" class="text-danger"></span>
            </div>
            `);
        $.ajax({
            type: "GET",
            url: "/getMahasiswaNim",
            dataType: "json",
            success: function (response) {
                if (response.status === 200) {
                    $.each(response.data, function (indexInArray, data) {
                        $('#nim').append(`
                            <option value="${data.id_mahasiswa}">${data.nim} - ${data.nama}</option>
                            `);
                        $('#nim').selectpicker('refresh');
                    });
                }
            }
        });
        $('#nim').selectpicker({
            liveSearch: true
        });
    }

    function getKondisiData(role, other = null) {
        if (other !== null) {
            if (role == 2 || role == 3 || role == 5) {
                setKondisiNormal();
                $('#email').attr('readonly', true)
                $('#kondisi').html(`
                <div class="mb-3">
                    <label for="nip" class="form-label">NIP</label>
                    <div class="input-group mb-3">
                        <input type="number" value="${other}" class="form-control" name="nip" id="nip" placeholder="exp: 1999270190" disabled/>
                        <button type="button" class="btn btn-warning" data-id="${other}" data-role="dosen" id="unlink"><i class="fas fa-unlink"></i></button>
                    </div>
                    <span id="nip_error" class="text-danger"></span>
                </div>
                `);
            } else if (role == 4) {
                $('#email').attr('readonly', false)
                setKondisiNormal();
                $('#kondisi').html(`
                <div class="mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <div class="input-group">
                        <input type="number" value="${other}" class="form-control" name="nim" id="nim" placeholder="exp: 2211083044" disabled />
                        <button type="button" class="btn btn-warning" data-id="${other}" data-role="mahasiswa" id="unlink"><i class="fas fa-unlink"></i></button>
                    </div>
                    <span id="nim_error" class="text-danger"></span>
                </div>
                `);
            } else {
                $('#email').attr('readonly', false)
                setKondisiNormal();
                $('#kondisi').html('');
            }
        } else {
            $('#role').attr('disabled', false);
            if (role == 2 || role == 3 || role == 5) {
                fetchingNip();
            } else if (role == 4) {
                setKondisiNormal();
                fetchingNim();
            } else {
                setKondisiNormal();
            }
        }
    }

    $(document).on('click', '.btnEdit', function () {
        showModal(modal = "modalUser", title = "Edit User", form = "btnEditform", icon = "<i class='fas fa-regular fa-pen'></i> Update");
        clearErrorMsg();
        url = "user/" + $(this).attr('id') + "/edit";
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function (response) {
                getKondisiData(response.data[0].role, other = response.data.nim ?? response.data.nip)
                if (response.data.nim ?? response.data.nip) {
                    $('#role').attr('disabled', true)
                }
                $('#id').val(response.data[0].id_user);
                $('#name').val(response.data[0].username);
                $('#email').val(response.data[0].email);
                $('#role').val(response.data[0].role);
                if (response.data[0].email == response.session) {
                    $('.role').css('display', 'none')
                } else {
                    $('.role').css('display', 'block')
                }
                $('#labelPass').text('Ganti password (optional)');
            },
            error: function (xhr) {
                console.log(xhr)
                var errorMessage = xhr.responseJSON.errors;
                $('#name_error').text(errorMessage.name);
                $('#email_error').text(errorMessage.email);
                $('#role_error').text(errorMessage.role);
                $('#pass_error').text(errorMessage.password);
            }
        });
    });

    $('#role').change(function () { getKondisiData($(this).val()) });

    $(document).on('click', '#btnEditform', function () {
        var formData = $('#form').serialize();
        var id = $('#id').val();
        url = "user/" + id;

        $.ajax({
            type: "PUT",
            url: url,
            data: formData,
            dataType: "json",
            success: function (response) {
                response.status == 400 ? Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: response.message
                }) : "";
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
                console.log(xhr)
                // clearErrorMsg();
                xhr.status == 400 ? Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: 'Something went wrong!'
                }) : "";
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
                        response.status === 302 ? Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: response.message
                        }) : "";

                        response.status === 200 ? (Swal.fire({
                            title: "Deleted!",
                            text: response.message,
                            icon: "success"
                        }),
                            reloadTable(tableUsers))
                            : ""
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

    $('.btn-refresh').click(function () {
        reloadTable(tableUsers);
    })

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

    $(document).on('click', '#unlink', function () {
        Swal.fire({
            title: "Yakin ingin unlink user?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes"
        }).then((result) => {
            if (result.isConfirmed) {
                if ($(this).data('role') === 'dosen') {
                    $.ajax({
                        type: "GET",
                        url: "/unlink-dosen/" + $(this).data('id'),
                        dataType: "json",
                        success: function (response) {
                            response.status === 200 ? (fetchingNip(), $('#role').attr('disabled', false), $('#email').attr('readonly', false)) : Swal.fire({ title: "Ops..!", text: "Cant unlink", icon: "error" });
                        }
                    });
                } else {
                    $.ajax({
                        type: "GET",
                        url: "/unlink-mahasiswa/" + $(this).data('id'),
                        dataType: "json",
                        success: function (response) {
                            response.status === 200 ? (fetchingNim(), $('#role').attr('disabled', false)) : Swal.fire({ title: "Ops..!", text: "Cant unlink", icon: "error" });
                        }
                    });
                }
            }
        });
    });
});