<?php

namespace App\Admin\DataTables\Order;

use App\Core\DataTables\DataTables;
use App\Core\Enums\DefaultStatus;
use App\Core\Enums\Voucher\VoucherStatus;
use App\Core\Enums\Voucher\VoucherType;
use App\Core\Repositories\Voucher\VoucherRepositoryInterface;
use App\Models\Attribute;

class VoucherDataTable extends DataTables
{

    public function __construct(
        public VoucherRepositoryInterface $repository
    ) {
    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['code', 'status', 'created_at', 'type'];
    }

    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['created_at'];
    }

    protected function setColumnSearchSelect(): void
    {
        $this->columnSearchSelect = [
            'status' => [
                'data' => VoucherStatus::asSelectArray()
            ],
            'type' => [
                'data' => VoucherType::asSelectArray()
            ],
        ];
    }

    public function query()
    {
        return $this->repository->getByQueryBuilder([], ['memberLevel']);
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'status' => 'admin.vouchers.datatable.status',
            'type' => 'admin.vouchers.datatable.type',
            'created_at' => '{{ date(config("core.format.date"), strtotime($created_at)) }}',
            'start_date' => '{{ date(config("core.format.date"), strtotime($start_date)) }}',
            'end_date' => '{{ date(config("core.format.date"), strtotime($end_date)) }}',
            //'member_level_id' => 'admin.vouchers.datatable.memberLevel',
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'status_of_use' => 'admin.vouchers.datatable.status-of-use',
            'action' => 'admin.vouchers.datatable.action',
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['action', 'status', 'type', 'status_of_use'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'code' => [
                'title' => 'Code',
                'orderable' => false,
            ],
            'type' => [
                'title' => 'Loại',
                'orderable' => false,
            ],
            'value' => [
                'title' => 'Giá trị',
                'orderable' => false,
                'addClass' => 'text-center'
            ],
            'status_of_use' => [
                'title' => 'Tình trạng sử dụng',
                'orderable' => false,
                'addClass' => 'text-center'
            ],
            'start_date' => [
                'title' => 'Ngày bắt đầu',
                'orderable' => false,
            ],
            'end_date' => [
                'title' => 'Ngày kết thúc',
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
