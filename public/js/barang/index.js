$(document).ready(function () {
    var kategoriList = "";
    // mendapatkan kategori barang dari server
    $.ajax({
        url: "getKategori", // URL endpoint untuk mengambil data kategori
        type: "GET",
        success: function (response) {
            // Handle successful response
            kategoriList = response.data;

            // Populate the dropdown list with kategori options
            $.each(kategoriList, function (index, kategori) {
                $("#kategori").append(
                    "<option value='" + kategori.id + "'>" + kategori.nama_kategori_barang + "</option>"
                );
            });
        },
        error: function (error) {
            // Handle error response
            console.error("Error retrieving kategori:", error);
        }
    });

    $('#table_barang').DataTable({
        "processing": true,
        "paging": true,
        "searching": true,
        "responsive": true,
        "language": {
            "search": "cari"
        },
        "ajax": {
            "url": "getAllDataBarang", // Ganti dengan URL endpoint Anda
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
            { "data": "code_barang", "orderable": true },
            { "data": "nama_barang", "orderable": true },
            {
                "data": null,
                render: function (_data, _type, row) {
                    return row.kategori.nama_kategori_barang
                },
                "orderable": true
            },
            // {
            //     "data": null, "render":
            //         function (_data, _type, row) {
            //             const kategori = kategoriList.find(item => item.id === row.id_kategory);
            //             return kategori ? kategori.nama_kategori_barang : "";
            //         }
            //     , "orderable": true
            // },
            { "data": "quantity", "orderable": false },
            { "data": "posisi", "orderable": false },
            {
                "data": null,
                "render": function (_data, _type, row) {
                    return "<button type='button' data-id='" + row.id_barang + "' class='btn btn-sm btn-danger btnDelete'><i class='fas a-solid fa-trash'></i></button> <button class='btn btn-sm btn-warning btnEdit' id='" + row.id_barang + "'><i class='fas fa-regular fa-pen'></i></button>"
                }
                , "orderable": false
            }
        ]
    });


    var url = "";
    var modal = $('#modal-kategori');
    var modal_title = $('.modal-title');
    var btnAction = $('.action');

    // fungsi untuk membersihkan pesan error
    function clearErrorMsg() {
        $('#kode_error').text('');
        $('#nama_error').text('');
        $('#kategori_error').text('');
        $('#jumlah_error').text('');
        $('#posisi_error').text('');
        $('#foto_error').text('');
        $('#kode_barang').removeClass('is-invalid');
        $('#nama_barang').removeClass('is-invalid');
        $('#kategori').removeClass('is-invalid');
        $('#jumlah').removeClass('is-invalid');
        $('#posisi').removeClass('is-invalid');
        $('#foto').removeClass('is-invalid');
    }
    function claerInput() {
        $('#kode_barang').val('');
        $('#nama_barang').val('');
        $('#kategori').val(1).trigger('change');
        $('#jumlah').val('');
        $('#posisi').val('');
        $('#foto').val('');
    }

    // saat tombol edit di click maka akan mengambil data sesaui id
    $(document).on('click', '.btnEdit', function () {
        clearErrorMsg();
        modal.modal('show');
        modal_title.text('Edit Barang');
        btnAction.attr('id', 'btnEdit');
        btnAction.html("<i class='fas fa-regular fa-pen'></i> Update");
        url = "barang/" + $(this).attr('id') + "/edit";

        $.ajax({
            type: "GET",
            url: url, // Menggunakan variabel 'url' yang sudah didefinisikan sebelumnya
            dataType: "json",
            success: function (response) {
                var data = response.data[0];
                $('#id').val(data.id_barang);
                $('#kode_barang').val(data.code_barang);
                $('#nama_barang').val(data.nama_barang);
                $('#kategori').val(data.id_kategory);
                $('#jumlah').val(data.quantity);
                $('#posisi').val(data.posisi);
            },
            error: function (xhr, status, error) {
                console.error(xhr + "\n" + status + "\n" + error)
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
                var url = 'barang/' + $(this).data('id');
                var data = { "_method": "DELETE" };
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        reloadTable(table_barang);
                        Swal.fire({
                            title: "Deleted!",
                            text: response.message,
                            icon: "success"
                        });
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

    // menampilkan modal form saat btn create di click
    $('#btnCreate').click(function () {
        modal.modal('show');
        modal_title.text('Add Barang');
        btnAction.html("<i class='fas fa-save'></i> Simpan");
        $('#name_error').text('');
        if (btnAction.attr('id') != "btnCreateform") {
            clearErrorMsg();
            $('#modal-kategori input').val('');
        }
        btnAction.attr('id', 'btnCreateform');
    });

    // menangani proses create data
    $(document).on('click', '#btnCreateform', function () {
        var formData = new FormData();
        if ($('#foto')[0].files.length > 0) {
            formData.append('foto', $('#foto')[0].files[0]);
        }
        formData.append('jumlah', $('#jumlah').val());
        formData.append('kategori', $('#kategori').val());
        formData.append('kode_barang', $('#kode_barang').val());
        formData.append('nama_barang', $('#nama_barang').val());
        formData.append('posisi', $('#posisi').val());
        $.ajax({
            type: "POST",
            url: "barang",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                if (response.status == 200) {
                    reloadTable(table_barang);
                    modal.modal('hide');
                    claerInput();
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
                clearErrorMsg();
                var data = xhr.responseJSON.errors;
                if (data.kode_barang) {
                    $('#kode_error').text(data.kode_barang);
                    $('#kode_barang').addClass('is-invalid');
                }
                if (data.nama_barang) {
                    $('#nama_error').text(data.nama_barang);
                    $('#nama_barang').addClass('is-invalid');
                }
                if (data.kategori) {
                    $('#kategori_error').text(data.kategori);
                    $('#kategori').addClass('is-invalid');
                }
                if (data.jumlah) {
                    $('#jumlah_error').text(data.jumlah);
                    $('#jumlah').addClass('is-invalid');
                } if (data.posisi) {
                    $('#posisi_error').text(data.posisi);
                    $('#posisi').addClass('is-invalid');
                }
                if (data.foto) {
                    $('#foto_error').text(data.foto);
                    $('#foto').addClass('is-invalid');
                }
            }
        });
    });

    // menangani proses edit data
    $(document).on('click', '#btnEdit', function () {
        var data = new FormData();
        data.append('_method', "PUT")
        if ($('#foto')[0].files.length > 0) {
            data.append('foto', $('#foto')[0].files[0]);
        }
        data.append('jumlah', $('#jumlah').val());
        data.append('kategori', $('#kategori').val());
        data.append('kode_barang', $('#kode_barang').val());
        data.append('nama_barang', $('#nama_barang').val());
        data.append('posisi', $('#posisi').val());
        var id = $('#id').val();
        var url = "barang/" + id;
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                if (response.status == 200) {
                    reloadTable(table_barang);
                    claerInput();
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
                var data = xhr.responseJSON.errors;
                if (data.kode_barang) {
                    $('#kode_error').text(data.kode_barang);
                    $('#kode_barang').addClass('is-invalid');
                }
                if (data.nama_barang) {
                    $('#nama_error').text(data.nama_barang);
                    $('#nama_barang').addClass('is-invalid');
                }
                if (data.kategori) {
                    $('#kategori_error').text(data.kategori);
                    $('#kategori').addClass('is-invalid');
                }
                if (data.jumlah) {
                    $('#jumlah_error').text(data.jumlah);
                    $('#jumlah').addClass('is-invalid');
                } if (data.posisi) {
                    $('#posisi_error').text(data.posisi);
                    $('#posisi').addClass('is-invalid');
                }
                if (data.foto) {
                    $('#foto_error').text(data.foto);
                    $('#foto').addClass('is-invalid');
                }
            }
        });
    });
});