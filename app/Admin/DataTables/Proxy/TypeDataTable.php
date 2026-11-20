<?php

namespace App\Admin\DataTables\Proxy;

use App\Core\DataTables\DataTables;
use App\Core\Enums\DefaultStatus;
use App\Models\ProxyType;

class TypeDataTable extends DataTables
{

    public function __construct(
        public ProxyType $model
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
            'status' => 'admin.commons.datatable.status',
            'feature_image' => 'admin.proxies.types.datatable.feature-image',
            'created_at' => '{{ date(config("core.format.date"), strtotime($created_at)) }}'
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'action' => 'admin.proxies.types.datatable.action',
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
                'title' => 'Tên loại',
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