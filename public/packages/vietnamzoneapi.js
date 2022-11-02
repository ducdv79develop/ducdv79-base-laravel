const PACKAGE_VNZ_API = '/api/v1/vietnam-zone';
const VNZ_PROVINCE_API = PACKAGE_VNZ_API + '/tinh-thanh-pho';
const VNZ_DISTRICT_API = PACKAGE_VNZ_API + '/quan-huyen';
const VNZ_WARD_API = PACKAGE_VNZ_API + '/phuong-xa';
const VNZ_ADDRESS_CODE_API = PACKAGE_VNZ_API + '/tim-dia-chi';

class PackageVietNamZoneApi {
    constructor(
        province = "#province_id",
        district = "#district_id",
        ward = "#ward_id",
        code = "#address_address_code"
    ) {
        this.vnz_ele_province = province;
        this.vnz_ele_district = district;
        this.vnz_ele_ward = ward;
        this.vnz_ele_gso_code = code;
    }

    billingProvince() {
        var main = this;
        var xhtml = `<option value="">Chọn tỉnh thành phố</option>`;
        var value = $(main.vnz_ele_province).val();
        var reset = true;
        $.ajax({
            url: VNZ_PROVINCE_API,
            type: "GET",
            success: function (response) {
                response.data.forEach((element) => {
                    let selected = '';
                    if (value == element.province_id) {
                        selected = 'selected';
                        reset = false;
                    }
                    xhtml += `<option value="${element.province_id}" ${selected} data-code="${element.code}">${element.province_name}</option>`;
                });
                $(main.vnz_ele_province).html(xhtml);
                if (reset) {
                    $(main.vnz_ele_province).val('');
                } else {
                    $(main.vnz_ele_province).val(value);
                }
                main.billingAddressCode();
                loaderEnd();
            },
            error: function (response) {
                $(main.vnz_ele_province).html(xhtml).val('');
                main.billingAddressCode();
                loaderEnd();
            }
        });

    }

    billingDistrict() {
        var main = this;
        var xhtml = `<option value="">Chọn quận huyện</option>`;
        var province_id = $(main.vnz_ele_province).val();
        var value = $(main.vnz_ele_district).val();
        var reset = true;
        if (province_id) {
            $.ajax({
                url: VNZ_DISTRICT_API,
                type: "GET",
                data: {
                    province_id: province_id
                },
                success: function (response) {
                    response.data.forEach((element) => {
                        let selected = '';
                        if (value == element.district_id) {
                            selected = 'selected';
                            reset = false;
                        }
                        xhtml += `<option value="${element.district_id}" ${selected} data-code="${element.code}">${element.district_name}</option>`;
                    });
                    $(main.vnz_ele_district).val(value).html(xhtml).prop('disabled', false);
                    if (reset) {
                        $(main.vnz_ele_district).val('');
                        main.billingWard();
                    } else {
                        $(main.vnz_ele_district).val(value);
                    }
                    main.billingAddressCode();
                    loaderEnd();
                },
                error: function (response) {
                    $(main.vnz_ele_district).html(xhtml).prop('disabled', true).val('');
                    $(main.vnz_ele_ward).html(xhtml).prop('disabled', true);
                    if (reset) {
                        main.billingWard();
                    }
                    main.billingAddressCode();
                    loaderEnd();
                }
            });
        } else {
            $(main.vnz_ele_district).html(xhtml).prop('disabled', true);
            $(main.vnz_ele_ward).html(xhtml).prop('disabled', true);
            main.billingAddressCode();
        }
    }

    billingWard() {
        var main = this;
        var xhtml = `<option value="">Chọn phường xã</option>`;
        var province_id = $(main.vnz_ele_province).val();
        var district_id = $(main.vnz_ele_district).val();
        var value = $(main.vnz_ele_ward).val();
        var reset = true;
        if (district_id && province_id) {
            $.ajax({
                url: VNZ_WARD_API,
                type: "GET",
                data: {
                    province_id: province_id,
                    district_id: district_id
                },
                success: function (response) {
                    response.data.forEach((element) => {
                        let selected = '';
                        if (value == element.ward_id) {
                            selected = 'selected';
                            reset = false;
                        }
                        xhtml += `<option value="${element.ward_id}" ${selected} data-code="${element.code}">${element.ward_name}</option>`;
                    });
                    $(main.vnz_ele_ward).html(xhtml).prop('disabled', false);
                    if (reset) {
                        $(main.vnz_ele_ward).val('');
                    } else {
                        $(main.vnz_ele_ward).val(value);
                    }
                    main.billingAddressCode();
                    loaderEnd();
                },
                error: function (response) {
                    $(main.vnz_ele_ward).html(xhtml).prop('disabled', true).val('');
                    main.billingAddressCode();
                    loaderEnd();
                }
            });
        } else {
            $(main.vnz_ele_ward).html(xhtml).prop('disabled', true);
            main.billingAddressCode();
        }
    }

    billingAddressDefault(address_code) {
        var main = this;
        $.ajax({
            url: VNZ_ADDRESS_CODE_API,
            type: "GET",
            data: {
                address_code: address_code
            },
            success: function (response) {
                if (response.data[0]) {
                    let element = response.data[0];
                    $(main.vnz_ele_province)
                        .val(element.province_id)
                        .html(`<option value="${element.province_id}" selected data-code="${element.code}">${element.province_name}</option>`);

                    if (element.district_id) {
                        $(main.vnz_ele_district)
                            .prop('disabled', false)
                            .val(element.district_id)
                            .html(`<option value="${element.district_id}" selected data-code="${element.code}">${element.district_name}</option>`);
                    }
                    if (element.ward_id) {
                        $(main.vnz_ele_ward)
                            .prop('disabled', false)
                            .val(element.ward_id)
                            .html(`<option value="${element.ward_id}" selected data-code="${element.code}">${element.ward_name}</option>`);
                    }
                    $(main.vnz_ele_gso_code).val(address_code);
                }
                loaderEnd();
            },
            error: function (response) {
                loaderEnd();
            }
        });
    }

    billingAddressCode() {
        var main = this;
        let address_code;
        if ($(main.vnz_ele_ward).val()) {
            address_code = $(main.vnz_ele_ward).find('option:selected').data('code');
        } else if ($(main.vnz_ele_district).val()) {
            address_code = $(main.vnz_ele_district).find('option:selected').data('code');
        } else if ($(main.vnz_ele_province).val()) {
            address_code = $(main.vnz_ele_province).find('option:selected').data('code');
        } else {
            address_code = null;
        }
        $(main.vnz_ele_gso_code).val(address_code);
    }
}
