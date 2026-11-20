@adminaccessroutename('admin.coin.edit')
<a href="{{ route('admin.coin.edit', $id) }}" class="btn btn-icon btn-warning">
    <i class="ti ti-edit"></i>
</a>
@endadminaccessroutename

@adminaccessroutename('admin.coin.delete')
<button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="coin" data-route="{{route('admin.coin.delete', $id) }}" data-target="#modalAjaxDelete">
    <i class="ti ti-trash"></i>
</button>
@endadminaccessroutename
