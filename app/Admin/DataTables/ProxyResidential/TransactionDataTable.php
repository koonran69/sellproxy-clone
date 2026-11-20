<?php

namespace App\Admin\DataTables\ProxyResidential;

use App\Core\DataTables\DataTables;
use App\Core\Enums\Transaction\ReferenceType;
use App\Core\Enums\Transaction\TransactionStatus;
use App\Models\ProxyHomeOrder;
use App\Models\ProxyResidentialOrder;
use App\Models\Transaction;

class TransactionDataTable extends DataTables
{

    public function __construct(
        public Transaction $model
    ){
    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['code', 'user_id', 'status', 'note', 'created_at'];
    }

    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['created_at'];
    }

    protected function setFilterColumns(): void
    {
        $this->filterColumns = [
            'user_id' => fn($q, $k) => $q->whereRelation('user', 'name', 'like', "%$k%"),
        ];
    }

    protected function setColumnSearchSelect(): void
    {
        $this->columnSearchSelect = [
            'status' => [
                'data' => TransactionStatus::asSelectArray()
            ]
        ];
    }

    public function query()
    {
        return $this->model->makeQuery(filter: ['reference_type' => ProxyResidentialOrder::class], relations: ['user'])->whereHas('user');
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'user_id' => fn($row) => $row->user?->name,
            'created_at' => '{{ date(config("core.format.datetime"), strtotime($created_at)) }}',
            'amount' => '{{ format_price($amount) }}',
            'status' => fn($row) => sprintf("<span class=''>%s</span>", $row->status->description()),
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            // 'action' => 'admin.proxyhome.datatable.action',
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['action', 'status'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'code' => [
                'title' => 'Code',
                'orderable' => false,
            ],
            'user_id' => [
                'title' => 'User',
                'orderable' => false,
            ],
            'status' => [
                'title' => 'Trạng thái',
                'orderable' => false,
            ],
            'amount' => [
                'title' => 'Số tiền',
                'orderable' => false,
            ],
            'note' => [
                'title' => 'Nội dung',
                'orderable' => false,
            ],
            'created_at' => [
                'title' => 'createdAt',
                'orderable' => false,
                'visible' => false,
            ],
            // 'action' => [
            //     'title' => 'action',
            //     'orderable' => false,
            //     'exportable' => false,
            //     'printable' => false,
            //     'addClass' => 'text-center'
            // ]
        ];
    }
}
