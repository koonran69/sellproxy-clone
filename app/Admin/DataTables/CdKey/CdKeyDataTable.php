<?php

namespace App\Admin\DataTables\CdKey;

use App\Core\DataTables\DataTables;
use App\Core\Enums\DefaultStatus;
use App\Core\Enums\ProxyStatus;
use App\Core\Enums\Voucher\VoucherStatus;
use App\Core\Enums\Voucher\VoucherType;
use App\Core\Repositories\CdKey\CdKeyRepositoryInterface;
use App\Core\Repositories\QA\QARepositoryInterface;
use App\Core\Repositories\Voucher\VoucherRepositoryInterface;
use App\Models\Attribute;
use App\Models\CDkey;
use App\Models\Proxy;

class CdKeyDataTable extends DataTables
{

    public function __construct(
        public CdKeyRepositoryInterface $repository
    ) {
    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['is_use', 'proxy_id', 'variation_id', 'is_notify'];
    }

    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['created_at'];
    }

    protected function setColumnSearchSelect(): void
    {
        $proxies = CDkey::join('proxies', 'cdkeys.proxy_id', '=', 'proxies.id')
            ->select('proxies.id as proxy_id', 'proxies.name')
            ->get();
        $proxies = $proxies->map(function ($proxy) {
            $nameJson = json_decode($proxy->name,true);
            $locale = app()->getLocale();
            return [
                'id' => $proxy->proxy_id,
                'name' => $nameJson[$locale] ?? ""
            ];
        })->pluck('name','id')->toArray();

        $variations = CDkey::join('variations', 'cdkeys.variation_id', '=', 'variations.id')
            ->select('variations.id as id', 'variations.name')
            ->get()->pluck('name','id')->toArray();


        $this->columnSearchSelect = [
            'is_use' => [
                'data' => [ '0'=> 'Chưa', '1' => 'Đã sử dụng' ]
            ],
            'proxy_id' => [
                'data' => $proxies
            ],
            'variation_id' => [
                'data' => $variations
            ],
            'is_notify' => [
                'data' => [ '0'=> 'Chưa', '1' => 'Đã gửi' ]
            ],
        ];
    }

    public function query()
    {
        return $this->repository->getByQueryBuilder([], ['proxy', 'variation', 'user']);
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'proxy_id' => 'admin.cdkeys.datatable.proxy',
            'variation_id' => 'admin.cdkeys.datatable.variation',
            'is_use' => 'admin.cdkeys.datatable.is_use',
            'user_id' => 'admin.cdkeys.datatable.user',
            'is_notify' => 'admin.cdkeys.datatable.is_notify',
            'created_at' => '{{ date(config("core.format.date"), strtotime($created_at)) }}',
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'action' => 'admin.cdkeys.datatable.action',
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['is_notify','is_use','user_id','action'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'cdkey' => [
                'title' => 'cdkey',
                'orderable' => false,
            ],
            'proxy_id' => [
                'title' => 'Proxy',
                'orderable' => false,
            ],
            'variation_id' => [
                'title' => 'Kế hoạch',
                'orderable' => false,
            ],
            'is_use' => [
                'title' => 'Đã sử dụng',
                'orderable' => false,
                'visible' => true,
            ],
            'user_id' => [
                'title' => 'Sử dụng bởi',
                'orderable' => false,
                'visible' => true,
            ],
            'is_notify' => [
                'title' => 'Đã gửi',
                'orderable' => false,
                'visible' => true,
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
