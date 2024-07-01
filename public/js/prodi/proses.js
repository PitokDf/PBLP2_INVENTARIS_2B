$(document).ready(function () {
    // proses read data
    $('#tableProdi').DataTable({
        "processing": true,
        "paging": true,
        "searching": true,
        "responsive": true,
        "language": {
            "search": "cari"
        },
        "ajax": {
            "url": "/getAllDataProdi", // Ganti dengan URL endpoint Anda
            "type": "GET"
        },
        "columns": [
            {
                "data": null,
                "render": function (_data, _type, _row, meta) {
                    return meta.row + 1; // Nomor urut otomatis berdasarkan posisi baris
                }
            },
            { "data": "code_prodi", "orderable": true },
            { "data": "nama_prodi", "orderable": true },
            {
                "data": null,
                "render": function (_data, _type, row) {
                    return "<button type='button' data-id='" + row.code_prodi + "' class='btn btn-sm btn-danger btnDelete'><i class='fas a-solid fa-trash'></i></button> <button class='btn btn-sm btn-warning btnEdit' id='" + row.code_prodi + "'><i class='fas fa-regular fa-pen'></i></button>"
                }
                , "orderable": false
            } // Contoh tombol aksi
        ]
    });

    $('.btn-refresh').click(function () {
        reloadTable(tableProdi);
    })

    function clearErrorMsg() {
        $('#kode_error').text('');
        $('#nama_error').text('');
        $('#kode').removeClass('is-invalid');
        $('#nama_prodi').removeClass('is-invalid');
    }

    function clerInput(modal) {
        $('#modalProdi input').val('');
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
            $('#kode').attr('readonly', false);
        }
        showModal(modal = "modalProdi", title = "Add Prodi", form = "btnCreateForm", icon = "<i class='fas fa-save'></i> Simpan");
    });

    $(document).on('click', '#btnCreateForm', function () {
        var data = new FormData();
        data.append('kode', $('#kode').val());
        data.append('nama', $('#nama_prodi').val());

        $.ajax({
            type: "POST",
            url: "prodi",
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function (response) {
                clearErrorMsg();
                clerInput();
                reloadTable(tableProdi);
                $('#modalProdi').modal('hide');
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
                    if (errors.responseJSON.kode) {
                        $('#kode').addClass('is-invalid');
                        $('#kode_error').text(errors.responseJSON.kode);
                    }
                    if (errors.responseJSON.nama) {
                        $('#nama_prodi').addClass('is-invalid');
                        $('#nama_error').text(errors.responseJSON.nama);
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
        showModal(modal = "modalProdi", title = "Edit Prodi", form = "btnEditForm", icon = "<i class='fas fa-pen'></i> Update");
        const url = "/prodi/" + $(this).attr('id') + "/edit";
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function (response) {
                if (response.status === 200) {
                    const data = response.data;
                    $('#id').val(data[0].code_prodi);
                    $('#kode').val(data[0].code_prodi);
                    $('#kode').attr('readonly', true);
                    $('#nama_prodi').val(data[0].nama_prodi);
                }
            },
            error: function (errors) { console.log(errors) }
        });
    });

    // melakukan proses update data
    $(document).on('click', '#btnEditForm', function () {
        var data = new FormData();
        data.append('_method', 'PUT');
        data.append('kode', $('#kode').val());
        data.append('nama', $('#nama_prodi').val());

        const url = "prodi/" + $('#id').val()
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
                reloadTable(tableProdi);
                $('#modalProdi').modal('hide');
                Swal.fire({
                    title: "Updated!",
                    text: response.message,
                    icon: "success"
                });
            },
            error: function (errors) {
                if (errors.status === 422) {
                    clearErrorMsg();
                    if (errors.responseJSON.kode) {
                        $('#kode').addClass('is-invalid');
                        $('#kode_error').text(errors.responseJSON.kode);
                    }
                    if (errors.responseJSON.nama) {
                        $('#nama_prodi').addClass('is-invalid');
                        $('#nama_error').text(errors.responseJSON.nama);
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
                var url = '/prodi/' + $(this).data('id');
                $.ajax({
                    type: "DELETE",
                    url: url,
                    dataType: "json",
                    success: function (response) {
                        response.status === 200 ? (Swal.fire({
                            title: "Deleted!",
                            text: response.message,
                            icon: "success"
                        }), reloadTable(tableProdi)) : ''
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