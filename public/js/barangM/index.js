$(document).ready(function () {

    $('#tableBarangM').DataTable({
        "processing": true,
        "paging": true,
        "searching": true,
        "responsive": true,
        "language": {
            "search": "cari"
        },
        "ajax": {
            "url": "/getDataBarangMasuk", // Ganti dengan URL endpoint Anda
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
                    return data.barang.nama_barang
                },
                "orderable": true
            },
            { "data": "pemasok", "orderable": true },
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

    // fungsi untuk membersihkan pesan error
    function clearErrorMsg() {
        $('#barang_error').text('');
        $('#quantity_error').text('');
        $('#pemasok_error').text('');
        $('#keterangan_error').text('');
        $('#barangM').removeClass('is-invalid');
        $('#quantity').removeClass('is-invalid');
        $('#keterangan').removeClass('is-invalid');
        $('#pemasok').removeClass('is-invalid');
    }

    function clearInput() {
        $('#barangM').val('');
        $('#quantity').val('');
        $('#keterangan').val('');
        $('#pemasok').val('');
    }

    // menangani proses store barang masuk
    $('#simpan').on('click', function () {
        var data = new FormData();
        data.append('barang', $('#barangM').val());
        data.append('quantity', $('#quantity').val());
        data.append('pemasok', $('#pemasok').val());
        data.append('keterangan', $('#keterangan').val());

        $.ajax({
            type: "POST",
            url: "/barangM",
            data: data,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                if (response.status === 200) {
                    clearInput();
                    clearErrorMsg();
                    reloadTable(tableBarangM);
                    Swal.fire({
                        title: "Created!",
                        text: response.message,
                        icon: "success"
                    });
                }
            },
            error: function (xhr) {
                console.info(xhr);
                const errors = xhr.responseJSON.errors;
                clearErrorMsg();
                if (errors.barang) {
                    $('#barang_error').text(errors.barang);
                    $('#barangM').addClass('is-invalid');
                }
                if (errors.quantity) {
                    $('#quantity_error').text(errors.quantity);
                    $('#quantity').addClass('is-invalid');
                }
                if (errors.keterangan) {
                    $('#keterangan_error').text(errors.keterangan);
                    $('#keterangan').addClass('is-invalid');
                }
                if (errors.pemasok) {
                    $('#pemasok_error').text(errors.pemasok);
                    $('#pemasok').addClass('is-invalid');
                }
                console.info(errors)
            }
        });
    });


    var url = "";
    var modal = $('#modalDetail');
    var modal_title = $('.modal-title');
    var btnAction = $('.action');

    // show detail
    $(document).on('click', '#btn-detail', function () {
        modal.modal('show');
        $.ajax({
            type: "GET",
            url: "/barangM/" + $(this).data('id'),
            dataType: "json",
            success: function (response) {
                console.info(response)
                if (response.status === 200) {
                    const data = response.data;
                    $('#txt_kode_barang').text(data.barang.code_barang);
                    $('#txt_namaBarang').text(data.barang.nama_barang);
                    $('#txt_quantity').text(data.quantity);
                    $('#txt_pemasok').text(data.pemasok);
                    $('#txt_tgl_masuk').text(dateCutomFormat(data.created_at));
                }
            }
        });
    });
    // saat tombol edit di click maka akan mengambil data sesaui id
    // $(document).on('click', '#btn-edit', function () {
    //     clearErrorMsg();
    //     modal.modal('show');
    //     modal_title.text('Edit Barang Masuk');
    //     btnAction.attr('id', 'btnEdit');
    //     btnAction.html("<i class='fas fa-regular fa-pen'></i> Update");
    //     url = "/barangM/" + $(this).data('id') + "/edit";

    //     $.ajax({
    //         type: "GET",
    //         url: url, // Menggunakan variabel 'url' yang sudah didefinisikan sebelumnya
    //         dataType: "json",
    //         success: function (response) {
    //             console.log(response)
    //             var data = response.data;
    //             $('#id').val(data.id);
    //             $('#barangM').val(data.barang_id);
    //             $('#pemasok').val(data.pemasok);
    //             $('#quantity').val(data.quantity);
    //         },
    //         error: function (xhr, status, error) {
    //             console.error(xhr + "\n" + status + "\n" + error)
    //         }
    //     });
    // });

    // menangani proses delete data
    $(document).on('click', '#btn-hapus', function () {
        Swal.fire({
            title: "Yakin ingin menghapus?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes"
        }).then((result) => {
            if (result.isConfirmed) {
                var url = '/barangM/' + $(this).data('id');
                var data = { "_method": "DELETE" };
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        console.log(response)
                        reloadTable(tableBarangM);
                        Swal.fire({
                            title: "Deleted!",
                            text: response.message,
                            icon: "success"
                        });
                    },
                    error: function (xhr, stattus, error) {
                        console.error(xhr + "\n" + stattus + "\n" + error)
                    }
                });
            }
        });
    });

    // menampilkan modal form saat btn create di click
    $('#btnCreate').click(function () {
        modal.modal('show');
        modal_title.text('Form Barang Masuk');
        btnAction.html("<i class='fas fa-save'></i> Simpan");
        $('#name_error').text('');
        if (btnAction.attr('id') != "btnCreateform") {
            clearErrorMsg();
            $('#modalBarangM input').val('');
        }
        btnAction.attr('id', 'btnCreateform');
    });

    // menangani proses create data
    $(document).on('click', '#btnCreateform', function () {
        var formData = new FormData();
        formData.append('barang', $('#barang').val());
        formData.append('pemasok', $('#pemasok').val());
        $.ajax({
            type: "POST",
            url: "/barangM",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                if (response.status == 200) {
                    reloadTable(tableBarangM);
                    modal.modal('hide');
                    clearInput();
                    clearErrorMsg();
                    Swal.fire({
                        title: "Insert!",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "Yes"
                    });
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr)
                clearErrorMsg();
                var data = xhr.responseJSON.errors;
                if (data.barang) {
                    $('#barang_error').text(data.barang);
                    $('#barang').addClass('is-invalid');
                }
                if (data.pemasok) {
                    $('#pemasok_error').text(data.pemasok);
                    $('#pemasok_barang').addClass('is-invalid');
                }
            }
        });
    });

    // menangani proses edit data
    $(document).on('click', '#btnEdit', function () {
        var data = new FormData();
        data.append('_method', "PUT")
        data.append('pemasok', $('#pemasok').val());
        data.append('barang', $('#barangM').val());
        data.append('quantity', $('#quantity').val());
        var id = $('#id').val();
        var url = "/barangM/" + id;
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                if (response.status == 200) {
                    reloadTable(tableBarangM);
                    clearInput();
                    clearErrorMsg();
                    modal.modal('hide');
                    Swal.fire({
                        title: "Update!",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "Yes"
                    });
                }
            },
            error: function (xhr, status, error) {
                clearErrorMsg();
                console.log(xhr)
                var data = xhr.responseJSON.errors;
                if (data.pemasok) {
                    $('#pemasok_error').text(data.pemasok);
                    $('#pemasok').addClass('is-invalid');
                }
                if (data.barang) {
                    $('#barang_error').text(data.barang);
                    $('#barangM').addClass('is-invalid');
                }
            }
        });
    });
});