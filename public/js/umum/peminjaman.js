$(document).ready(function () {
    console.log('hai')

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
    })
});