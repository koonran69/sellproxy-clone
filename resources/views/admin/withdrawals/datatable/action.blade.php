@adminaccessroutename('admin.withdrawal.reject')
@if ($status == \App\Core\Enums\WithdrawalStatus::Pending->value)
    <button type="button" class="btn-sm btn btn-danger btn-icon open-modal-confirm-update p-1" data-load-dt="true"
            data-table-id="deposit" data-route="{{ route('admin.withdrawal.reject', $id) }}"
            data-target="#modalAjaxConfirmUpdate">
        <i class="ti ti-circle-check"></i>
        Từ chối
    </button>
@endif
@endadminaccessroutename
@adminaccessroutename('admin.withdrawal.accept')
    @if ($status == \App\Core\Enums\WithdrawalStatus::Pending->value)
        <button type="button" class="btn-sm btn btn-success btn-icon open-modal-confirm-update p-1" data-load-dt="true"
            data-table-id="deposit" data-route="{{ route('admin.withdrawal.accept', $id) }}"
            data-target="#modalAjaxConfirmUpdate">
            <i class="ti ti-circle-check"></i>
            Duyệt
        </button>
    @endif
@endadminaccessroutename
