
@adminaccessroutename('admin.blog.category.edit')
<button type="button" data-route="{{ route('admin.blog.category.edit', $id) }}" class="btn btn-icon btn-warning open-modal-form">
    <i class="ti ti-edit"></i>
</button>
@endadminaccessroutename


@adminaccessroutename('admin.blog.category.delete')
    <button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="category" data-route="{{ route('admin.blog.category.delete', $id) }}" data-target="#modalAjaxDelete">
        <i class="ti ti-trash"></i>
    </button>
@endadminaccessroutename
