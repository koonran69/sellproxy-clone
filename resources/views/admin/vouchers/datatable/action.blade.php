@adminaccessroutename('admin.voucher.edit')
<a href="{{ route('admin.voucher.edit', $id) }}" class="btn btn-icon btn-warning">
    <i class="ti ti-edit"></i>
</a>
@endadminaccessroutename

@adminaccessroutename('admin.voucher.delete')
<button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="voucher" data-route="{{ route('admin.voucher.delete', $id) }}" data-target="#modalAjaxDelete">
    <i class="ti ti-trash"></i>
</button>
@endadminaccessroutename