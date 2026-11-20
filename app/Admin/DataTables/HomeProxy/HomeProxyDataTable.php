<?php

namespace App\Admin\DataTables\HomeProxy;

use App\Core\DataTables\DataTables;
use App\Models\ProxyHomeOrder;

class HomeProxyDataTable extends DataTables
{

    public function __construct(
        public ProxyHomeOrder $model
    ){
    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['partner_order_id', 'code', 'user_id', 'type', 'proxies', 'created_at'];
    }

    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['created_at'];
    }

    protected function setFilterColumns(): void
    {
        $this->filterColumns = [
            'user_id' => fn($q, $k) => $q->whereRelation('user', 'name', 'like', "%$k%"),
            'proxies' => fn($q, $k) => $q->whereRelation('proxies', 'ip', 'like', "%$k%"),
            'type'    => fn($q, $k) => $q->where('type', $k),
        ];
    }

    protected function setColumnSearchSelect(): void
    {
        $this->columnSearchSelect = [
            'type' => [
                'data' => [
                    'key-rotate' => trans('Key Xoay'),
                    'rotate' => trans('Proxy xoay'),
                    'static' => trans('Proxy tĩnh'),
                    'proxy-datacenter-cmc' => trans('Proxy datacenter VN'),
                    'proxy-datacenter-us' => trans('Proxy datacenter US'),
                ]
            ]
        ];
    }

    public function query()
    {
        return $this->model->with(['user', 'proxies'])->whereHas('user')->orderBy('id', 'desc');
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'user_id' => fn($row) => $row->user?->name,
            'created_at' => '{{ date(config("core.format.datetime"), strtotime($created_at)) }}',
            'proxies' => fn($row) => view('admin.homeproxy.datatable.proxy')->with('proxies', $row->proxies)->with('order', $row),
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'info' => 'admin.homeproxy.datatable.info',
            // 'action' => 'admin.proxyhome.datatable.action',
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['info', 'action', 'proxies'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'partner_order_id' => [
                'title' => 'Mã đối tác',
                'orderable' => false,
            ],
            'code' => [
                'title' => 'Code',
                'orderable' => false,
            ],
            'user_id' => [
                'title' => 'User',
                'orderable' => false,
            ],
            'type' => [
                'title' => 'Loại',
                'orderable' => false,
            ],
            'info' => [
                'title' => 'Thông tin',
                'orderable' => false,
            ],
            'proxies' => [
                'title' => 'Proxy',
                'orderable' => false,
            ],
            'created_at' => [
                'title' => 'createdAt',
                'orderable' => false,
                'visible' => false,
            ],
            // 'action' => [
            //     'title' => 'action',
            //     'orderable' => false,
            //     'exportable' => false,
            //     'printable' => false,
            //     'addClass' => 'text-center'
            // ]
        ];
    }
}
