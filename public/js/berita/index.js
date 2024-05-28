
$(document).ready(function () {
    var kategoriList = "";
    $.ajax({
        url: "getAllDataKategori", // URL endpoint untuk mengambil data kategori
        type: "GET",
        success: function (response) {
            // Handle successful response
            kategoriList = response.data;

            // Populate the dropdown list with kategori options
            $.each(kategoriList, function (index, kategori) {
                $("#kategori").append(
                    "<option value='" + kategori.id + "'>" + kategori.nama_kategori + "</option>"
                );
            });
        },
        error: function (error) {
            // Handle error response
            console.error("Error retrieving kategori:", error);
        }
    });
    $('#table_berita').DataTable({
        "processing": true,
        "paging": true,
        "searching": true,
        "responsive": true,
        "language": {
            "search": "cari"
        },
        "ajax": {
            "url": "getBerita", // Ganti dengan URL endpoint Anda
            "type": "GET"
        },
        "columns": [
            {
                "data": null,
                "render": function (_data, _type, _row, meta) {
                    return meta.row + 1; // Nomor urut otomatis berdasarkan posisi baris
                }
            },
            { "data": "title", "orderable": true },
            {
                "data": null,
                "render": function (_data, _type, row) {
                    return dateCutomFormat(row.tgl_publikasi);
                },
                "orderable": true
            },
            {
                "data": null,
                "render": function (_data, _type, row) {
                    return row.kategori.nama_kategori
                },
                "orderable": true
            },
            {
                "data": null,
                "render": function (_data, _type, row) {
                    return "<button type='button' data-id='" + row.id_berita + "' class='btn btn-sm btn-danger btnDelete'><i class='fas a-solid fa-trash'></i></button> <button class='btn btn-sm btn-warning btnEdit' id='" + row.id_berita + "'><i class='fas fa-regular fa-pen'></i></button>"
                }
                , "orderable": false
            }
        ]
    });


    var url = "";
    var modal = $('#modal-kategori');
    var modal_title = $('.modal-title');
    var btnAction = $('.action');

    function clearErrorMsg() {
        $('#title_error').text('');
        $('#publikasi_error').text('');
        $('#kategori_error').text('');
        $('#content_error').text('');
        $('#title').removeClass('is-invalid');
        $('#content').removeClass('is-invalid');
        $('#kategori').removeClass('is-invalid');
        $('#publikasi').removeClass('is-invalid');
    }
    function claerInput() {
        $('#title').val('');
        $('trix-editor').html('');
        $('#kategori').val('');
        $('#publikasi').val('');
    }

    // saat tombol edit di click maka akan mengambil data sesaui id
    $(document).on('click', '.btnEdit', function () {
        modal.modal('show');
        modal_title.text('Edit Kategori');
        btnAction.attr('id', 'btnEdit');
        btnAction.html("<i class='fas fa-regular fa-pen'></i> Update");
        url = "berita/" + $(this).attr('id') + "/edit";

        $.ajax({
            type: "GET",
            url: url, // Menggunakan variabel 'url' yang sudah didefinisikan sebelumnya
            dataType: "json",
            success: function (response) {
                var data = response.data;
                $('#id').val(data.id_berita);
                $('#title').val(data.title);
                $('trix-editor').html(data.content);
                $('#kategori').val(data.kategori_id);
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
                var url = 'berita/' + $(this).data('id');
                var data = { "_method": "DELETE" };
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        Swal.fire({
                            title: "Deleted!",
                            text: response.message,
                            icon: "success"
                        });
                        reloadTable(table_berita);
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
        // Your create button logic here
        modal.modal('show');
        modal_title.text('Add Berita');
        btnAction.html("<i class='fas fa-save'></i> Simpan");
        $('#name_error').text('');
        if (btnAction.attr('id') != "btnCreateform") {
            clearErrorMsg();
            claerInput();
        }
        btnAction.attr('id', 'btnCreateform');
    });

    // menangani proses create data
    $(document).on('click', '#btnCreateform', function () {
        var data = new FormData();
        data.append('title', $('#title').val());
        data.append('content', $('#content').val());
        data.append('kategori', $('#kategori').val());
        $.ajax({
            type: "POST",
            url: "berita",
            data: data,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                console.log(response)
                if (response.status == 200) {
                    modal.modal('hide');
                    Swal.fire({
                        title: "Insert!",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "Yes"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            reloadTable(table_berita);
                            claerInput();
                        }
                    });
                }
            },
            error: function (xhr, status, error) {
                console.info(xhr)
                console.error(xhr.responseJSON.errors)
                const errors = xhr.responseJSON.errors;
                clearErrorMsg();
                if (errors.title) {
                    $('#title_error').text(errors.title);
                    $('#title').addClass('is-invalid');
                }
                $('#content_error').text(errors.content);
                if (errors.kategori) {
                    $('#kategori_error').text(errors.kategori);
                    $('#kategori').addClass('is-invalid');
                }
                if (errors.publikasi) {
                    $('#publikasi_error').text(errors.publikasi);
                    $('#publikasi').addClass('is-invalid');
                }
            }
        });
    });

    // menangani proses edit data
    $(document).on('click', '#btnEdit', function () {
        var data = new FormData();
        data.append('_method', "PUT")
        data.append('title', $('#title').val());
        data.append('content', $('#content').val());
        data.append('kategori', $('#kategori').val());
        data.append('publikasi', $('#publikasi').val());
        var id = $('#id').val();
        var url = "berita/" + id;
        console.log($('#content').val() + $('#title').val())
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                if (response.status == 200) {
                    modal.modal('hide');
                    Swal.fire({
                        title: "Update!",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "Yes"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            claerInput();
                            console.log(response.data)
                            reloadTable(table_berita);
                        }
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseJSON.errors);
                const errors = xhr.responseJSON.errors;
                clearErrorMsg();
                if (errors.title) {
                    $('#title_error').text(errors.title);
                    $('#title').addClass('is-invalid');
                }
                $('#content_error').text(errors.content);
                if (errors.kategori) {
                    $('#kategori_error').text(errors.kategori);
                    $('#kategori').addClass('is-invalid');
                }
                if (errors.publikasi) {
                    $('#publikasi_error').text(errors.publikasi);
                    $('#publikasi').addClass('is-invalid');
                }
            }
        });
    });
});