@adminaccessroutename('admin.deposit.edit')
    <button type="button" data-route="{{ route('admin.deposit.edit', $data->id) }}" class="btn btn-icon btn-info open-modal-form">
        <i class="ti ti-info-circle"></i>
    </button>
@endadminaccessroutename

@adminaccessroutename('admin.deposit.accept')
    @if ($data->status == App\Core\Enums\Deposit\Status::Pending->value)
        <button type="button" class="btn btn-success btn-icon open-modal-confirm-update" data-load-dt="true"
            data-table-id="deposit" data-route="{{ route('admin.deposit.accept', $data->id) }}"
            data-target="#modalAjaxConfirmUpdate">
            <i class="ti ti-circle-check"></i>
        </button>
    @endif
@endadminaccessroutename

@if($isCheck)
    @adminaccessroutename('admin.deposit.delete')
    <button class="btn btn-icon btn-danger open-modal-delete" data-load-dt="true" data-table-id="deposit" data-route="{{ route('admin.deposit.delete', $data->id) }}" data-target="#modalAjaxDelete">
    <i class="ti ti-trash"></i>
    </button>
    @endadminaccessroutename
@endif
