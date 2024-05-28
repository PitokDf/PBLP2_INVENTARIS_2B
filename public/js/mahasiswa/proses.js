$(document).ready(function () {
    $('#table_mahasiswa').DataTable({
        "processing": true,
        "paging": true,
        "searching": true,
        "responsive": true,
        "language": {
            "search": "cari"
        },
        "ajax": {
            "url": "getAllDataMahasiswa", // Ganti dengan URL endpoint Anda
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
            { "data": "nama", "orderable": true },
            {
                "data": "code_prodi", "orderable": true
            },
            {
                "data": null,
                "render": function (_data, _type, row) {
                    return "<button type='button' data-id='" + row.id_mahasiswa + "' class='btn btn-sm btn-danger btnDelete'><i class='fas a-solid fa-trash'></i></button> <button class='btn btn-sm btn-warning btnEdit' id='" + row.id_mahasiswa + "'><i class='fas fa-regular fa-pen'></i></button> <button class='btn btn-sm btn-info btnDetail' id='" + row.id_mahasiswa + "'><i class='fas fa-info-circle'></i></button>"
                }
                , "orderable": false
            }
        ]
    });

    function clearErrorMsg() {
        $('#nama_error').text('');
        $('#nim_error').text('');
        $('#prodi_error').text('');
        $('#angkatan_error').text('');
        $('#ipk_error').text('');
    }

    var time = new Date();
    var year = time.getFullYear();
    function clerInput(modal) {
        $('.role').css('display', 'block')
        $("#" + modal + " input").val('');
        $('#prodi').val($('#prodi option:first').val());
        $('#angkatan').val(year);
    }

    function showModal(modal, title, form, icon) {
        $("#" + modal).modal('show');
        $('.modal-title').text(title);
        $('.action').attr('id', form);
        $('.action').html(icon);
    }

    $('#btnCreate').click(function () {
        var modal = "modal";
        clearErrorMsg();
        if ($('.action').attr('id') != 'btnCreateform') {
            clerInput(modal);
        }
        showModal(modal, title = "Add Data Mahasiswa", form = "btnCreateform", icon = "<i class='fas fa-save'></i> Simpan");
    });

    $(document).on('click', '#btnCreateform', function () {
        console.log('tombol create pada form diclick');
        var data = new FormData();
        data.append('nama_mahasiswa', $('#nama_mahasiswa').val());
        data.append('angkatan', $('#angkatan').val());
        data.append('nim', $('#nim').val());
        data.append('prodi', $('#prodi').val());
        data.append('angkatan', $('#angkatan').val());
        data.append('ipk', $('#ipk').val());
        $.ajax({
            type: "post",
            url: "mahasiswa",
            data: data,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                if (response.status == 200) {
                    clerInput(modal = "modal");
                    clearErrorMsg();
                    reloadTable(table_mahasiswa);
                    $('#modal').modal('hide');
                    Swal.fire({
                        title: "Insert!",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "Yes"
                    });
                }
            },
            error: function (xhr) {
                console.info(xhr)
                var errorMessage = xhr.responseJSON.errors;
                clearErrorMsg();
                $('#nama_error').text(errorMessage.nama_mahasiswa);
                $('#nim_error').text(errorMessage.nim);
                $('#prodi_error').text(errorMessage.prodi);
                $('#angkatan_error').text(errorMessage.angkatan);
                $('#ipk_error').text(errorMessage.ipk);
            }
        });
    });

    // menangani proses delete
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
                var url = 'mahasiswa/' + $(this).data('id');
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
                        reloadTable(table_mahasiswa);
                    },
                    error: function (xhr, stattus, error) {
                        console.log(xhr)
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

    // mengambil data mahasiswa dari server berdasarkan id yang dikirmkan ke server
    $(document).on('click', '.btnEdit', function () {
        clearErrorMsg();
        showModal(modal = "modal", title = "Edit Data Mahasiswa", form = "btnEditForm", icon = "<i class='fas fa-regular fa-pen'></i> Update");
        var url = "mahasiswa/" + $(this).attr('id') + "/edit";
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function (response) {
                if (response.status == 200) {
                    var data = response.data[0];
                    $('#id').val(data.id_mahasiswa);
                    $('#nama_mahasiswa').val(data.nama);
                    $('#nim').val(data.nim);
                    $('#prodi').val(data.code_prodi);
                    $('#angkatan').val(data.angkatan);
                    $('#ipk').val(data.ipk);
                }
            },
            error: function (xhr) {
                console.log(xhr)
            }
        });
    });

    // menangani proses edit
    $(document).on('click', '#btnEditForm', function () {
        var data = new FormData(); // membuat object dari formData
        data.append('_method', 'PUT'); // menambahakan key method ke data
        data.append('nama_mahasiswa', $('#nama_mahasiswa').val());
        data.append('nim', $('#nim').val());
        data.append('prodi', $('#prodi').val());
        data.append('angkatan', $('#angkatan').val());
        data.append('ipk', $('#ipk').val());
        var id = $('#id').val();
        url = "mahasiswa/" + id;

        $.ajax({
            type: "POST",
            url: url,
            data: data,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                if (response.status == 200) {
                    clerInput(modal = "modal");
                    clearErrorMsg();
                    reloadTable(table_mahasiswa);
                    $('#modal').modal('hide');
                    Swal.fire({
                        title: "Updated!",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "Yes"
                    });
                }
            },
            error: function (xhr) {
                console.log(xhr)
                var errorMessage = xhr.responseJSON.errors;
                clearErrorMsg();
                $('#nama_error').text(errorMessage.nama_mahasiswa);
                $('#nim_error').text(errorMessage.nim);
                $('#prodi_error').text(errorMessage.prodi);
                $('#angkatan_error').text(errorMessage.angkatan);
                $('#ipk_error').text(errorMessage.ipk);
            }
        });
    });

    $(document).on('click', '.btnDetail', function () {
        showModal(modal = "modalDetail", title = "Detail Mahasiswa", form = "", icon = "");
        var url = "mahasiswa/" + $(this).attr('id') + "/edit";
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function (response) {
                if (response.status == 200) {
                    var data = response.data[0];
                    console.log(data);
                    $('.nim').text(data.nim);
                    $('.prodi').text(data.prodi.nama_prodi);
                    $('.angkatan').text(data.angkatan);
                    $('.nama').text(data.nama);
                    $('.ipk').text(data.ipk);
                }
            },
            error: function (xhr) {
                console.log(xhr)
            }
        });
    });

    $(document).on('click', '.showImport', function () {
        $('#modalImport').modal('show');
        $('.action').html("<i class='fas fa-solid fa-file-import'></i> Import");
        $('.action').attr('id', "btnImport");
    });

    $(document).on('click', '#btnImport', function () {
        var data = new FormData();
        data.append('file', $('#file').prop('files')[0]);

        $.ajax({
            type: "POST",
            url: "/importMahasiswa",
            data: data,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                $("#modalImport").modal('hide');
                reloadTable(table_mahasiswa);
                $('#file').removeClass('is-invalid');
                $('.error-area').html('');
                $('#file').val('');
                Swal.fire({
                    title: "Imported!",
                    text: response.message,
                    icon: "success"
                });
            },
            error: function (errors) {
                $('#file').addClass('is-invalid');
                $('.error-area').html(`<span class="text-danger">Pilih hanya file .csv atau .xlsx</span>`)
                console.log(errors);
            }
        });
    });
});