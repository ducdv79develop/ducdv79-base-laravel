$(function () {
    $('[data-toggle="tooltip"]').tooltip();
    try {
        $.validator.setDefaults({
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            },
            errorElement: 'span',
            onkeyup: function (element) {
                $(element).valid();
            },
            onkeydown: function (element, event) {
                if (event.which === 38 || event.which === 40) {
                    $(element).valid();
                }
            },
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
        });
    } catch (error) {
    }
    $.ajaxSetup({
        beforeSend: function () {
            loaderStart();
        },
        timeout: 15000,
        async: true,
        error: function (error) {
            var response = error.responseJSON
            if(response.status_code === 419 && response.flag_token) {
                location.reload();
            } else {
                console.log(response)
                loadEndError();
            }
        }
    })
})
$(document).on('click', '.copy-clipboard', function () {
    let element = $(this).find('.value-clipboard');
    copyToClipboard(element);
    $(this).tooltip();
})
$(document).on('click', '.btn-copy-clipboard', function () {
    let element = $(this).data('copy');
    copyToClipboard(element);
})
$(document).on('click', '.btn-reset-form', function () {
    this.form.reset();
    $(this.form).find('*').removeClass('is-invalid');
    $(this.form).find('span[class="error invalid-feedback"]').text('');
})
$(document).on('click', 'button[data-dismiss="modal"]', function () {
    this.form.reset();
    $(this.form).find('*').removeClass('is-invalid');
    $(this.form).find('span[class="error invalid-feedback"]').text('');
})
$(document).on('change', '.parent-check', function () { parentCheckOnchange(this) })
$(document).on('change', '.child-check', function () { childCheckOnchange(this) })
