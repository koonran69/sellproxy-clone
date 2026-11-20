<?php

namespace App\Admin\DataTables\Proxyline;

use App\Core\DataTables\DataTables;
use App\Core\Repositories\Contact\ContactRepositoryInterface;
use App\Core\Repositories\ProxyPackage\ProxyPackageRepositoryInterface;
use App\Models\IpVersion;
use App\Models\ProxyLineType;
use App\Models\ProxyOrder;
use App\Models\ProxyPackage;

class ProxylineOrderDataTable extends DataTables
{

//    protected function setColumnHasSearch(): void
//    {
//        $this->columnHasSearch = ['proxy_type', 'ip_version'];
//    }

//    protected function setColumnSearchSelect(): void
//    {
//        $this->columnSearchSelect = [
//            'proxy_type' => [
//                'data' => ProxyLineType::pluck('name', 'id')->toArray()
//            ],
//            'ip_version' => [
//                'data' => IpVersion::pluck('version', 'id')->toArray()
//            ]
//        ];
//    }
    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['created_at'];
    }
    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['created_at'];
    }

    public function query()
    {
        return ProxyOrder::with(['proxyType', 'ipVersion', 'country', 'user'])
            ->whereHas('user')
            ->orderBy('id', 'desc');
    }

//    protected function setFilterColumns(): void
//    {
//        $this->filterColumns = [
//            'proxy_type' => fn($q, $k) => $q->where('proxy_type_id', $k),
//            'ip_version' => fn($q, $k) => $q->where('ip_version_id', $k),
//        ];
//    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'proxy_type' => '{{ $proxy_type[\'name\'] }}',
            'ip_version' => '{{ $ip_version[\'version\'] }}',
            'country' => 'admin.proxyline_order.datatable.country',
            'user' => 'admin.proxyline_order.datatable.user',
            'created_at' => '{{ date(config("core.format.datetime"), strtotime($created_at)) }}',
            'total_amount' => '{{ format_price($total_amount) }}',
            'action' => 'admin.proxyline_order.datatable.action',
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['country', 'user', 'action'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'user' => [
                'title' => 'Đơn hàng',
                'orderable' => false,
            ],
            'country' => [
                'title' => 'Quốc gia',
                'orderable' => false,
            ],
            'proxy_type' => [
                'title' => 'Proxy Type',
                'orderable' => false,
            ],
            'ip_version' => [
                'title' => 'IP Version',
                'orderable' => false,
            ],
            'quantity' => [
                'title' => 'Số lượng',
                'orderable' => false,
            ],
            'period_days' => [
                'title' => 'Số ngày',
                'orderable' => false,
            ],
            'total_amount' => [
                'title' => 'Tổng tiền',
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
