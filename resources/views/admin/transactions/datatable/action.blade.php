@if($isCheck)
    @adminaccessroutename('admin.transaction.delete')
    <button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="transaction" data-route="{{ route('admin.transaction.delete', $data->id) }}" data-target="#modalAjaxDelete">
        <i class="ti ti-trash"></i>
    </button>
    @endadminaccessroutename
@endif
