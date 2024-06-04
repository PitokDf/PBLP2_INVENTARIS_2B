$(document).ready(function () {
    if (document.getElementById('time') !== null) {
        getTime();
        setInterval(() => {
            getTime();
        }, 1000);
    }

    $('#tableRequest').dataTable({
        "processing": true,
        "paging": false,
        "searching": false,
        "responsive": true,
    });

    $('#showprofile').on('click', function () {
        $('#profile').modal('show');
    });

    function clearErrorMsg() {
        $('#nim').removeClass('is-invalid');
        $('#nim_error').html(``);
        $('#nip').removeClass('is-invalid');
        $('#nip_error').html(``);
        $('#nama').removeClass('is-invalid');
        $('#nama_error').html(``);
        $('#prodi').removeClass('is-invalid');
        $('#prodi_error').html(``);
        $('#jabatan').removeClass('is-invalid');
        $('#jabatan_error').html(``);
        $('#angkatan').removeClass('is-invalid');
        $('#angkatan_error').html(`<`);
        $('#no_hp').removeClass('is-invalid');
        $('#no_hp_error').html(``);
        $('#ipk').removeClass('is-invalid');
        $('#ipk_error').html(``);
    }

    $('#saveData').on('click', function () {
        var data = $('#form').serialize();
        AjaxPostIncludeSerialize('/lengkapi-data', data, function (res, errors) {
            if (res.responseJSON) {
                const error = res.responseJSON.errors;
                clearErrorMsg();
                if (error.nim) {
                    $('#nim').addClass('is-invalid');
                    $('#nim_error').html(`<div class="text-danger">${error.nim}</div>`);
                }
                if (error.nip) {
                    $('#nip').addClass('is-invalid');
                    $('#nip_error').html(`<div class="text-danger">${error.nip}</div>`);
                }
                if (error.nama) {
                    $('#nama').addClass('is-invalid');
                    $('#nama_error').html(`<div class="text-danger">${error.nama}</div>`);
                }
                if (error.prodi) {
                    $('#prodi').addClass('is-invalid');
                    $('#prodi_error').html(`<div class="text-danger">${error.prodi}</div>`);
                }
                if (error.jabatan) {
                    $('#jabatan').addClass('is-invalid');
                    $('#jabatan_error').html(`<div class="text-danger">${error.jabatan}</div>`);
                }
                if (error.angkatan) {
                    $('#angkatan').addClass('is-invalid');
                    $('#angkatan_error').html(`<div class="text-danger">${error.angkatan}</div>`);
                }
                if (error.no_hp) {
                    $('#no_hp').addClass('is-invalid');
                    $('#no_hp_error').html(`<div class="text-danger">${error.no_hp}</div>`);
                }
                if (error.ipk) {
                    $('#ipk').addClass('is-invalid');
                    $('#ipk_error').html(`<div class="text-danger">${error.ipk}</div>`);
                }
            }

            if (res.status === 200) {
                location.reload();
            }
        });
    });

    $('#cari_barang').click(function () {
        const code = document.getElementById('code_barang').value;
        if (code.trim() !== '') {
            $.ajax({
                type: "get",
                url: "/get-barang/" + code,
                dataType: "json",
                success: function (response) {
                    $('#nama_barang').val('');
                    $('#kategori_barang').val('');
                    console.log(response)
                    if (response.status === 200) {
                        $('#jumlah').attr('readonly', false);
                        $('.action').attr('disabled', false);
                        $('#jumlah').val('1');

                        $('#nama_barang').val(response.data.nama_barang);
                        $('#stok').val(response.data.quantity);
                        $('#kategori_barang').val(response.data.kategori.nama_kategori_barang);
                    }
                    if (response.status === 404) {
                        $('#jumlah').attr('readonly', true);
                        $('.action').attr('disabled', true);
                        $('#jumlah').val('');
                        //sweetalert
                        Swal.fire({
                            icon: 'error',
                            title: 'Ops !!',
                            text: response.message,
                            confirmButtonText: 'Periksa',
                            confirmButtonColor: '#007bff',
                        });
                    }
                }
            });
        }
    });

    $('#btnRequest_peminjaman').on('click', function () {
        const data = $('#form').serialize();
        AjaxPostIncludeSerialize('request-peminjaman', data, function (response, error) {
            console.log(response)
            console.log(error)
            if (response.status == 200) {
                $('#jumlah').removeClass('is-invalid'); $('#jumlah_error').text(''); $('#code_barang').removeClass('is-invalid'); $('#reason').removeClass('is-invalid'); $('#reason_error').text('')
                $('#code_barang').val(''); $('#stok').val(''); $('#nama_barang').val(''); $('#kategori_barang').val(''); $('#jumlah').val(''); $('#reason').val('')
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!!',
                    text: response.message,
                    confirmButtonText: 'Ok',
                    confirmButtonColor: '#007bff',
                });
            }

            if (response.status == 203) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ops !!',
                    text: response.message,
                    confirmButtonText: 'Periksa',
                    confirmButtonColor: '#007bff',
                });
            }

            var errors = '';
            if (response.responseJSON.errors) {
                errors = response.responseJSON.errors;
            }
            if (errors) {
                $('#jumlah').removeClass('is-invalid')
                $('#jumlah_error').text('')
                $('#code_barang').removeClass('is-invalid')
                $('#reason').removeClass('is-invalid')
                $('#reason_error').text('')
                errors.jumlah ? ($('#jumlah').addClass('is-invalid'), $('#jumlah_error').text(errors.jumlah)) : ''
                errors.code_barang ? $('#code_barang').addClass('is-invalid') : ''
                errors.reason ? ($('#reason').addClass('is-invalid'), $('#reason_error').text(errors.reason)) : ''
            }
        })
    });
});