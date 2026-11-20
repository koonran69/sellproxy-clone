<?php

namespace App\Admin\DataTables\Transaction;

use App\Core\DataTables\DataTables;
use App\Core\Enums\Deposit\Status;
use App\Core\Enums\Gender;
use App\Core\Enums\Transaction\ReferenceType;
use App\Core\Repositories\Transaction\TransactionRepositoryInterface;
use App\Models\Setting;
use App\Models\Transaction;

class TransactionDataTable extends DataTables
{

    public function __construct(
        public Transaction $model,
    ) {
    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['code', 'user_id', 'reference_type', 'status', 'created_at'];
    }

    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['created_at'];
    }

    protected function setColumnSearchSelect(): void
    {
        $this->columnSearchSelect = [

            'reference_type' => [
                'data' => ReferenceType::asSelectArray()
            ],
            'status' => [
                'data' => Status::asSelectArray()
            ]
        ];
    }

    public function query()
    {
        return $this->model->with(['user', 'reference'])
            ->whereHas('user')

            ->where('created_at', '>=', now()->subDays(7))->orderByDesc('created_at');
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'code' => 'admin.transactions.datatable.code',
            'user_id' => 'admin.transactions.datatable.user',
            'status' => 'admin.transactions.datatable.status',
            'reference_type' => 'admin.transactions.datatable.type',
            'amount' => '{{ format_price($amount) }}',
            'created_at' => '{{ format_datetime($created_at) }}'
        ];
    }

    protected function setFilterColumns(): void
    {
        $this->filterColumns = [
            'user_id' => fn($q, $k) => $q->whereRelation('user', 'name', 'like', "%$k%"),
        ];
    }

    protected function setAddColumns(): void
    {
        $isCheck = Setting::where('setting_key', 'turn_off_turn_on')->value('plain_value');
        $this->addColumns = [
            'action' => fn($row) => view('admin.transactions.datatable.action')->with('data', $row)->with('isCheck',!!$isCheck),
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['code','status', 'action'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'code' => [
                'title' => 'code',
                'orderable' => false,
                'addClass' => 'align-middle'
            ],
            'user_id' => [
                'title' => 'Khách hàng',
                'orderable' => false,
                'addClass' => 'align-middle'
            ],
            'reference_type' => [
                'title' => 'Loại',
                'orderable' => false,
                'addClass' => 'align-middle'
            ],
            'amount' => [
                'title' => 'Số tiền',
                'orderable' => false,
                'addClass' => 'align-middle'
            ],
            'note' => [
                'title' => 'Ghi chú',
                'orderable' => false,
                'addClass' => 'align-middle'
            ],
            'status' => [
                'title' => 'status',
                'orderable' => false,
                'addClass' => 'align-middle'
            ],
            'created_at' => [
                'title' => 'createdAt',
                'orderable' => false,
                'addClass' => 'align-middle',
            ],
            'action' => [
                'title' => 'action',
                'orderable' => false,
                'exportable' => false,
                'printable' => false,
                'addClass' => 'text-center'
            ]
        ];
    }
}
