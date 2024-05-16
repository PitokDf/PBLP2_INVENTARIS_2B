$(document).ready(function () {
    function getCapcha() {
        $.ajax({
            type: "GET",
            url: "/reload-capcha",
            dataType: "json",
            success: function (response) {
                $('#capcha_code').html(response);
                console.log(response)
            }
        });
    }
    getCapcha();
    $('.btn-register').click(function () {
        var checkFirstname = $('#firstname').val().trim() == '' ? ($('#firstname').addClass('is-invalid'), false) : ($('#firstname').removeClass('is-invalid'), true);
        var pass1 = $('#pass1').val().trim();
        var pass2 = $('#pass2').val().trim();

        var checkPass1 = pass1 === '' ? (
            $('#pass1').addClass('is-invalid'),
            false
        ) : (
            pass1.length < 8 ? (
                $('#pass1, #pass2').addClass('is-invalid'),
                $('#errorpass').html('<div class="text-danger ml-2">Panjang password minimal 8 karakter.</div>'),
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
            data.append('capcha', $('#capcha').val())
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
                    $('.btn-register').text('Register Account');

                    if (response.status == 200) {
                        let message = `<div class="alert alert-success" role="alert">${response.message} <strong>${$('#email').val()}</strong>.`;
                        response.status == 200 ? $('.message').html(message) : "";
                        setInterval(() => {
                            location.reload();
                        }, 1000);
                    }
                },
                error: function (error) {
                    $('.btn-register').text('Register Account');
                    console.log(error)
                    getCapcha();
                    $('#capcha').val('');
                    $('#email').removeClass('is-invalid');
                    $('#emailError').html('');
                    $('#capcha').removeClass('is-invalid');
                    $('#capchaError').html('');
                    if (error.responseJSON.email) {
                        $('#email').addClass('is-invalid');
                        $('#emailError').html(`<div class="text-danger ml-2">${error.responseJSON.email}</div>`);
                    }
                    if (error.responseJSON.capcha) {
                        $('#capcha').addClass('is-invalid');
                        $('#capchaError').html(`<div class="text-danger ml-2">${error.responseJSON.capcha}</div>`);
                    }
                    if (error.responseJSON.message) {
                        let message2 = `<div class="alert alert-danger" role="alert">Periksa koneksi internet anda.`;
                        $('.message').html(message2)
                    }
                }
            });
        }

    });
});