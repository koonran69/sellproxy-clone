@adminaccessroutename('admin.proxy.variation.edit')
    <button type="button" data-route="{{ route('admin.proxy.variation.edit', $id) }}"
        class="btn btn-icon btn-warning open-modal-form">
        <i class="ti ti-edit"></i>
    </button>
@endadminaccessroutename

@adminaccessroutename('admin.proxy.variation.delete')
    <button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="variation"
        data-route="{{ route('admin.proxy.variation.delete', $id) }}" data-target="#modalAjaxDelete">
        <i class="ti ti-trash"></i>
    </button>
@endadminaccessroutename
