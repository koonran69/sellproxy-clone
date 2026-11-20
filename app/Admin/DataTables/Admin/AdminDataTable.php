<?php

namespace App\Admin\DataTables\Admin;

use App\Core\DataTables\DataTables;
use App\Core\Enums\Gender;
use App\Core\Repositories\Admin\AdminRepositoryInterface;

class AdminDataTable extends DataTables
{

    public function __construct(
        public AdminRepositoryInterface $repository
    ){
    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['fullname', 'phone', 'email', 'gender', 'created_at'];
    }

    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['created_at'];
    }

    protected function setColumnSearchSelect(): void
    {
        $this->columnSearchSelect = [
            'gender' => [
                'data' => Gender::asSelectArray()
            ]
        ];
    }
    
    public function query()
    {
        return $this->repository->orderBy('id', 'desc');
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'fullname' => 'admin.admins.datatable.fullname',
            'created_at' => '{{ date(config("core.format.date"), strtotime($created_at)) }}'
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'action' => 'admin.admins.datatable.action',
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['fullname', 'action'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'fullname' => [
                'title' => 'fullname',
                'orderable' => false,
            ],
            'phone' => [
                'title' => 'phone',
                'orderable' => false,
            ],
            'email' => [
                'title' => 'email',
                'orderable' => false,
            ],
            'gender' => [
                'title' => 'Gender',
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
            ]
        ];
    }
}