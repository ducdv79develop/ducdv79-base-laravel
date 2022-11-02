function formatDate(dateObject) {
    var d = new Date(dateObject);
    var day = d.getDate();
    var month = d.getMonth() + 1;
    var year = d.getFullYear();
    if (day < 10) {
        day = "0" + day;
    }
    if (month < 10) {
        month = "0" + month;
    }
    return year + "-" + month + "-" + day;
}
function loaderStart(){
    $("#loader").css({'display': 'block'});
    $("body").css({'pointer-events': 'none', 'opacity': '0.6'});
}
function loaderEnd(){
    $("#loader").css({'display': 'none'});
    $("body").css({'pointer-events': 'all', 'opacity': '1'});
}
function loadEndError() {
    loaderEnd();
    Swal.fire({
        icon: 'error',
        title: 'Đã có lỗi xảy ra <br> Vui lòng thử lại!',
        showConfirmButton: false,
        showCloseButton: true,
        timer: 1500
    })
}
function loadEndPermissionError() {
    loaderEnd();
    Swal.fire({
        icon: 'error',
        title: 'Bạn không có quyền <br> Vui lòng liên hệ admin!',
        showConfirmButton: false,
        showCloseButton: true,
        timer: 1500
    })
}
function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    var value = $(element).val() ? $(element).val() : $(element).text();
    $temp.val(value).select();
    document.execCommand("copy");
    $temp.remove();
}
function showErrorCustom(event, formID) {
    let errorForm = event.numberOfInvalids();
    if (errorForm > 0) {
        $(formID + " button[type='submit']").attr("disabled", true);
    } else {
        $(formID + " button[type='submit']").attr("disabled", false);
    }
    event.defaultShowErrors();
}
function replaceUrlParam(url, paramName, paramValue) {
    if (paramValue == null) {
        paramValue = '';
    }
    // remove params define
    var paramRemoves = ['act'];
    if (paramRemoves) {
        for (let i = 0; i < paramRemoves.length; i++) {
            var patternRemove = new RegExp('\\b(' + paramRemoves[i] + '=).*?(&|#|$)');
            if (url.search(patternRemove) >= 0) {
                url = url.replace(patternRemove, '$1' + '' + '$2');
            }
        }
    }
    var pattern = new RegExp('\\b(' + paramName + '=).*?(&|#|$)');
    if (url.search(pattern) >= 0) {
        return url.replace(pattern, '$1' + paramValue + '$2');
    }
    url = url.replace(/[?#]$/, '');
    return url + (url.indexOf('?') > 0 ? '&' : '?') + paramName + '=' + paramValue;
}
function submitFormAjax(form, reload = false, data = {}) {
    var formData = $(form).serialize();
    if (reload) {
        var href = window.location.href;
        formData += "&url_callback=" + href;
    }
    if (Object.keys(data).length > 0) {
        $.each(data, function (key, value) {
            formData += "&" + key + "=" + value;
        })
    }
    $(form).find('button[type="submit"]').prop('disabled', true);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        },
        type: $(form).attr('method'),
        url: $(form).attr('action'),
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.status) {
                if (response.data.redirect) {
                    window.location.href = response.data.redirect;
                    return false;
                } else if (reload) {
                    window.location.href = href;
                    return false;
                }
                loaderEnd();
            } else {
                loadEndError();
            }
            $(form).find('button[type="submit"]').prop('disabled', false);
        },
        error: function (error) {
            var response = error.responseJSON;
            if (response.status_code == 422) {
                for (const name in response.error) {
                    var element = $(form).find('select[name="'+name+'"], input[name="'+name+'"], textarea[name="'+name+'"]');
                    element.addClass('is-invalid');
                    element.attr({
                        'aria-describedby': name + '-error',
                        'aria-invalid': 'true'
                    });
                    element.closest('.form-group').append(`<span id="${name}-error" class="error invalid-feedback">${response.error[name]}</span>`);
                    loaderEnd();
                }
            } else if(response.status_code == 403) {
                loadEndPermissionError();
            } else {
                loadEndError();
            }
            $(form).find('button[type="submit"]').prop('disabled', false);
        }
    });
}
numberSeparator({
    selector: '.number-separator',
});
function numberSeparator(config) {
    let commaCounter = 10;
    const obj = {
        selector: config.selector || ".number-separator",
        separator: config.separator || ".",
        decimalSeparator: config.decimalSeparator || ",",
        resultInput: config.resultInput
    }
    function numberSeparatorCore(num) {
        var x,y,z;
        for (let i = 0; i < commaCounter; i++) {
            num = num.replace(obj.separator, "");
        }
        x = num.split(obj.decimalSeparator);
        y = x[0];
        z = x.length > 1 ? obj.decimalSeparator + x[1] : "";
        let rgx = /(\d+)(\d{3})/;
        while (rgx.test(y)) {
            y = y.replace(rgx, "$1" + obj.separator + "$2");
        }
        commaCounter++;
        if (obj.resultInput) {
            const resInput = document.querySelector(obj.resultInput)
            if (resInput) {
                resInput.value = num.replace(obj.separator, "")
                resInput.value = num.replace(obj.decimalSeparator, ".")
            }
        }
        return y + z;
    }
    document.querySelectorAll(obj.selector).forEach(function (el) {
        el.addEventListener("input", function (e) {
            const reg = new RegExp(
                `^-?\\d*[${obj.separator}${obj.decimalSeparator}]?(\\d{0,3}${obj.separator})*(\\d{3}${obj.separator})?\\d{0,3}$`
            );
            const key = e.data || this.value.substr(-1)
            if (reg.test(key)) {
                e.target.value = numberSeparatorCore(e.target.value);
            } else {
                e.target.value = e.target.value.substring(0, e.target.value.length - 1);
                e.preventDefault();
                return false;
            }
        });
        el.value = numberSeparatorCore(el.value);
    });
}

function numberSeparatorShow(num, config = {}) {
    const obj = {
        separator: config.separator || ".",
        decimalSeparator: config.decimalSeparator || ",",
        commaCounter: config.commaCounter || 10
    }
    let commaCounter = obj.commaCounter;
    if (typeof num !== 'string') num = num.toString();
    var x,y,z;
    for (let i = 0; i < commaCounter; i++) {
        num = num.replace(obj.separator, "");
    }
    x = num.split(obj.decimalSeparator);
    y = x[0];
    z = x.length > 1 ? obj.decimalSeparator + x[1] : "";
    let rgx = /(\d+)(\d{3})/;
    while (rgx.test(y)) {
        y = y.replace(rgx, "$1" + obj.separator + "$2");
    }
    commaCounter++;
    return y + z;
}

function numberSeparatorRevert(num, config = {}) {
    const obj = {
        separator: config.separator || ".",
        decimalSeparator: config.decimalSeparator || ",",
        commaCounter: config.commaCounter || 10
    }
    let commaCounter = obj.commaCounter;
    if (typeof num !== 'string') num = num.toString();
    for (let i = 0; i < commaCounter; i++) {
        num = num.replace(obj.separator, "");
    }
    if (obj.decimalSeparator !== ".") num = num.replace(obj.decimalSeparator, ".");

    return parseFloat(num);
}

function triggerGroupCheck(from) {
    $(from).find('.group-check').each(function (index, item1) {
        var parent = $(item1).find('.parent-check');
        var flagCheckAll = true;
        $(item1).find('.child-check').each(function (index, item2) {
            if (!$(item2).is(':checked')) flagCheckAll = false;
        });
        if (flagCheckAll) {
            parent.prop('checked', true);
        }
    });
}

function childCheckOnchange(child) {
    var group = $(child).parents('.group-check');
    var parent = $(group).find('.parent-check');
    var flagCheckAll = true;
    $(group).find('.child-check').each(function (index, item) {
        if (!$(item).is(':checked')) flagCheckAll = false;
    });
    parent.prop('checked', flagCheckAll);
}

function parentCheckOnchange(parent) {
    var group = $(parent).parents('.group-check');
    $(group).find('.child-check').prop('checked', $(parent).is(':checked'));
}
