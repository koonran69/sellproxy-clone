<?php

namespace App\Admin\DataTables\User;

use App\Core\DataTables\DataTables;
use App\Core\Enums\Gender;
use App\Core\Repositories\User\UserRepositoryInterface;
use App\Models\MemberLevel;

class UserDataTable extends DataTables
{

    public function __construct(
        public UserRepositoryInterface $repository
    ) {

    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['name', 'phone', 'email', 'created_at', 'member_level'];
    }

    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['created_at'];
    }

    protected function setColumnSearchSelect(): void
    {
        $memberLevels = MemberLevel::select("id", "name")->orderBy('plain_value')->get()->pluck('name','id')->toArray();
        $this->columnSearchSelect = [
            'member_level' => [
                'data' => $memberLevels,
            ],

        ];
    }

    protected function setFilterColumns(): void
    {
        $this->filterColumns = [
            'member_level' => function ($q, $k) {
                $q->where('member_level_id', $k);
            },
        ];
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $this->repository->getByQueryBuilder([], ['memberLevel', 'privateVouchers'], ['id', 'desc']);
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'privateVouchers' => 'admin.users.datatable.vouchers',
            'member_level' => 'admin.users.datatable.member-level',
            'balance' => '{{ format_price($balance) }}',
            'created_at' => '{{ date(config("core.format.date"), strtotime($created_at)) }}',
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'action' => 'admin.users.datatable.action',
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['privateVouchers','member_level','name', 'action'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'name' => [
                'title' => 'name',
                'orderable' => false,
            ],
            'email' => [
                'title' => 'email',
                'orderable' => false,
            ],
            'phone' => [
                'title' => 'phone',
                'orderable' => false,
            ],
            'balance' => [
                'title' => 'Số dư',
                'orderable' => false,
                'addClass' => 'text-center'
            ],
            'member_level' => [
                'title' => 'Hạng thành viên',
                'orderable' => false,
                'addClass' => 'text-center'
            ],
            'privateVouchers' => [
                'title' => 'Voucher dành riêng',
                'orderable' => false,
                'addClass' => 'text-center'
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