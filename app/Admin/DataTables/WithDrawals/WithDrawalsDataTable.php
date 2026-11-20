<?php

namespace App\Admin\DataTables\WithDrawals;

use App\Core\DataTables\DataTables;
use App\Core\Enums\Deposit\Status;
use App\Core\Enums\Deposit\Type;
use App\Core\Enums\WithdrawalStatus;
use App\Core\Repositories\Deposit\DepositRepositoryInterface;
use App\Core\Repositories\WithDrawals\WithDrawalsRepositoryInterface;

class WithDrawalsDataTable extends DataTables
{

    public function __construct(
        public WithDrawalsRepositoryInterface $repository
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
            'status' => [
                'data' => WithdrawalStatus::asSelectArray()
            ]
        ];
    }

    public function query()
    {
        return $this->repository->getByQueryBuilder([], ['user'])->whereHas('user');
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
            'status' => 'admin.withdrawals.datatable.status',
            'amount' => '{{ format_price($amount) }}',
            'user_id' => 'admin.withdrawals.datatable.user',
            'created_at' => '{{ date(config("core.format.date"), strtotime($created_at)) }}'
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'action' => 'admin.withdrawals.datatable.action',
        ];
    }

    protected function setRawColumns(): void
    {
    $this->rawColumns = ['status', 'action', 'user_id'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'user_id' => [
                'title' => 'user',
                'orderable' => false,
                'addClass' => 'align-middle'
            ],
            'amount' => [
                'title' => 'Số tiền rút',
                'orderable' => false,
                'addClass' => 'align-middle'
            ],
            'status' => [
                'title' => 'status',
                'orderable' => false,
                'addClass' => 'align-middle'
            ],
            'processed_at' => [
                'title' => 'Ngày duyệt',
                'orderable' => false,
                'addClass' => 'align-middle',
            ],
            'note' => [
                'title' => 'Ghi chú',
                'orderable' => false,
                'addClass' => 'align-middle',
            ],
            'created_at' => [
                'title' => 'Ngày yêu cầu',
                'orderable' => false,
                'addClass' => 'align-middle',
            ],
            'ip_address' => [
                'title' => 'Địa chỉ IP',
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
