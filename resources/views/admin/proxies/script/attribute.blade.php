<script>
   $(document).ready(function() {
    const variationsData = @json($variations);
    let variationInputs = {}; 
    
    // Khi chọn thuộc tính, hiển thị biến thể
    $('#attribute-select').on('change', function() {
        let attrId = $(this).val();
        let variationOptions = $('#variation-options');
        let variationDataList = $('#variation-data-list');

        // Xóa toàn bộ biến thể cũ khi chọn thuộc tính mới
        variationOptions.empty();
        variationDataList.empty();
        $('#variation-data-container').hide();

        if (attrId && variationsData[attrId]) {
            $('#variation-select-container').show();
            variationsData[attrId].forEach(variation => {
                variationOptions.append(`
                    <div class="variation-option" data-id="${variation.id}" data-name="${variation.name}">
                        <i class="ti ti-circle"></i> ${variation.name}
                    </div>
                `);
            });
        } else {
            $('#variation-select-container').hide();
        }
    });

    // Chọn biến thể
    $(document).on('click', '.variation-option', function() {
        let id = $(this).data('id');
        let icon = $(this).find('i');
        $(this).toggleClass('selected');

        if ($(this).hasClass('selected')) {
            icon.removeClass('ti-circle').addClass('ti-circle-check');
        } else {
            icon.removeClass('ti-circle-check').addClass('ti-circle');
        }

        renderVariationForm();
    });

    // Lưu dữ liệu đã nhập trước khi cập nhật danh sách biến thể
    function saveCurrentInputs() {
        $('.variation-item').each(function() {
            let id = $(this).data('id');
            variationInputs[id] = {
                price: $(`input[name="variations[${id}][price]"]`).val(),
                price_promotion: $(`input[name="variations[${id}][price_promotion]"]`).val(),
                duration: $(`input[name="variations[${id}][duration]"]`).val(),
                status: $(`select[name="variations[${id}][status]"]`).val(),
                desc: $(`textarea[name="variations[${id}][desc]"]`).val()
            };
        });
    }

    // Render form nhập dữ liệu cho các biến thể đã chọn
    function renderVariationForm() {
        let selectedVariations = $('.variation-option.selected');
        let variationDataList = $('#variation-data-list');

        // Lưu dữ liệu trước khi cập nhật HTML
        saveCurrentInputs();

        variationDataList.empty();
        if (selectedVariations.length > 0) {
            $('#variation-data-container').show();
            selectedVariations.each(function() {
                let id = $(this).data('id');
                let name = $(this).data('name');

                // Lấy dữ liệu đã nhập trước đó (nếu có)
                let data = variationInputs[id] || {};

                variationDataList.append(`
                    <div class="variation-item mb-4" data-id="${id}">
                        <div class="variation-title">
                            <i class="ti ti-tags"></i> ${name}
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">@lang('Giá')</label>
                                <x-input-number name="variations[${id}][price]" :placeholder="__('Giá')" :required="true" value="${data.price || ''}" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">@lang('Giá khuyến mãi')</label>
                                <x-input-number name="variations[${id}][price_promotion]" data-parsley-lt="input[name='variations[${id}][price]']" :data-parsley-lt-message="trans('Giá khuyến mãi phải thấp hơn giá')" :placeholder="__('Giá khuyến mãi')" value="${data.price_promotion || ''}" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">@lang('Thời gian')</label>
                                <x-input name="variations[${id}][duration]" placeholder="Ví dụ: 30 ngày" :required="true" value="${data.duration || ''}" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">@lang('Trạng thái')</label>
                                <select class="form-select" name="variations[${id}][status]" :required="true">
                                    <option value="10" ${data.status == 10 ? 'selected' : ''}>@lang('Có sẵn')</option>
                                    <option value="20" ${data.status == 20 ? 'selected' : ''}>@lang('Hết hàng')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                `);
            });
        } else {
            $('#variation-data-container').hide();
        }
    }

    // Validate form khi submit
    $('form').on('submit', function(e) {
        if ($('.variation-option.selected').length === 0) {
            alert('Vui lòng chọn ít nhất một biến thể');
            e.preventDefault();
        }
    });
});

</script>
