<table id="tableTotalOrder" class="table table-transparent table-responsive">
    <tbody>
        <tr>
            <td colspan="4" class="strong text-end">{{ __('Tạm tính') }}</td>
            <td class="text-end">{{ format_price($sub_total ?? 0) }}</td>
        </tr>
        <tr>
            <td colspan="4" class="font-weight-bold text-uppercase text-end">{{ __('Tổng cộng') }}</td>
            <td class="text-end">{{ format_price($total ?? 0) }}</td>
        </tr>
    </tbody>
</table>
