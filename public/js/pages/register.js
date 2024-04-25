$(document).ready(function () {
    $('.btn-register').click(function () {
        var checkFirstname = $('#firstname').val().trim() == '' ? ($('#firstname').addClass('is-invalid'), false) : ($('#firstname').removeClass('is-invalid'), true);
        // var checkEmail = $('#email').val().trim() == '' ? ($('#email').addClass('is-invalid'), false) : ($('#email').removeClass('is-invalid'), true)
        var pass1 = $('#pass1').val().trim();
        var pass2 = $('#pass2').val().trim();

        var checkPass1 = pass1 === '' ? (
            $('#pass1').addClass('is-invalid'),
            false
        ) : (
            pass1.length !== 8 ? (
                $('#pass1, #pass2').addClass('is-invalid'),
                $('#errorpass').html('<div class="text-danger ml-2">Panjang password harus 8 karakter.</div>'),
                false
            ) : (
                pass1 !== pass2 ? (
                    $('#pass1, #pass2').addClass('is-invalid'),
                    $('#errorpass').html('<div class="text-danger ml-2">Password tidak sesuai.</div>'),
                    false
                ) : (
                    $('#pass1, #pass2').removeClass('is-invalid'),
                    $('#errorpass').html(''),
                    true
                )
            )
        );

        var check = checkFirstname && checkPass1;
        var data = "";
        if (check) {
            data = new FormData();
            data.append('name', $('#firstname').val() + " " + $('#lastname').val());
            data.append('email', $('#email').val())
            data.append('password', $('#pass1').val())

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            for (var pair of data.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }
            $.ajax({
                type: "post",
                url: 'register',
                data: data,
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function () {
                    $('.btn-register').text(`memproses...`);
                },
                success: function (response) {
                    console.log(response)
                    $('.btn-register').text('Register Account');
                    if (response.message) {
                        let message = `<div class="alert alert-success" role="alert">${response.message} <strong>${$('#email').val()}</strong>.`;
                        let message2 = `<div class="alert alert-danger" role="alert">${response.message} <strong>${$('#email').val()}</strong>. Periksa koneksi internet anda.`;
                        response.status == 200 ? $('.message').html(message) : "";
                        response.status == 500 ? $('.message').html(message2) : "";
                    }
                },
                error: function (error) {
                    $('#email').addClass('is-invalid');
                    $('#emailError').html(`<div class="text-danger ml-2">${error.responseJSON.email}</div>`);
                    console.log(error.responseJSON)
                    $('.btn-register').text('Register Account');
                }
            });
        }

    });
});