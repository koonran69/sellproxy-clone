@adminaccessroutename('admin.proxyline.edit')
<a href="{{ route('admin.proxyline.edit', $id) }}" class="btn btn-icon btn-warning">
    <i class="ti ti-edit"></i>
</a>
@endadminaccessroutename

@adminaccessroutename('admin.proxyline.delete')
<button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="qa" data-route="{{route('admin.proxyline.delete', $id) }}" data-target="#modalAjaxDelete">
    <i class="ti ti-trash"></i>
</button>
@endadminaccessroutename
