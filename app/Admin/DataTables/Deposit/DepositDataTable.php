<?php

namespace App\Admin\DataTables\Deposit;

use App\Core\DataTables\DataTables;
use App\Core\Enums\Deposit\Status;
use App\Core\Enums\Deposit\Type;
use App\Models\Deposit;
use App\Models\Setting;

class DepositDataTable extends DataTables
{

    public function __construct(
        public Deposit  $model,
    ) {
    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['user_id', 'type', 'status', 'created_at'];
    }

    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['created_at'];
    }

    protected function setColumnSearchSelect(): void
    {
        $this->columnSearchSelect = [
            'type' => [
                'data' => Type::asSelectArray()
            ],

            'status' => [
                'data' => Status::asSelectArray()
            ]
        ];
    }

    public function query()
    {
        return $this->model->with(['user'])->whereHas('user')->where('created_at', '>=', now()->subDays(7))->orderByDesc('created_at');
    }

    public function setFilterColumns(): void
    {
        $this->filterColumns = [
            'user_id' => fn($q, $k) => $q->whereRelation('user', 'name', 'like', '%' . $k . '%'),

        ];
    }
    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'type' => 'admin.deposits.datatable.type',
            'status' => 'admin.deposits.datatable.status',
            'amount' => '{{ format_price($amount) }}',
            'user_id' => 'admin.deposits.datatable.user',
            'created_at' => '{{ date(config("core.format.date"), strtotime($created_at)) }}'
        ];
    }

    protected function setAddColumns(): void
    {
        $isCheck = Setting::where('setting_key', 'turn_off_turn_on')->value('plain_value');
        $this->addColumns = [
            'action' => fn($row) => view('admin.deposits.datatable.action')->with('data', $row)->with('isCheck',!!$isCheck),
        ];
    }

    protected function setRawColumns(): void
    {
    $this->rawColumns = ['status', 'action'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'user_id' => [
                'title' => 'user',
                'orderable' => false,
                'addClass' => 'align-middle'
            ],
            'type' => [
                'title' => 'Loại',
                'orderable' => false,
                'addClass' => 'align-middle'
            ],
            'amount' => [
                'title' => 'Số tiền',
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
                'visible' => false,
                'addClass' => 'align-middle',
            ],
            'action' => [
                'title' => 'action',
                'orderable' => false,
                'exportable' => false,
                'printable' => false,
                'addClass' => 'text-center'
            ],
        ];
    }
}
