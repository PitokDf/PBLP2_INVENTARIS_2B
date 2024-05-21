$(document).ready(function () {
    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // });

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
            {
                "data": null,
                "render": function (data, type, row) {
                    function formatTanggal(input) {
                        const date = new Date(input);
                        const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

                        const day = date.getDate();
                        const month = months[date.getMonth()];
                        const year = date.getFullYear();

                        return `${day}/${month}/${year}`;
                    }

                    // Asumsikan 'data' adalah tanggal dalam format ISO
                    const formattedDate = formatTanggal(data.created_at);
                    return formattedDate;
                },
                "orderable": true
            },
            {
                "data": null,
                "render": function (_data, _type, row) {
                    return "<button type='button' data-id='" + row.id + "' class='btn btn-sm btn-danger' id='btn-hapus'><i class='fas a-solid fa-trash'></i></button> <button class='btn btn-sm btn-warning' id='btn-edit' data-id='" + row.id + "'><i class='fas fa-regular fa-pen'></i></button>"
                }
                , "orderable": false
            }
        ]
    });

    var url = "";
    var modal = $('#modalBarangM');
    var modal_title = $('.modal-title');
    var btnAction = $('.action');

    // fungsi untuk membersihkan pesan error
    function clearErrorMsg() {
        $('#barang_error').text('');
        $('#pemasok_error').text('');
        $('#barang').removeClass('is-invalid');
        $('#pemasok').removeClass('is-invalid');
    }

    function clearInput() {
        $('#barang').val('');
        $('#pemasok').val('');
    }

    // saat tombol edit di click maka akan mengambil data sesaui id
    $(document).on('click', '#btn-edit', function () {
        clearErrorMsg();
        modal.modal('show');
        modal_title.text('Edit Barang Masuk');
        btnAction.attr('id', 'btnEdit');
        btnAction.html("<i class='fas fa-regular fa-pen'></i> Update");
        url = "/barangM/" + $(this).data('id') + "/edit";

        $.ajax({
            type: "GET",
            url: url, // Menggunakan variabel 'url' yang sudah didefinisikan sebelumnya
            dataType: "json",
            success: function (response) {
                console.log(response)
                var data = response.data;
                $('#id').val(data.id);
                $('#barangM').val(data.barang_id);
                $('#pemasok').val(data.pemasok);
                $('#quantity').val(data.quantity);
            },
            error: function (xhr, status, error) {
                console.error(xhr + "\n" + status + "\n" + error)
            }
        });
    });

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