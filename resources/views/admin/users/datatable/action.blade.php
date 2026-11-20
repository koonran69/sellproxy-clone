@adminaccessroutename('admin.user.edit')
<a href="{{ route('admin.user.edit', $id) }}" class="btn btn-icon btn-warning">
    <i class="ti ti-edit"></i>
</a>
@endadminaccessroutename

@adminaccessroutename('admin.user.delete')
<button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="user" data-route="{{ route('admin.user.delete', $id) }}" data-target="#modalAjaxDelete">
    <i class="ti ti-trash"></i>
</button>
@endadminaccessroutename