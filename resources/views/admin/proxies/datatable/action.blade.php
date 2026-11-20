@adminaccessroutename('admin.proxy.edit')
<a href="{{ route('admin.proxy.edit', ['id' => $id, 'lang' => 'vi']) }}" class="btn btn-icon btn-warning">
    <i class="ti ti-edit"></i>
</a>
@endadminaccessroutename

@adminaccessroutename('admin.proxy.delete')
<button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="proxy_datatable" data-route="{{ route('admin.proxy.delete', $id) }}" data-target="#modalAjaxDelete">
    <i class="ti ti-trash"></i>
</button>
@endadminaccessroutename