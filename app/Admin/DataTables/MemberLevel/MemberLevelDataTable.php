<?php

namespace App\Admin\DataTables\MemberLevel;

use App\Core\DataTables\DataTables;
use App\Models\MemberLevel;

class MemberLevelDataTable extends DataTables
{
    public function __construct(
        public MemberLevel $model
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
        return $this->model->newQuery()->orderBy('position', 'asc');
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'plain_value' => '{{ format_price($plain_value) }}',
            'created_at' => '{{ date(config("core.format.date"), strtotime($created_at)) }}',
            'feature_image' => 'admin.member_levels.datatable.feature-image',
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'action' => 'admin.member_levels.datatable.action',
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['action', 'feature_image'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'feature_image' => [
                'title' => 'Hình',
                'orderable' => false,
                'addClass' => 'align-middle text-center',
                'width' => '50px'
            ],
            'name' => [
                'title' => 'Name',
                'orderable' => false,
            ],
            'plain_value' => [
                'title' => 'Giá trị',
                'orderable' => false,
            ],
            'created_at' => [
                'title' => 'Created at',
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