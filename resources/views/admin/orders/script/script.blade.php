<x-input type="hidden" name="route_render_info_user" :value="route('admin.order.render_info_user')" />
<x-input type="hidden" name="route_search_render_product" :value="route('admin.order.search.render_product')" />
<x-input type="hidden" name="route_add_product" :value="route('admin.order.add_product')" />
<script>
    $(document).on('change', 'select[name="user_id"]', function(e) {
        var url = $('input[name="route_render_info_user"]').val();
        url_role = $('input[name="route_check_user_role"]').val(),
            userId = $(this).val();
        if (userId) {
            $.ajax({
                type: "GET",
                url: url,
                data: {
                    user_id: userId
                },
                success: function(response) {
                    console.log(response);
                    $("#infoUser").html(response);
                },
                error: function(response) {
                    handleAjaxError(response);
                }
            })

        }
    });


    $(document).ready(function(e) {
        searchProduct('', '#showSearchResultProduct');
        $("#inputSearchProduct").keyup($.debounce(500, function(e) {
            searchProduct($(this).val(), '#showSearchResultProduct');
        }));
    });

    function searchProduct(keyword, elmRender) {
        $.ajax({
            type: "GET",
            url: $('input[name="route_search_render_product"]').val(),
            data: {
                key: keyword
            },
            success: function(response) {
                $(elmRender).html(response);
            },
            error: function(response) {
                handleAjaxError(response);
            }
        })
    }

    $(document).on('click', '.add-product', function(e) {
        var that = $(this),
            productId = that.data('product-id'),
            variationId = that.closest('.list-group-item').find('select[name="proxy_variation"]').val();

        if (checkAddProduct(productId, variationId)) {
            msgWarning('Biến thể của proxy này đã được thêm');
            return;
        }
        addProduct({
            product_id: productId,
            product_variation_id: variationId
        });
    });

    function checkAddProduct(productId, variationId) {
        var selector = '#tableProduct tbody tr.item-product.product-' + productId + '.variation-' + variationId;
        return $(selector).length > 0;
    }


    function addProduct(payload) {
        var url = $('input[name="route_add_product"]').val();

        closeModal('#modalAddProduct');
        $.ajax({
            type: "GET",
            url: url,
            data: payload,
            success: function(response) {
                $('#tableProduct tbody').prepend(response.data);
                $('#tableProduct tbody tr.no-product').hide();
                updateTotalOrder();
            },
            error: function(response) {
                handleAjaxError(response);
            }
        })
    }

    function updateTotalOrder() {
        var subTotal = 0;

        $('#tableProduct tbody tr.item-product').each(function() {
            var row = $(this);
            var quantity = parseInt(row.find('.quantity').val()) || 0;
            var price = parseFloat(row.find('.quantity').data('price')) || 0;

            subTotal += quantity * price;
        });

        var formattedSubTotal = formatPrice(subTotal);
        var formattedTotal = formatPrice(subTotal);

        $('#tableTotalOrder tbody tr:nth-child(1) td:last-child').text(formattedSubTotal);
        $('#tableTotalOrder tbody tr:nth-child(2) td:last-child').text(formattedTotal);
    }

    function closeModal(modal) {
        $(modal).find('.btn-close').trigger('click');
    }

    $(document).on('click', '.change-quantity', function() {
        var button = $(this);
        var row = button.closest('tr');
        var input = row.find('.quantity');
        var price = parseFloat(input.data('price'));
        var quantity = parseInt(input.val());

        if (button.data('type') === 'plus') {
            quantity++;
        } else if (button.data('type') === 'minus' && quantity > 1) {
            quantity--;
        }

        input.val(quantity);
        row.find('.total-price').text(formatPrice(price * quantity));
        updateTotalOrder();
    });

    $(document).on('click', '.remove-item-product', function(e) {
        if (!confirm('Bạn có chắc là muốn thực hiện?')) {
            return;
        }
        removeElmItemOrderDetail(this)
        updateTotalOrder();
    })

    function removeElmItemOrderDetail(elm) {
        $(elm).parents('.item-product').remove();
        if ($('#tableProduct tbody tr.item-product').length == 0) {
            $('#tableProduct tbody tr.no-product').show();
        }
    }
</script>
