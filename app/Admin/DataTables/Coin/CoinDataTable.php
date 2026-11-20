<?php

namespace App\Admin\DataTables\Coin;

use App\Core\DataTables\DataTables;
use App\Core\Enums\DefaultStatus;
use App\Core\Enums\Voucher\VoucherStatus;
use App\Core\Enums\Voucher\VoucherType;
use App\Core\Repositories\Coin\CoinRepositoryInterface;
use App\Core\Repositories\QA\QARepositoryInterface;
use App\Core\Repositories\Voucher\VoucherRepositoryInterface;
use App\Models\Attribute;

class CoinDataTable extends DataTables
{

    public function __construct(
        public CoinRepositoryInterface $repository
    ) {
    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['coin_name','code', 'status', 'created_at'];
    }

    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['created_at'];
    }

    protected function setColumnSearchSelect(): void
    {
        $this->columnSearchSelect = [
            'status' => [
                'data' => DefaultStatus::asSelectArray()
            ],
        ];
    }

    public function query()
    {
        return $this->repository->getByQueryBuilder([], []);
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'icon' => 'admin.coins.datatable.feature-image',
            'status' => 'admin.coins.datatable.status',
            'created_at' => '{{ date(config("core.format.date"), strtotime($created_at)) }}',
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'action' => 'admin.coins.datatable.action',
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['icon','action', 'status'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'icon' => [
                'title' => 'Icon',
                'orderable' => false,
            ],
            'coin_name' => [
                'title' => 'Coin Name',
                'orderable' => false,
            ],
            'code' => [
                'title' => 'Code',
                'orderable' => false,
            ],
            'status' => [
                'title' => 'Trạng thái',
                'orderable' => false,
            ],
            'created_at' => [
                'title' => 'createdAt',
                'orderable' => false,
                'visible' => false,
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
