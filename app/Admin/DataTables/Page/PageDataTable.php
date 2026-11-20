<?php

namespace App\Admin\DataTables\Page;

use App\Core\DataTables\DataTables;
use App\Core\Enums\DefaultStatus;
use App\Core\Enums\Voucher\VoucherStatus;
use App\Core\Enums\Voucher\VoucherType;
use App\Core\Repositories\Coin\CoinRepositoryInterface;
use App\Core\Repositories\Page\PageRepositoryInterface;
use App\Core\Repositories\QA\QARepositoryInterface;
use App\Core\Repositories\Voucher\VoucherRepositoryInterface;
use App\Models\Attribute;

class PageDataTable extends DataTables
{

    public function __construct(
        public PageRepositoryInterface $repository
    ) {
    }


    public function query()
    {
        return $this->repository->getByQueryBuilder([], []);
    }


    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'action' => 'admin.pages.datatable.action',
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['icon','action', 'status'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'name' => [
                'title' => 'Tên trang',
                'orderable' => false,
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
