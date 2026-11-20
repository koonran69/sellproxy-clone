@adminaccessroutename('admin.permission.edit')
    <button type="button" data-route="{{ route('admin.permission.edit', $id) }}" class="btn btn-icon btn-warning open-modal-form">
        <i class="ti ti-edit"></i>
    </button>
@endadminaccessroutename
@adminaccessroutename('admin.permission.delete')
    <button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="permission" data-route="{{ route('admin.permission.delete', $id) }}" data-target="#modalAjaxDelete">
        <i class="ti ti-trash"></i>
    </button>
@endadminaccessroutename
