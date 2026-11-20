<?php

namespace App\Admin\DataTables\Proxy;

use App\Core\DataTables\DataTables;
use App\Core\Enums\ProxyStatus;
use App\Core\Repositories\Proxy\ProxyRepositoryInterface;

class ProxyDataTable extends DataTables
{

    public function __construct(
        public ProxyRepositoryInterface $repository
    ) {
    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['name', 'created_at', 'category_id', 'status'];
    }

    protected function setColumnSearchSelect(): void
    {
        $this->columnSearchSelect = [
            'status' => [
                'data' => ProxyStatus::asSelectArray()
            ]
        ];
    }

    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['created_at'];
    }

    public function query()
    {
        return $this->repository->getByQueryBuilder([], ['variations', 'category']);
    }

    protected function setFilterColumns(): void
    {
        $this->filterColumns = [
            'category_id' => fn($q, $k) => $q->whereRelation('category', 'name', 'like', '%' . $k . '%'),
        ];
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'created_at' => '{{ date(config("core.format.date"), strtotime($created_at)) }}',
            'feature_image' => 'admin.proxies.datatable.feature-image',
            'status' => 'admin.proxies.datatable.status',
            'category_id' => 'admin.proxies.datatable.category',
            'name' => 'admin.proxies.datatable.name',

        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'variations' => 'admin.proxies.datatable.variations',
            'price' => 'admin.proxies.datatable.price',
            'action' => 'admin.proxies.datatable.action',
            'languages' => 'admin.proxies.datatable.languages',
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['action', 'feature_image', 'variations', 'status', 'price', 'name', 'languages'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'feature_image' => [
                'title' => 'Hình thu nhỏ',
                'orderable' => false,
                'addClass' => 'align-middle text-center',
                'width' => '50px'
            ],
            'name' => [
                'title' => 'name',
                'orderable' => false,
            ],
            'category_id' => [
                'title' => 'Danh mục',
                'orderable' => false,
            ],
            'variations' => [
                'title' => 'Số lượng',
                'orderable' => false,
            ],
            'status' => [
                'title' => 'Hiện có',
                'orderable' => false,
                'addClass' => 'text-center'
            ],
            'price' => [
                'title' => 'Giá',
                'orderable' => false,
                'addClass' => 'text-center'
            ],

            'languages' => [
                'title' => '<div class="d-flex gap-3 justify-content-center"><span class="flag-vi"></span> <span class="flag-en"></span></div>',
                'orderable' => false,
            ],
            'created_at' => [
                'title' => 'Ngày tạo',
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
