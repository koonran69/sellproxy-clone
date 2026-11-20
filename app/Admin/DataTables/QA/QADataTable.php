<?php

namespace App\Admin\DataTables\QA;

use App\Core\DataTables\DataTables;
use App\Core\Enums\DefaultStatus;
use App\Core\Enums\Voucher\VoucherStatus;
use App\Core\Enums\Voucher\VoucherType;
use App\Core\Repositories\QA\QARepositoryInterface;
use App\Core\Repositories\Voucher\VoucherRepositoryInterface;
use App\Models\Attribute;

class QADataTable extends DataTables
{

    public function __construct(
        public QARepositoryInterface $repository
    ) {
    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['question', 'status', 'created_at'];
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
            'status' => 'admin.qas.datatable.status',
            'created_at' => '{{ date(config("core.format.date"), strtotime($created_at)) }}',
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'action' => 'admin.qas.datatable.action',
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['action', 'status'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'question' => [
                'title' => 'Câu hỏi',
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
