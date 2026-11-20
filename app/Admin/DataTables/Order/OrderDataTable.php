<?php

namespace App\Admin\DataTables\Order;

use App\Core\DataTables\DataTables;
use App\Core\Enums\Order\OrderStatus;
use App\Core\Repositories\Order\OrderRepositoryInterface;

class OrderDataTable extends DataTables
{

    public function __construct(
        public OrderRepositoryInterface $repository
    ) {
    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['code', 'user_id', 'name', 'created_at', 'category_id', 'status'];
    }

    protected function setColumnSearchSelect(): void
    {
        $this->columnSearchSelect = [
            'status' => [
                'data' => OrderStatus::asSelectArray()
            ]
        ];
    }

    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['created_at'];
    }

    public function query()
    {
        return $this->repository->getByQueryBuilder([], ['user'])->whereHas('user');
    }

    protected function setFilterColumns(): void
    {
        $this->filterColumns = [
            'user_id' => fn($q, $k) => $q->whereRelation('user', 'name', 'like', '%' . $k . '%'),
        ];
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'created_at' => '{{ date(config("core.format.date"), strtotime($created_at)) }}',
            'user_id' => 'admin.orders.datatable.user',
            'status' => 'admin.orders.datatable.status',
            'total' => '{{ format_price($total) }}',

        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'data' => 'admin.orders.datatable.data',
            'action' => 'admin.orders.datatable.action',
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['action', 'data', 'status'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'code' => [
                'title' => 'Code',
                'orderable' => false,
                'addClass' => 'align-middle',
            ],
            'user_id' => [
                'title' => 'Khách hàng',
                'orderable' => false,
            ],
            'data' => [
                'title' => 'Chi tiết',
                'orderable' => false,
                'width' => '200px'
            ],
            'total' => [
                'title' => 'Tổng tiền',
                'orderable' => false,
                'addClass' => 'text-center'
            ],
            'status' => [
                'title' => 'Trạng thái',
                'orderable' => false,
            ],
            'created_at' => [
                'title' => 'Ngày đặt',
                'orderable' => false,
                'visible' => true,
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
