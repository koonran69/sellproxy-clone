function getProvince(selectedProvinceId = null) {
    $.ajax({
        url: '/get-province',
        type: "GET",
        success: function (response) {
            $('#province_id').empty();
            $('#province_id').append('<option value="">Chọn tỉnh thành</option>');
            response.data.forEach(function (data) {
                let selected = (selectedProvinceId && data.id == selectedProvinceId) ? 'selected' : '';
                $('#province_id').append(`<option value="${data.id}" ${selected}>${data.province_name}</option>`);
            });
            $('#province_id').val(selectedProvinceId).trigger('change');
        },
        error: function (xhr, status, error) {
            console.error("Lỗi khi gọi API:", error);
        }
    });
}

function getDistrict(province_id, selectedDistrictId = null) {
    $.ajax({
        url: '/get-district',
        type: "GET",
        data: {
            province_id: province_id
        },
        success: function (response) {
            $('#district_id').empty();
            $('#district_id').append('<option value="">Chọn quận huyện</option>');
            response.data.forEach(function (data) {
                let selected = (selectedDistrictId && data.id == selectedDistrictId) ? 'selected' : '';
                $('#district_id').append(`<option value="${data.id}" ${selected}>${data.district_name}</option>`);
            });
            $('#district_id').val(selectedDistrictId).trigger('change');
        },
        error: function (xhr, status, error) {
            console.error("Lỗi khi gọi API:", error);
        }
    });
}
function getWard(district_id, selectedWardId = null) {
    $.ajax({
        url: '/get-ward',
        type: "GET",
        data: {
            district_id: district_id
        },
        success: function (response) {
            $('#ward_id').empty();
            $('#ward_id').append('<option value="">Chọn phường xã</option>');
            response.data.forEach(function (data) {
                let selected = (selectedWardId && data.id == selectedWardId) ? 'selected' : '';
                $('#ward_id').append(`<option value="${data.id}" ${selected}>${data.ward_name}</option>`);
            });
            $('#ward_id').val(selectedWardId).trigger('change');
        },
        error: function (xhr, status, error) {
            console.error("Lỗi khi gọi API:", error);
        }
    });
}

function getInstitutionParent(province_id, id, selectedInstitutionId = null) {
    $.ajax({
        url: '/get-institution-parent',
        type: "GET",
        data: {
            province_id: province_id,
            id: id,
        },
        success: function (response) {
            let $institutionSelect = $('#institution_parent');
            $institutionSelect.empty().append('<option value="">Chọn cơ quan cha</option>');

            response.data.forEach(function (data) {
                let selected = (selectedInstitutionId && data.id == selectedInstitutionId) ? 'selected' : '';
                $institutionSelect.append(`<option value="${data.id}" ${selected}>${data.parent_name}</option>`);
            });

            if (selectedInstitutionId) {
                $institutionSelect.val(selectedInstitutionId).trigger('change');
            }
        },
        error: function (xhr, status, error) {
            console.error("Lỗi khi gọi API:", error);
        }
    });
}

function getInstitution(selectId = null) {
    $.ajax({
        url: '/get-institution',
        type: "GET",
        success: function (response) {
            $('#institution_id').empty();
            $('#institution_id').append('<option value="">Chọn cơ quan</option>');
            response.data.forEach(function (data) {
                let selected = (selectId && data.id == selectId) ? 'selected' : '';
                $('#institution_id').append(`<option value="${data.id}" ${selected}>${data.name}</option>`);
            });
            $('#institution_id').val(selectId).trigger('change');
        },
        error: function (xhr, status, error) {
            console.error("Lỗi khi gọi API:", error);
        }
    });
}

function getUnitParent(id, selectId = null) {
    $.ajax({
        url: '/get-unit-parent',
        type: "GET",
        data: {
            id: id,
        },
        success: function (response) {
            $('#unit_parent').empty();
            $('#unit_parent').append('<option value="">Chọn đơn vị cha</option>');
            response.data.forEach(function (data) {
                let selected = (selectId && data.id == selectId) ? 'selected' : '';
                $('#unit_parent').append(`<option value="${data.id}" ${selected}>${data.parent_name}</option>`);
            });
            $('#unit_parent').val(selectId).trigger('change');
        },
        error: function (xhr, status, error) {
            console.error("Lỗi khi gọi API:", error);
        }
    });
}

function getUnit(selectId = null) {
    $.ajax({
        url: '/get-unit',
        type: "GET",
        success: function (response) {
            $('#unit_id').empty();
            $('#unit_id').append('<option value="">Chọn đơn vị</option>');
            response.data.forEach(function (data) {
                let selected = (selectId && data.id == selectId) ? 'selected' : '';
                $('#unit_id').append(`<option value="${data.id}" ${selected}>${data.name}</option>`);
            });
            $('#unit_id').val(selectId).trigger('change');
        },
        error: function (xhr, status, error) {
            console.error("Lỗi khi gọi API:", error);
        }
    });
}

function validateForm(constraints) {
    $('#validation-form input, #validation-form select').on('input change', function () {
        var input = $(this);
        var inputName = input.attr('name');
        let value = input.val().trim();

        if (constraints[inputName]) {
            var fieldData = {};
            fieldData[inputName] = value;
            var errors = validate(fieldData, constraints);

            if (!errors || !errors[inputName]) {
                input.removeClass('is-invalid').addClass('is-valid');
                input.next('.invalid-feedback').hide().text('');
            } else {
                input.removeClass('is-valid').addClass('is-invalid');
                input.next('.invalid-feedback').text(errors[inputName][0]).show();
            }
        }
    });
}

function showErrors(errors) {
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').hide().text('');

    $.each(errors, function (inputName, inputErrors) {
        var input = $('[name="' + inputName + '"]');

        if (input.length > 0) {
            if (input.hasClass('select2-hidden-accessible')) {
                var select2Container = input.next('.select2-container');
                select2Container.find('.select2-selection').addClass('is-invalid');

                var feedback = input.parent().find('.invalid-feedback');
                if (feedback.length === 0) {
                    feedback = $('<div class="invalid-feedback"></div>').insertAfter(select2Container);
                }
                feedback.text(inputErrors[0]).show();
            } else {
                input.addClass('is-invalid');
                var feedback = input.next('.invalid-feedback');
                if (feedback.length === 0) {
                    feedback = $('<div class="invalid-feedback"></div>').insertAfter(input);
                }
                feedback.text(inputErrors[0]).show();
            }
        }
    });
}

$('#validation-form select').on('change', function () {
    var input = $(this);
    if (input.hasClass('select2-hidden-accessible')) {
        var select2Container = input.next('.select2-container');
        select2Container.find('.select2-selection').removeClass('is-invalid');
        input.parent().find('.invalid-feedback').hide().text('');
    } else {
        input.removeClass('is-invalid').addClass('is-valid');
        input.next('.invalid-feedback').hide().text('');
    }
});

function resetForm() {
    document.getElementById("validation-form").reset();
    document.getElementById("id").value = "";
}

function getTopic(selectId = null) {
    $.ajax({
        url: '/get-topic',
        type: "GET",
        success: function (response) {
            $('#topic_id').empty();
            $('#topic_id').append('<option value="">Chọn chủ đề</option>');
            response.data.forEach(function (data) {
                let selected = (selectId && data.id == selectId) ? 'selected' : '';
                $('#topic_id').append(`<option value="${data.id}" ${selected}>${data.name}</option>`);
            });
            $('#topic_id').val(selectId).trigger('change');
        },
        error: function (xhr, status, error) {
            console.error("Lỗi khi gọi API:", error);
        }
    });
}
function getContent(selectId = null) {
    $.ajax({
        url: '/get-content',
        type: "GET",
        success: function (response) {
            $('#content_id').empty();
            $('#content_id').append('<option value="">Chọn nội dung</option>');
            response.data.forEach(function (data) {
                let selected = (selectId && data.id == selectId) ? 'selected' : '';
                $('#content_id').append(`<option value="${data.id}" ${selected}>${data.name}</option>`);
            });
            $('#content_id').val(selectId).trigger('change');
        },
        error: function (xhr, status, error) {
            console.error("Lỗi khi gọi API:", error);
        }
    });
}
