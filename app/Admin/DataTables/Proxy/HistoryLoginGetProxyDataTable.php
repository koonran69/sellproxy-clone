<?php

namespace App\Admin\DataTables\Proxy;

use App\Core\DataTables\DataTables;
use App\Core\Enums\GetProxy\ProxyProvider;
use App\Core\Enums\Transaction\ReferenceType;
use App\Core\Enums\Transaction\TransactionStatus;
use App\Models\ProxyConnectionLog;
use App\Models\ProxyHomeOrder;
use App\Models\ProxyResidentialOrder;
use App\Models\Transaction;

class HistoryLoginGetProxyDataTable extends DataTables
{

    public function __construct(
        public ProxyConnectionLog $model
    ){
    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['username', 'email', 'is_success', 'provider', 'ip_address', 'created_at'];
    }

    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['created_at'];
    }

    protected function setFilterColumns(): void
    {
        $this->filterColumns = [
            'username' => fn($q, $k) => $q->where('username', 'like', "%$k%"),
            'is_success' => fn($q, $k) => $q->where('is_success', $k),
            'provider' => fn($q, $k) => $q->where('provider', $k),
        ];
    }

    protected function setColumnSearchSelect(): void
    {
        $this->columnSearchSelect = [
            'is_success' => [
                'data' => [
                    '1' => 'Thành công',
                    '0' => 'Thất bại'
                ]
            ],
            'provider' => [
                'data' => ProxyProvider::asSelectArray()
            ]
        ];
    }

    public function query()
    {
        return $this->model->newQuery()->latest();
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'password' => fn($row) => sprintf(
                '<span class="text-info cursor-pointer" onclick="alert(\'%s\')">Click để xem</span>',
                e($row->password)
            ),

            'is_success' => fn($row) => $row->is_success
                ? '<span class="badge badge-success border-0">Thành công</span>'
                : '<span class="badge badge-danger border-0">Thất bại</span>',

            'created_at' => '{{ date(config("core.format.datetime"), strtotime($created_at)) }}',

            'provider' => fn($row) => $row->provider->description(),

            'response_data' => fn($row) => sprintf(
                '<small class="text-muted">%s</small>',
                str($row->response_data['message'] ?? 'N/A')->limit(50)
            ),
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['is_success', 'password', 'response_data', 'created_at', 'provider'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'id' => [
                'title' => 'ID',
                'orderable' => false,
            ],
            'provider' => [
                'title' => 'Nhà cung cấp',
                'orderable' => false,
            ],
            'username' => [
                'title' => 'Tài khoản',
                'orderable' => false,
            ],
            'password' => [
                'title' => 'Mật khẩu',
                'orderable' => false,
            ],
            'is_success' => [
                'title' => 'Nội dung',
                'orderable' => false,
            ],
            'response_data'  => [
                'title' => 'Data Raw',
                'orderable' => false,
            ],
            'ip_address'  => [
                'title' => 'Địa chỉ IP',
                'orderable' => false,
            ],
            'created_at' => [
                'title' => 'createdAt',
                'orderable' => false,
                'visible' => false,
            ],
        ];
    }
}
