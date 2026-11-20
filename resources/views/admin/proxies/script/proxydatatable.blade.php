<script>
    $(document).on('change', '.variation-select', function() {
        let rowId = $(this).data('row-id');
        let selectedOption = $(this).find('option:selected');
        let price = selectedOption.data('price') || 0;

        let formattedPrice = formatPrice(price);

        let usdPrice = convertVNDToUSD(price);

        $('.variation-price[data-row-id="' + rowId + '"]').text(formatPrice(price))
        $('.data-dolar[data-row-id="' + rowId + '"]').text(usdPrice);
    });
</script>
