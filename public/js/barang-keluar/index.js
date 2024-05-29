$(document).ready(function () {
    $('#tableBarangKeluar').DataTable({
        "processing": true,
        "paging": true,
        "searching": true,
        "responsive": true,
        "language": {
            "search": "cari"
        },
        "ajax": {
            "url": "/getDatabarangKeluar", // Ganti dengan URL endpoint Anda
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
                "data": null,
                "render": function (data, type, row) {
                    return data.barang.nama_barang;
                },
                "orderable": true
            },
            {
                "data": null,
                "render": function (_data, _type, row) {
                    return dateCutomFormat(row.tgl_keluar);
                },
                "orderable": true
            },
            { "data": "quantity", "orderable": true },
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
        $('#barang_error').text('');
        $('#quantity_error').text('');
        $('#barangM').removeClass('is-invalid');
        $('#quantity').removeClass('is-invalid');
    }

    function clearInput() {
        $('#barangM').val('');
        $('#quantity').val('');
    }

    $('#simpan').on('click', function () {
        var data = new FormData();

        data.append('barang', $('#barangM').val());
        data.append('quantity', $('#quantity').val());

        $.ajax({
            type: "POST",
            url: "/barang-keluar",
            data: data,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                if (response.status == 200) {
                    clearErrorMsg();
                    clearInput();
                    reloadTable(tableBarangKeluar);
                    Swal.fire({
                        title: "Created!",
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
            },
            error: function (xhr) {
                console.log(xhr)
                var errorMessage = xhr.responseJSON.errors;
                clearErrorMsg();
                if (errorMessage.barang) {
                    $('#barang_error').text(errorMessage.barang);
                    $('#barangM').addClass('is-invalid');
                }
                if (errorMessage.quantity) {
                    $('#quantity_error').text(errorMessage.quantity);
                    $('#quantity').addClass('is-invalid');
                }
            }
        });
    });


    $(document).on('click', '#btn-detail', function () {
        $('#modalDetail').modal('show');
        $.ajax({
            type: "GET",
            url: "/barang-keluar/" + $(this).data('id'),
            dataType: "json",
            success: function (response) {
                console.log(response)
                if (response.status == 200) {
                    const data = response.data;
                    $('#txt_kode_barang').text(data.barang.code_barang);
                    $('#txt_namaBarang').text(data.barang.nama_barang);
                    $('#txt_quantity').text(data.quantity);
                    $('#txt_tgl_keluar').text(dateCutomFormat(data.tgl_keluar));
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
                    url: "/barang-keluar/" + $(this).data('id'),
                    processData: false,
                    contentType: false,
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == 200) {
                            reloadTable(tableBarangKeluar);
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