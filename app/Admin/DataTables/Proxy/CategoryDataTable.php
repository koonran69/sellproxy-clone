<?php

namespace App\Admin\DataTables\Proxy;

use App\Core\DataTables\DataTables;
use App\Core\Enums\DefaultStatus;
use App\Models\ProxyCategory;

class CategoryDataTable extends DataTables
{

    public function __construct(
        public ProxyCategory $model
    ) {
    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['name', 'status', 'created_at'];
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
            ]
        ];
    }

    public function query()
    {
        return $this->model->makeQuery();
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'name' => 'admin.proxies.categories.datatable.name',
            'status' => 'admin.commons.datatable.status',
            'feature_image' => 'admin.proxies.categories.datatable.feature-image',
            'created_at' => '{{ date(config("core.format.date"), strtotime($created_at)) }}'
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'action' => 'admin.proxies.categories.datatable.action',
            'languages' => 'admin.proxies.categories.datatable.languages',
        ];
    }

    protected function setRawColumns(): void
    {
    $this->rawColumns = ['status', 'action', 'feature_image', 'name', 'languages'];
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
                'title' => 'Tên danh mục',
                'orderable' => false,
                'addClass' => 'align-middle'
            ],
            'status' => [
                'title' => 'Trạng thái',
                'orderable' => false,
                'addClass' => 'align-middle'
            ],
            'created_at' => [
                'title' => 'createdAt',
                'orderable' => false,
                'visible' => false,
                'addClass' => 'align-middle',
            ],
            'languages' => [
                'title' => '<div class="d-flex gap-3 justify-content-center"><span class="flag-vi"></span> <span class="flag-en"></span></div>',
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