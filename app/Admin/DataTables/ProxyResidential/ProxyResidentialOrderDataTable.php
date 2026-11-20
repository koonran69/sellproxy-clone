<?php

namespace App\Admin\DataTables\ProxyResidential;

use App\Core\DataTables\DataTables;
use App\Models\ProxyResidentialOrder;

class ProxyResidentialOrderDataTable extends DataTables
{
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
        $data = ProxyResidentialOrder::with(['user','proxy','country'])
            ->whereHas('user')
            ->orderBy('id', 'desc');
        return $data;
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'proxy_info' => fn($row) => view('admin.proxy_residential_order.datatable.proxy_info')->with('data', $row),
            'networkType' => fn($row) => $row->proxy->networkType,
            'ip_version' => fn($row) => $row->proxy->ipVersion,
            'month' => fn($row) => $row->month,
            'quantity' => fn($row) => $row->package ?? $row->quantity ,
            'user' => fn($row) => view('admin.proxy_residential_order.datatable.user')->with('data', $row),
            'total_amount' => fn($row) => number_format($row->amount).'đ',
            'created_at' => '{{ date(config("core.format.datetime"), strtotime($created_at)) }}',
            'action' => 'admin.proxy_residential_order.datatable.action',
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['user', 'action', 'networkType',' ip_version', 'isp', 'proxy_info'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'user' => [
                'title' => 'Đơn hàng',
                'orderable' => false,
            ],
            'proxy_info' => [
                'title' => 'Thông tin proxy',
                'orderable' => false,
            ],
            'networkType' => [
                'title' => 'Loại proxy',
                'orderable' => false,
            ],
            'ip_version' => [
                'title' => 'IP Version',
                'orderable' => false,
            ],
            'month' => [
                'title' => 'Số tháng',
                'orderable' => false,
            ],
            'quantity' => [
                'title' => 'Số lượng',
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
