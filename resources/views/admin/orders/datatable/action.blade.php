@adminaccessroutename('admin.order.edit')
<a href="{{ route('admin.order.edit', $id) }}" class="btn btn-icon btn-info">
    <i class="ti ti-eye"></i>
</a>
@endadminaccessroutename

@adminaccessroutename('admin.order.delete')
<button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="order_datatable" data-route="{{ route('admin.order.delete', $id) }}" data-target="#modalAjaxDelete">
    <i class="ti ti-trash"></i>
</button>
@endadminaccessroutename