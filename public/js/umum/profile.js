$(document).ready(function () {

    function clearAkunError() {
        $("#pass_error").html('')
        $("#password").removeClass('is-invalid');
        $('.avatar').removeClass('error-cs');
        $('#area-message').html(``);
    }

    $(document).on('click', '#saveAkun', function () {
        var data = new FormData();
        data.append('file_image', $('#file_image')[0].files[0]);
        data.append('password', $('#password').val())

        AjaxPostIncludeData('/edit-akun', data, function (res) {
            console.log(res)
            if (res.status === 200) {
                $('#area-message').html(`<div class="alert alert-success" role="alert">Berhasil mengupdate info akun.</div>`);
                setTimeout(() => {
                    location.reload();
                }, 2000);
            }

            res.status === 204 ?
                ($('#area-message').html(`<div class="alert alert-warning" role="alert">${res.message}</div>`),
                    setTimeout(() => {
                        document.querySelector('.alert').style.display = 'none';
                        clearAkunError();
                    }, 2000)
                ) : '';

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
                    $('#area-message').html(`<div class="alert alert-danger" role="alert">${errors.file_image}</div>`);
                }
            }
        });
    });

    $(document).on('click', '#saveProfile', function () {
        var data = new FormData();
        data.append('namaM', $('#namaM').val())
        data.append('prodi', $('#prodi').val())

        AjaxPostIncludeData('/edit-profile', data, function (res) {
            console.log(res)
            if (res.status === 200) {
                $('#area-message').html(`<div class="alert alert-success" role="alert">Berhasil mengupdate info akun.</div>`);
                setTimeout(() => {
                    location.reload();
                }, 2000);
            }

            res.status === 204 ?
                ($('#area-message').html(`<div class="alert alert-warning" role="alert">${res.message}</div>`),
                    setTimeout(() => {
                        document.querySelector('.alert').style.display = 'none';
                        clearAkunError();
                    }, 2000)
                ) : '';

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
                    $('#area-message').html(`<div class="alert alert-danger" role="alert">${errors.file_image}</div>`);
                }
            }
        });
    });
});