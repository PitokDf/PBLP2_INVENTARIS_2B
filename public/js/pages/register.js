$(document).ready(function () {
    $('.btn-register').click(function () {
        var checkFirstname = $('#firstname').val().trim() == '' ? ($('#firstname').addClass('is-invalid'), false) : ($('#firstname').removeClass('is-invalid'), true);
        var checkEmail = $('#email').val().trim() == '' ? ($('#email').addClass('is-invalid'), false) : ($('#email').removeClass('is-invalid'), true)
        var checkPass1 = $('#pass1').val().trim() === '' ? ($('#pass1').addClass('is-invalid'), false) : ($('#pass1').val() !== $('#pass2').val() ? ($('#pass1, #pass2').addClass('is-invalid'), $('#errorpass').text('password tidak sesuai'), false) : ($('#pass1, #pass2').removeClass('is-invalid'), $('#errorpass').text(''), true));

        var check = checkFirstname && checkEmail && checkPass1;
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
                    $('.btn-register').html(`<img src="images/BeanEater@1x-1.0s-200px-200px.gif" alt=""
                    srcset="" style="width: 20px;">`);
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
                    // console.log(error.responJson)
                    $('.btn-register').text('Register Account');
                }
            });
        }

    });
});