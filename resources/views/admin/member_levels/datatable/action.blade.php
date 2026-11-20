@adminaccessroutename('admin.member_level.edit')
    <button type="button" data-route="{{ route('admin.member_level.edit', $id) }}" class="btn btn-icon btn-warning open-modal-form">
        <i class="ti ti-edit"></i>
    </button>
@endadminaccessroutename
@adminaccessroutename('admin.member_level.delete')
    <button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="member_level" data-route="{{ route('admin.member_level.delete', $id) }}" data-target="#modalAjaxDelete">
        <i class="ti ti-trash"></i>
    </button>
@endadminaccessroutename
