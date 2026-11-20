<?php

namespace App\Admin\DataTables\Vps;

use App\Core\DataTables\DataTables;
use App\Models\ProxyResidentialOrder;
use App\Models\VpsOrder;

class VpsOrderDataTable extends DataTables
{
    public function __construct(
        public VpsOrder $model
    ){
    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['user', 'state_info', 'country_info','vps_info','total_amount','created_at'];
    }
    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['created_at'];
    }
    protected function setFilterColumns(): void
    {
        $this->filterColumns = [
            'user' => fn($q, $k) => $q->whereRelation('user', 'name', 'like', "%$k%")->orwhere('id',$k)->orwhere('plan_id',$k),
            'state_info' => fn($q, $k) => $q->where('state', 'like', "%$k%")->orwhere('provider', 'like', "%$k%"),
            'country_info' => fn($q, $k) => $q->where('nation', 'like', "%$k%"),
            'vps_info' => fn($q, $k) => $q->where('range_ip', 'like', "%$k%")->orwhere('port', 'like', "%$k%")->orwhereRelation('vps', 'ip', 'like', "%$k%"),
            'total_amount' => fn($q, $k) => $q->where('price', $k),

        ];
    }
    public function query()
    {
        $data = $this->model->with(['user','vps'])
            ->whereHas('user')
            ->orderBy('id', 'desc');
        return $data;
    }
    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'user' => fn($row) => view('admin.vps.datatable.user')->with('data', $row),
            'state_info' => fn($row) => view('admin.vps.datatable.state_info')->with('data', $row),
            'country_info' => fn($row) => view('admin.vps.datatable.country_info')->with('data', $row),
            'vps_info' => fn($row) => view('admin.vps.datatable.vps_info')->with('data', $row),
            'month' => fn($row) => $row->duration . ' tháng',
            'quantity' => fn($row) => $row->quantity,
            'total_amount' => fn($row) => number_format($row->price).'đ',
            'created_at' => '{{ date(config("core.format.datetime"), strtotime($created_at)) }}',
            'action' => 'admin.vps.datatable.action',
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['user', 'state_info', 'country_info',' vps_info', 'proxy_info', 'action'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'user' => [
                'title' => 'Đơn hàng',
                'orderable' => false,
            ],
            'state_info' => [
                'title' => 'Bang/Nhà mạng/GPU',
                'orderable' => false,
            ],
            'country_info' => [
                'title' => 'Quốc gia',
                'orderable' => false,
            ],
            'vps_info' => [
                'title' => 'Thông tin VPS',
                'orderable' => false,
            ],
            'month' => [
                'title' => 'Số tháng',
                'orderable' => true,
            ],
            'quantity' => [
                'title' => 'Số lượng',
                'orderable' => true,
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
