<script>
    $(document).on('keyup', 'input[name="amount"]', function() {
        var formattedValue = format_number($(this).val());
        $(this).val(formattedValue);
    });

    function format_number(value) {
        value = value + '';
        if ((value.match(/,/g) || []).length > 1) {
            //console.log(value);
            value = value.replace(/,(?=.*?)/g, '');
        }
        var components = value.split(",");
        for (var i = 0; i < components.length; i++) {
            components[i] = components[i].replace(/[^\d]/g, "");
        }
        //console.log(components);
        components[0] = components[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        return components.join(",");
    }
</script>
