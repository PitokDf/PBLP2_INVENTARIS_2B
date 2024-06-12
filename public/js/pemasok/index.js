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
                    return "<button type='button' data-id='" + row.id + "' class='btn btn-sm btn-danger' id='btn-hapus'><i class='fas a-solid fa-trash'></i></button> <button class='btn btn-sm btn-info' id='btn-detail' data-id='" + row.id + "'><i class='fas fa-regular fa-info-circle'></i></button>"
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
                        setInterval(() => {
                            location.reload();
                        }, 1000);
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
});