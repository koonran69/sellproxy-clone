<?php

namespace App\Admin\DataTables\Proxyline;

use App\Core\DataTables\DataTables;
use App\Core\Repositories\Contact\ContactRepositoryInterface;
use App\Core\Repositories\ProxyPackage\ProxyPackageRepositoryInterface;
use App\Models\IpVersion;
use App\Models\ProxyLineType;
use App\Models\ProxyPackage;

class ProxylineDataTable extends DataTables
{

    public function __construct(
        public ProxyPackageRepositoryInterface $repository
    ) {
    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['proxy_type', 'ip_version'];
    }

    protected function setColumnSearchSelect(): void
    {
        $this->columnSearchSelect = [
            'proxy_type' => [
                'data' => ProxyLineType::pluck('name', 'id')->toArray()
            ],
            'ip_version' => [
                'data' => IpVersion::pluck('version', 'id')->toArray()
            ]
        ];
    }

    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['created_at'];
    }

    public function query()
    {
        return ProxyPackage::with(['proxyType', 'ipVersion'])
            ->orderBy('proxy_type_id')
            ->orderBy('ip_version_id')
            ->orderBy('duration_days');
    }

    protected function setFilterColumns(): void
    {
        $this->filterColumns = [
            'proxy_type' => fn($q, $k) => $q->where('proxy_type_id', $k),
            'ip_version' => fn($q, $k) => $q->where('ip_version_id', $k),
        ];
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'proxy_type' => '{{ $proxy_type[\'name\'] }}',
            'ip_version' => '{{ $ip_version[\'version\'] }}',
            'range' => 'admin.proxylines.datatable.range',
            'price_per_ip' => 'admin.proxylines.datatable.price',
            'created_at' => '{{ date(config("core.format.date"), strtotime($created_at)) }}',
            'action' => 'admin.proxylines.datatable.action',
        ];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'proxy_type' => [
                'title' => 'Proxy Type',
                'orderable' => false,
            ],
            'ip_version' => [
                'title' => 'IP Version',
                'orderable' => false,
            ],
            'range' => [
                'title' => 'Số lượng',
                'orderable' => false,
            ],
            'duration_days' => [
                'title' => 'Số ngày',
                'orderable' => false,
            ],
            'price_per_ip' => [
                'title' => 'Giá',
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
