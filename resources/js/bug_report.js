$(document).ready(function () {
    function reloadCaptcha() {
        $.ajax({
            type: "GET",
            url: "reload-capcha",
            dataType: "json",
            success: function (response) {
                $('#captcha_area').html(response);
            }
        });
    }

    reloadCaptcha();
    function clearErrorMsg() {
        $('#captcha_error').text('');
        $('#captcha').removeClass('is-invalid');
        $('#desc_error').text('');
        $('#description').removeClass('is-invalid');
        $('#captcha').val('');
    }

    function clearInput() {
        $('#description').val('');
        $('#captcha').val('');
    }

    $(document).on('click', '.bug-btn', function () {
        $('#modalbugreport').modal('show');
    });

    $('#send_bug_report').on('click', function () {
        var data = new FormData();
        data.append('description', $('#description').val());
        data.append('captcha', $('#captcha').val());

        $.ajax({
            type: "POST",
            url: "report-bug",
            data: data,
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function () {
                $('#send_bug_report').text('memproses...');
            },
            success: function (response) {
                if (response.status === 200) {
                    $('#alert-section').html(
                        `<span class="toast-success-cs">${response.message}</span>`
                    );
                    $('#send_bug_report').text('Send');
                    clearErrorMsg();
                    clearInput();
                    $('#modalbugreport').modal('hide');
                    reloadCaptcha();
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    $('#send_bug_report').text('Send');
                    const errors = xhr.responseJSON.errors;
                    reloadCaptcha();
                    clearErrorMsg();
                    if (errors.description) {
                        $('#description').addClass('is-invalid');
                        $('#desc_error').text(errors.description);
                    }
                    if (errors.captcha) {
                        $('#captcha').addClass('is-invalid');
                        $('#captcha_error').text(errors.captcha);
                    }
                }
            }
        });
    });

});