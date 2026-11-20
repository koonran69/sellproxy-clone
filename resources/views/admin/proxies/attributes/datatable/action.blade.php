@adminaccessroutename('admin.proxy.attribute.edit')
    <button type="button" data-route="{{ route('admin.proxy.attribute.edit', $id) }}"
        class="btn btn-icon btn-warning open-modal-form">
        <i class="ti ti-edit"></i>
    </button>
@endadminaccessroutename

@adminaccessroutename('admin.proxy.attribute.delete')
    <button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="attribute"
        data-route="{{ route('admin.proxy.attribute.delete', $id) }}" data-target="#modalAjaxDelete">
        <i class="ti ti-trash"></i>
    </button>
@endadminaccessroutename
