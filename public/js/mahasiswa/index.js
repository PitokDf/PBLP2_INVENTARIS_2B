
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
            { "data": "nim", "orderable": true },
            {
                "data": "program_studi", "orderable": true
            },
            { "data": "angkatan", "orderable": true },
            { "data": "ipk", "orderable": false },
            {
                "data": null,
                "render": function (_data, _type, row) {
                    return "<button type='button' data-id='" + row.id_mahasiswa + "' class='btn btn-sm btn-danger btnDelete'><i class='fas a-solid fa-trash'></i></button> <button class='btn btn-sm btn-warning btnEdit' id='" + row.id_mahasiswa + "'><i class='fas fa-regular fa-pen'></i></button>"
                }
                , "orderable": false
            }
        ]
    });

    var url = "";
    const time = new Date();
    const year = time.getFullYear();

    function clearErrorMsg() {
        $('#nama_error').text('');
        $('#nim_error').text('');
        $('#prodi_error').text('');
        $('#angkatan_error').text('');
        $('#ipk_error').text('');
    }

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

    var server = "http://127.0.0.1:8000/";
    $('#btnCreate').click(function () {
        var modal = "modal";
        if ($('.action').attr('id') != 'btnCreateform') {
            clerInput(modal);
        }
        showModal(modal, title = "Add Data Mahasiswa", form = "btnCreateform", icon = "<i class='fas fa-save'></i> Simpan");
    });

    // proses yang akan menangani proses create data dan mengembalikan error saat terjadi error
    // $(document).on('click', '#btnCreateform', function () {
    //     var formData = new FormData(document.getElementById('form'));
    //     url = "mahasiswa";
    //     $.ajax({
    //         type: "POST",
    //         url: url,
    //         data: formData,
    //         processData: false,
    //         contentType: false,
    //         dataType: "json",
    //         success: function (response) {
    //             if (response.status == 200) {
    //                 clerInput(modal = "modal");
    //                 clearErrorMsg();
    //                 reloadTable(table_mahasiswa);
    //                 $('#modal').modal('hide');
    //                 Swal.fire({
    //                     title: "Insert!",
    //                     text: response.message,
    //                     icon: "success",
    //                     confirmButtonText: "Yes"
    //                 });
    //             }
    //         },
    //         error: function (xhr) {
    //             var errorMessage = xhr.responseJSON.errors;
    //             clearErrorMsg();
    //             $('#name_error').text(errorMessage.name);
    //             $('#nip_error').text(errorMessage.nip);
    //             $('#jabatan_error').text(errorMessage.jabatan);
    //             $('#no_telpn_error').text(errorMessage.no_telpn);
    //             $('#email_error').text(errorMessage.email);
    //             $('#dir_foto_error').text(errorMessage.dir_foto);
    //         }
    //     });
    // });

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
});
// saat btn edit diclick maka akan melakakuan request ke server dengan mengirimkan id dan server akan mengembalikan data yang sesuai dengan id yang dikirimkan
$(document).on('click', '.btnEdit', function () {
    clearErrorMsg();
    showModal(modal = "modal", title = "Edit Data Dosen", form = "btnEditform", icon = "<i class='fas fa-regular fa-pen'></i> Update");
    url = "dosen/" + $(this).attr('id') + "/edit";
    $.ajax({
        type: "GET",
        url: url,
        dataType: "json",
        success: function (response) {
            $('#id').val(response.data[0].id_dosen);
            $('#name').val(response.data[0].name);
            $('#nip').val(response.data[0].nip);
            $('#jabatan').val(response.data[0].academic_position);
            $('#no_telpn').val(response.data[0].phone_number);
            $('#email').val(response.data[0].email);
            $('#img-preview').css('display', 'block');
            $('#img-preview').attr('src', server + "storage/dosen/" + response.data[0].photo_dir);
        },
        error: function (xhr) {
            var errorMessage = xhr.responseJSON.errors;
            $('#name_error').text(errorMessage.name);
            $('#nip_error').text(errorMessage.nip);
            $('#jabatan_error').text(errorMessage.jabatan);
            $('#no_telpn_error').text(errorMessage.no_telpn);
            $('#email_error').text(errorMessage.email);
            $('#dir_foto_error').text(errorMessage.dir_foto);
        }
    });
});

$(document).on('click', '#btnEditform', function () {
    var data = new FormData();
    data.append('_method', 'PUT');
    data.append('nama_mahasiswa', $('#nama_mahasiswa').val());
    data.append('angkatan', $('#angkatan').val());
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
            // console.error(xhr.responseJSON)
            $('#email_error').text(xhr.responseJSON.email);
            var errorMessage = xhr.responseJSON.errors;
            $('#name_error').text(errorMessage.name);
            $('#nip_error').text(errorMessage.nip);
            $('#jabatan_error').text(errorMessage.jabatan);
            $('#no_telpn_error').text(errorMessage.no_telpn);
            $('#email_error').text(errorMessage.email);
            $('#dir_foto_error').text(errorMessage.dir_foto);
        }
    });

    $(document).on('click', '.btnDelete', function () {
        console.log('hello')
    })
    // menangani proses delete data
    // $(document).on('click', '.btnDelete', function () {
    //     console.log('delete')
    //     Swal.fire({
    //         title: "Yakin ingin menghapus?",
    //         icon: "warning",
    //         showCancelButton: true,
    //         confirmButtonColor: "#3085d6",
    //         cancelButtonColor: "#d33",
    //         confirmButtonText: "Yes"
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             var url = 'mahasiswa/' + $(this).data('id');
    //             $.ajax({
    //                 type: "DELETE",
    //                 url: url,
    //                 dataType: "json",
    //                 success: function (response) {
    //                     Swal.fire({
    //                         title: "Deleted!",
    //                         text: response.message,
    //                         icon: "success"
    //                     });
    //                     reloadTable(table_mahasiswa);
    //                 },
    //                 error: function (xhr, stattus, error) {
    //                     console.error(xhr + "\n" + stattus + "\n" + error)
    //                 }
    //             });
    //         }
    //     });
    // });
});