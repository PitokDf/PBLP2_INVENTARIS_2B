import { reloadTable } from "./reloadTable";

$(document).ready(function () {
    $('#table_kategoriB').DataTable({
        "processing": true,
        "paging": true,
        "searching": true,
        "responsive": true,
        "language": {
            "search": "cari"
        },
        "ajax": {
            "url": "getKategori", // Ganti dengan URL endpoint Anda
            "type": "GET"
        },
        "columns": [
            {
                "data": null,
                "render": function (_data, _type, _row, meta) {
                    return meta.row + 1; // Nomor urut otomatis berdasarkan posisi baris
                }
            },
            { "data": "nama_kategori_barang", "orderable": true },
            {
                "data": null,
                "render": function (_data, _type, row) {
                    return "<button type='button' data-id='" + row.id + "' class='btn btn-sm btn-danger btnDelete'><i class='fas a-solid fa-trash'></i></button> <button class='btn btn-sm btn-warning btnEdit' id='" + row.id + "'><i class='fas fa-regular fa-pen'></i></button>"
                }
                , "orderable": false
            }
        ]
    });

    var url = "";

    function clearErrorMsg() {
        $('#name_error').text('');
        $('#name_kategori').removeClass('is-invalid');
    }

    function clerInput(modal) {
        $("#" + modal + " input").val('');
    }

    function showModal(modal, title, form, icon) {
        $("#" + modal).modal('show');
        $('.modal-title').text(title);
        $('.action').attr('id', form);
        $('.action').html(icon);
    }

    $('#btnCreate').click(function () {
        var modal = "modal-kategori";
        if ($('.action').attr('id') != 'btnCreateform') {
            clerInput(modal);
        }
        clearErrorMsg();
        showModal(modal, "Add Kategori Barang", "btnCreateform", "<i class='fas fa-save'></i> Simpan");
    });

    // proses yang akan menangani proses create data dan mengembalikan error saat terjadi error
    $(document).on('click', '#btnCreateform', function () {
        var formData = new FormData(document.getElementById('form'));
        url = "kategori-barang";
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                if (response.status == 200) {
                    clerInput("modal-kategori");
                    clearErrorMsg();
                    reloadTable(table_kategoriB);
                    $('#modal-kategori').modal('hide');
                    Swal.fire({
                        title: "Insert!",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "Yes"
                    });
                }
            },
            error: function (xhr) {
                var errorMessage = xhr.responseJSON.errors;
                clearErrorMsg();
                $('#name_kategori').addClass('is-invalid');
                $('#name_error').text(errorMessage.name_kategori);
            }
        });
    });

    // saat btn edit diclick maka akan melakakuan request ke server dengan mengirimkan id dan server akan mengembalikan data yang sesuai dengan id yang dikirimkan
    $(document).on('click', '.btnEdit', function () {
        clearErrorMsg();
        showModal("modal-kategori", "Edit Kategori", "btnEditform", "<i class='fas fa-regular fa-pen'></i> Update");
        url = "kategori-barang/" + $(this).attr('id') + "/edit";
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function (response) {
                $('#id').val(response.data[0].id);
                $('#name_kategori').val(response.data[0].nama_kategori_barang);
            },
            error: function (xhr) {
                var errorMessage = xhr.responseJSON.errors;
            }
        });
    });

    // proses update data
    $(document).on('click', '#btnEditform', function () {
        var formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('name_kategori', $('#name_kategori').val());
        var id = $('#id').val();
        url = "kategori-barang/" + id;

        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                if (response.status == 200) {
                    clerInput("modal-kategori");
                    clearErrorMsg();
                    reloadTable(table_kategoriB);
                    $('#modal-kategori').modal('hide');
                    Swal.fire({
                        title: "Updated!",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "Yes"
                    });
                }
            },
            error: function (xhr) {
                console.error(xhr.responseJSON)
                var errorMessage = xhr.responseJSON.errors;
                $('#name_kategori').addClass('is-invalid');
                $('#name_error').text(errorMessage.name_kategori);
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
                var url = 'kategori-barang/' + $(this).data('id');
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
                        reloadTable(table_kategoriB);
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