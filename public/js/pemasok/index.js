$(document).ready(function () {
    $('#tablePemasok').DataTable({
        "processing": true,
        "paging": true,
        "searching": true,
        "responsive": true,
        "language": {
            "search": "cari"
        },
        "ajax": {
            "url": "/getDataPemasok", // Ganti dengan URL endpoint Anda
            "type": "GET"
        },
        "columns": [
            {
                "data": null,
                "render": function (_data, _type, _row, meta) {
                    return meta.row + 1; // Nomor urut otomatis berdasarkan posisi baris
                },
                "orderable": false
            },
            {
                "data": "nama",
                "orderable": true
            },
            {
                "data": 'kode_pos',
                "orderable": true
            },
            { "data": "no_hp", "orderable": true },
            {
                "data": null,
                "render": function (_data, _type, row) {
                    return "<button type='button' data-id='" + row.id + "' class='btn btn-sm btn-danger' id='btn-hapus'><i class='fas a-solid fa-trash'></i></button> <button type='button' data-id='" + row.id + "' class='btn btn-sm btn-warning test' id='btn-edit'><i class='fas a-solid fa-pen'></i></button> <button class='btn btn-sm btn-info' id='btn-detail' data-id='" + row.id + "'><i class='fas fa-regular fa-info-circle'></i></button>"
                }
                , "orderable": false
            }
        ]
    });


    function clearErrorMsg() {
        $('#nama_error').text('');
        $('#kode_pos_error').text('');
        $('#kota_error').text('');
        $('#nohp_error').text('');
        $('#alamat_error').text('');
        $('#nama_pemasok').removeClass('is-invalid');
        $('#kode_pos').removeClass('is-invalid');
        $('#kota').removeClass('is-invalid');
        $('#no_hp').removeClass('is-invalid');
        $('#alamat').removeClass('is-invalid');
    }

    function clearInput() {
        $('#nama_pemasok').val('');
        $('#kode_pos').val('');
        $('#kota').val('');
        $('#no_hp').val('');
        $('#alamat').val('');
    }

    $(document).on('click', '#simpan', function () {
        var data = new FormData();
        data.append('nama_pemasok', $('#nama_pemasok').val());
        data.append('kode_pos', $('#kode_pos').val());
        data.append('kota', $('#kota').val());
        data.append('no_hp', $('#no_hp').val());
        data.append('alamat', $('#alamat').val());

        $.ajax({
            type: "POST",
            url: "/pemasok",
            data: data,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                if (response.status == 200) {
                    clearErrorMsg();
                    clearInput();
                    Swal.fire({
                        title: "Created!",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "Ok"
                    });
                    if ($('#modalPemasok').length) {
                        $('#modalPemasok').modal('hide');
                        getPemasok();
                    }
                    if ($('#tablePemasok').length) {
                        reloadTable(tablePemasok);
                    }
                }

                if (response.status == 400) {
                    Swal.fire({
                        title: "Ops !!",
                        text: response.message,
                        icon: "error",
                        confirmButtonText: "Ok"
                    });
                }
            },
            error: function (xhr) {
                console.log(xhr)
                var errorMessage = xhr.responseJSON.errors;
                clearErrorMsg();
                if (errorMessage.nama_pemasok) {
                    $('#nama_error').text(errorMessage.nama_pemasok);
                    $('#nama_pemasok').addClass('is-invalid');
                }
                if (errorMessage.kode_pos) {
                    $('#kode_pos_error').text(errorMessage.kode_pos);
                    $('#kode_pos').addClass('is-invalid');
                }
                if (errorMessage.kota) {
                    $('#kota_error').text(errorMessage.kota);
                    $('#kota').addClass('is-invalid');
                }
                if (errorMessage.no_hp) {
                    $('#nohp_error').text(errorMessage.no_hp);
                    $('#no_hp').addClass('is-invalid');
                }
                if (errorMessage.alamat) {
                    $('#alamat_error').text(errorMessage.alamat);
                    $('#alamat').addClass('is-invalid');
                }
            }
        });
    });

    $(document).on('click', '#btn-detail', function () {
        $('#modalDetail').modal('show');
        $.ajax({
            type: "GET",
            url: "/pemasok/" + $(this).data('id'),
            dataType: "json",
            success: function (response) {
                console.log(response)
                if (response.status == 200) {
                    const data = response.data;
                    $('#txt_nama_pemasok').text(data.nama);
                    $('#txt_kodepos').text(data.kode_pos);
                    $('#txt_kota').text(data.kota);
                    $('#txt_nohp').text(data.no_hp);
                    $('#txt_alamat').text(data.alamat);
                }
            },
            error: function (xhr) {
                console.log(xhr)
            }
        });
    });

    $(document).on('click', '#btn-hapus', function () {
        Swal.fire({
            title: "Yakin ingin menghapus Data?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes"
        }).then((result) => {
            if (result.isConfirmed) {
                var data = new FormData();
                data.append('_method', 'DELETE');
                $.ajax({
                    type: "POST",
                    url: "/pemasok/" + $(this).data('id'),
                    processData: false,
                    contentType: false,
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == 200) {
                            clearErrorMsg();
                            clearInput();
                            setNormal();
                            reloadTable(tablePemasok);
                            Swal.fire({
                                title: "Deleted!",
                                text: response.message,
                                icon: "success",
                                confirmButtonText: "Ok"
                            });
                        }
                        if (response.status == 400) {
                            Swal.fire({
                                title: "Ops !!",
                                text: response.message,
                                icon: "error",
                                confirmButtonText: "Ok"
                            });
                        }
                    }
                });
            }
        });
    });

    $(document).on('mouseover', '#btn-edit', function () {
        $('.form-pemasok').addClass('shadow-warning');
        $('.form-pemasok').removeClass('shadow');
    });

    $(document).on('mouseout', '#btn-edit', function () {
        $('.form-pemasok').removeClass('shadow-warning');
        $('.form-pemasok').addClass('shadow');
    });

    function setNormal() {
        $('.form-title').text('Form Pemasok');
        $('.action-btn').attr('id', 'simpan');
        $('.action-btn').text('Submit');
        $('.action-btn').removeClass('btn-warning');
        $('.action-btn').addClass('btn-primary');
        $('#btn-cancel').html(``);
    }

    $(document).on('click', '#btn-edit', function () {
        AjaxGetData('/pemasok/' + $(this).data('id'), function (response) {
            // console.log(response)
            if (response.status === 200) {
                clearErrorMsg();
                const data = response.data;
                $('#nama_pemasok').val(data.nama);
                $('#id').val(data.id);
                $('#kode_pos').val(data.kode_pos);
                $('#kota').val(data.kota);
                $('#no_hp').val(data.no_hp);
                $('#alamat').val(data.alamat);

                $('.form-title').text('Edit Data Pemasok');
                $('.action-btn').attr('id', 'update');
                $('.action-btn').text('Update');
                $('.action-btn').removeClass('btn-primary');
                $('.action-btn').addClass('btn-warning');
                $('#btn-cancel').html(`<button class="btn btn-sm btn-danger me-2" id="cancel-update">Cancel</button>`);
            }
        });
    });

    // mengembalikan ke form sebelumnya
    $(document).on('click', '#cancel-update', function () {
        clearErrorMsg();
        clearInput();
        setNormal();
    });

    $(document).on('click', '#update', function () {
        var data = new FormData(); // membuat object dari form data yang akan digunakan untuk menyimpan data input
        data.append('_method', 'PUT');
        data.append('nama_pemasok', $('#nama_pemasok').val());
        data.append('kode_pos', $('#kode_pos').val());
        data.append('kota', $('#kota').val());
        data.append('no_hp', $('#no_hp').val());
        data.append('alamat', $('#alamat').val());

        AjaxPostIncludeData('/pemasok/' + $('#id').val(), data, function (response) {
            // console.log(response)
            if (response.status === 200) {
                clearErrorMsg();
                clearInput();
                setNormal();
                reloadTable(tablePemasok);
                Swal.fire({
                    title: "Updated!",
                    text: response.message,
                    icon: "success",
                    confirmButtonText: "Ok"
                });
            }

            if (response.status === 422) {
                const errors = response.responseJSON.errors;
                if (errors.nama_pemasok) {
                    $('#nama_error').text(errors.nama_pemasok);
                    $('#nama_pemasok').addClass('is-invalid');
                }
                if (errors.kode_pos) {
                    $('#kode_pos_error').text(errors.kode_pos);
                    $('#kode_pos').addClass('is-invalid');
                }
                if (errors.kota) {
                    $('#kota_error').text(errors.kota);
                    $('#kota').addClass('is-invalid');
                }
                if (errors.no_hp) {
                    $('#nohp_error').text(errors.no_hp);
                    $('#no_hp').addClass('is-invalid');
                }
                if (errors.alamat) {
                    $('#alamat_error').text(errors.alamat);
                    $('#alamat').addClass('is-invalid');
                }
            }
        });
    });
});