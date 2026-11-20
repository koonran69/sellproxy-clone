<?php

namespace App\Admin\DataTables\Proxy;

use App\Core\DataTables\DataTables;
use App\Core\Enums\DefaultStatus;
use App\Models\Attribute;

class AttributeDataTable extends DataTables
{

    public function __construct(
        public Attribute $model
    ) {
    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['name', 'created_at'];
    }

    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['created_at'];
    }

    public function query()
    {
        return $this->model->makeQuery([], ['variations']);
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'created_at' => '{{ date(config("core.format.date"), strtotime($created_at)) }}'
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'variations' => 'admin.proxies.attributes.datatable.variation',
            'action' => 'admin.proxies.attributes.datatable.action',
        ];
    }

    protected function setRawColumns(): void
    {
    $this->rawColumns = ['action', 'variations'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'name' => [
                'title' => 'name',
                'orderable' => false,
            ],
            'slug' => [
                'title' => 'slug',
                'orderable' => false,
            ],
            'variations' => [
                'title' => 'variations',
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