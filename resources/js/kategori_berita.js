import { reloadTable } from "./reloadTable";
$(document).ready(function () {
    $('#table_kategori').DataTable({
        "processing": true,
        "paging": true,
        "searching": true,
        "responsive": true,
        "language": {
            "search": "cari"
        },
        "ajax": {
            "url": "getAllDataKategori", // Ganti dengan URL endpoint Anda
            "type": "GET"
        },
        "columns": [
            {
                "data": null,
                "render": function (_data, _type, _row, meta) {
                    return meta.row + 1; // Nomor urut otomatis berdasarkan posisi baris
                }
            },
            { "data": "nama_kategori", "orderable": true },
            {
                "data": null,
                "render": function (_data, _type, row) {
                    return "<button type='button' data-id='" + row.id + "' class='btn btn-sm btn-danger btnDelete'><i class='fas a-solid fa-trash'></i></button> <button class='btn btn-sm btn-warning btnEdit' data-id='" + row.id + "'><i class='fas fa-regular fa-pen'></i></button>"
                }
                , "orderable": false
            }
        ]
    });


    var url = "";
    var modal = $('#modal-kategori');
    var modal_title = $('.modal-title');
    var btnAction = $('.action');

    // saat tombol edit di click maka akan mengambil data sesaui id
    $(document).on('click', '.btnEdit', function () {
        modal.modal('show');
        modal_title.text('Edit Kategori');
        btnAction.attr('id', 'btnEdit');
        $('#name_kategori').removeClass('is-invalid');
        $('#name_error').text('');
        btnAction.html("<i class='fas fa-regular fa-pen'></i> Update");
        url = "/kategori-berita/" + $(this).data('id') + "/edit";

        $.ajax({
            type: "GET",
            url: url, // Menggunakan variabel 'url' yang sudah didefinisikan sebelumnya
            dataType: "json",
            success: function (response) {
                var data = response.data[0];
                $('#name_kategori').val(data.nama_kategori);
                $('#id').val(data.id);
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
                var url = 'kategori-berita/' + $(this).data('id');
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
                        reloadTable(table_kategori);
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
        // Your create button logic here
        $('#name_kategori').removeClass('is-invalid');
        modal.modal('show');
        modal_title.text('Add Kategori');
        btnAction.html("<i class='fas fa-save'></i> Simpan");
        $('#name_error').text('');
        if (btnAction.attr('id') != "btnCreateform") {
            $('#modal-kategori input').val('');
        }
        btnAction.attr('id', 'btnCreateform');
    });

    // menangani proses create data
    $(document).on('click', '#btnCreateform', function () {
        var formData = $('#form').serialize();
        $.ajax({
            type: "POST",
            url: "kategori-berita",
            data: formData,
            dataType: "json",
            success: function (response) {
                if (response.status == 200) {
                    modal.modal('hide');
                    Swal.fire({
                        title: "Insert!",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "Yes"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#name_error').text('');
                            $('#name_kategori').val('');
                            reloadTable(table_kategori);
                        }
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseJSON.errors)
                $('#name_error').text(xhr.responseJSON.errors.name_kategori);
                $('#name_kategori').addClass('is-invalid');
            }
        });
    });

    // menangani proses edit data
    $(document).on('click', '#btnEdit', function () {
        var formData = $('#form').serialize();
        var id = $('#id').val();
        var url = "kategori-berita/" + id;
        $.ajax({
            type: "PUT",
            url: url,
            data: formData,
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
                            $('#name_error').text('');
                            reloadTable(table_kategori);
                        }
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseJSON.errors)
                $('#name_kategori').addClass('is-invalid');
                $('#name_error').text(xhr.responseJSON.errors.name_kategori);
            }
        });
    });
});