$(document).ready(function () {
    $('#prodi').select2();
    function clearAkunError() {
        $("#pass_error").html('')
        $("#password").removeClass('is-invalid');
        $('.avatar').removeClass('error-cs');
        $('#area-message').html(``);
    }

    function clearProfileError() {
        $('#namaD').removeClass('is-invalid');
        $('#jabatan').removeClass('is-invalid');
        $('#no_telp').removeClass('is-invalid');
        $('#namaD_error').html('');
        $('#jabatan_error').html('');
        $('#no_telp_error').html('');

        // membersih class error di form mahasiswa
        $('#namaM').removeClass('is-invalid');
        $('#prodi').removeClass('is-invalid');
        $('#angkatan').removeClass('is-invalid');
        $('#namaM_error').html('');
        $('#prodi_error').html('');
        $('#angkatan_error').html('');
    }

    $(document).on('click', '#saveAkun', function () {
        var data = new FormData();
        data.append('file_image', $('#file_image')[0].files[0]);
        data.append('password', $('#password').val())

        AjaxPostIncludeData('/edit-akun', data, function (res) {
            console.log(res)
            if (res.status === 200) {
                $('#area-message-akun').html(`<div class="alert alert-success" role="alert">Berhasil mengupdate info akun.</div>`);
                setTimeout(() => {
                    location.reload();
                }, 2000);
            }

            res.status === 204 ?
                ($('#area-message-akun').html(`<div class="alert alert-warning alert-dismissible fade show" role="alert">${res.message}
                                                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
                                            </div>`), clearAkunError())
                : '';

            if (res.status === 422) {
                clearAkunError();
                const errors = res.responseJSON.errors;
                console.log(errors)
                if (errors.password) {
                    $("#pass_error").html('<span class="text-danger">' + errors.password + '</span>')
                    $("#password").addClass('is-invalid')
                }

                if (errors.file_image) {
                    $('.avatar').addClass('error-cs');
                    $('#area-message-akun').html(`<div class="alert alert-danger" role="alert">${errors.file_image}</div>`);
                }
            }
        });
    });

    $(document).on('click', '#saveProfile', function () {
        var data = new FormData();
        data.append('namaM', $('#namaM').val());
        data.append('prodi', $('#prodi').val());
        data.append('angkatan', $('#angkatan').val());
        data.append('namaD', $('#namaD').val());
        data.append('jabatan', $('#jabatan').val());
        data.append('phone_number', $('#no_telp').val());

        AjaxPostIncludeData('/edit-profile', data, function (res) {
            console.log(res)
            if (res.status === 200) {
                $('#area-message-profile').html(`<div class="alert alert-success" role="alert">${res.message}</div>`);
                setInterval(() => {
                    location.reload();
                }, 2000);
            }

            res.status === 204 ?
                ($('#area-message-profile').html(`<div class="alert alert-warning alert-dismissible fade show" role="alert">${res.message}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>`), clearProfileError())
                : '';

            if (res.status === 422) {
                clearProfileError();
                const errors = res.responseJSON.errors;
                console.log(errors);
                if (errors.namaM) {
                    $('#namaM').addClass('is-invalid');
                    $('#namaM_error').html(`<span class="text-danger">${errors.namaM}</span></br>`)
                }
                if (errors.prodi) {
                    $('#prodi').addClass('is-invalid');
                    $('#prodi_error').html(`<span class="text-danger">${errors.prodi}</span></br>`)
                }
                if (errors.angkatan) {
                    $('#angkatan').addClass('is-invalid');
                    $('#angkatan_error').html(`<span class="text-danger">${errors.angkatan}</span></br>`)
                }

                // dosen / staf error
                if (errors.namaD) {
                    $('#namaD').addClass('is-invalid');
                    $('#namaD_error').html(`<span class="text-danger">${errors.namaD}</span></br>`)
                }
                if (errors.jabatan) {
                    $('#jabatan').addClass('is-invalid');
                    $('#jabatan_error').html(`<span class="text-danger">${errors.jabatan}</span></br>`)
                }
                if (errors.phone_number) {
                    $('#no_telp').addClass('is-invalid');
                    $('#no_telp_error').html(`<span class="text-danger">${errors.phone_number}</span></br>`)
                }
            }
        });
    });
});