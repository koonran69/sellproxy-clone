@adminaccessroutename('admin.tutorial.post.edit')
    <a href="{{ route('admin.tutorial.post.edit', $id) }}" class="btn btn-icon btn-warning">
        <i class="ti ti-edit"></i>
    </a>
@endadminaccessroutename
@adminaccessroutename('admin.tutorial.post.delete')
    <button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="post" data-route="{{ route('admin.tutorial.post.delete', $id) }}" data-target="#modalAjaxDelete">
        <i class="ti ti-trash"></i>
    </button>
@endadminaccessroutename
