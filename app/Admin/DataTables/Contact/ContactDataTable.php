<?php

namespace App\Admin\DataTables\Contact;

use App\Core\DataTables\DataTables;
use App\Core\Repositories\Contact\ContactRepositoryInterface;

class ContactDataTable extends DataTables
{

    public function __construct(
        public ContactRepositoryInterface $repository
    ) {
    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['fullname', 'email'];
    }

    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['created_at'];
    }

    public function query()
    {
        return $this->repository->getByQueryBuilder([], []);
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'created_at' => '{{ date(config("core.format.date"), strtotime($created_at)) }}',
        ];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'fullname' => [
                'title' => 'Họ tên',
                'orderable' => false,
            ],
            'email' => [
                'title' => 'Email',
                'orderable' => false,
            ],
            'subject' => [
                'title' => 'Tiêu đề',
                'orderable' => false,
            ],
            'message' => [
                'title' => 'Nội dung',
                'orderable' => false,
            ],
            'ip_address' => [
                'title' => 'Địa chỉ IP',
                'orderable' => false,
                'addClass' => 'align-middle',
            ],
            'created_at' => [
                'title' => 'Ngày gửi',
                'orderable' => false,
                'addClass' => 'align-middle',
            ],
        ];
    }
}
