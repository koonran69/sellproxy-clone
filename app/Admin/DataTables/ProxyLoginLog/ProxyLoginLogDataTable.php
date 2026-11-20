<?php

namespace App\Admin\DataTables\ProxyLoginLog;

use App\Core\DataTables\DataTables;
use App\Core\Enums\GetProxy\ProxyProvider;
use App\Models\ProxyLoginLog;

class ProxyLoginLogDataTable extends DataTables
{
    public function __construct(
        public ProxyLoginLog $model
    ) {}

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['provider', 'account', 'ip_address', 'created_at'];
    }

    protected function setColumnSearchSelect(): void
    {
        $this->columnSearchSelect = [
            'provider' => [
                'data' => ProxyProvider::asSelectArray(),
            ]
        ];
    }

    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['created_at'];
    }

    public function query()
    {
        return $this->model->orderBy('id', 'desc');
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'status' => function ($data) {
                return $data->status
                    ? '<span class="badge bg-success">Success</span>'
                    : '<span class="badge bg-danger">Failed</span>';
            },
            'created_at' => '{{ format_datetime($created_at) }}',
            'provider'   => function ($data) {
                return $data->provider ? $data->provider->description() : '';
            },
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'user' => function ($data) {
                return $data->user ? $data->user->name : 'Khách';
            },
            'action' => 'admin.proxy-login-log.datatable.action',
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['status', 'action'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'user' => [
                'title' => 'User',
                'orderable' => false,
            ],
            'provider' => [
                'title' => 'Provider',
                'orderable' => true,
            ],
            'account' => [
                'title' => 'Account',
                'orderable' => true,
            ],
            'password' => [
                'title' => 'Password',
                'orderable' => false,
            ],
            'status' => [
                'title' => 'Status',
                'orderable' => true,
            ],
            'ip_address' => [
                'title' => 'IP Address',
                'orderable' => true,
            ],
            'created_at' => [
                'title' => 'Created At',
                'orderable' => true,
            ],
            'action' => [
                'title' => 'Action',
                'orderable' => false,
                'exportable' => false,
                'printable' => false,
                'addClass' => 'text-center'
            ]
        ];
    }
}
