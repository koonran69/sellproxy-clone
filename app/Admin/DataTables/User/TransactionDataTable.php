<?php

namespace App\Admin\DataTables\Customer;

use App\Core\DataTables\DataTables;
use App\Core\Enums\{TransactionStatus, TransactionType};
use App\Core\Repositories\CustomerTransaction\CustomerTransactionRepositoryInterface;

class TransactionDataTable extends DataTables
{
    public string $prefixConfig = 'datatables_columns.client_customer';

    public function __construct(
        public CustomerTransactionRepositoryInterface $repository
    ){
    }

    protected function setViewColumns(): void
    {
        $this->viewColumns = [
            'action' => 'admin.customers.transactions.datatable.action',
            'customer' => 'admin.customers.transactions.datatable.customer',
            'amount' => 'admin.customers.transactions.datatable.amount',
            'status' => 'admin.customers.transactions.datatable.status',
            'type' => 'admin.customers.transactions.datatable.type',
        ];
    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['code', 'customer_id', 'type', 'status', 'created_at'];
    }

    protected function setColumnSearchSelect(): void {
        $this->columnSearchSelect = [
            'status' => [
                'data' => TransactionStatus::asSelectArray()
            ],
            'type' => [
                'data' => TransactionType::asSelectArray()
            ]
        ];
    }

    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['created_at'];
    }
    
    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\CustomerTransaction $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $this->repository->getByQueryBuilder([], ['customer'], ['id', 'desc']);
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'customer_id' => $this->viewColumns['customer'],
            'created_at' => '{{ date(config("core.format.date"), strtotime($created_at)) }}',
            'amount' => $this->viewColumns['amount'],
            'status' => $this->viewColumns['status'],
            'type' => $this->viewColumns['type'],
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'action' => $this->viewColumns['action'],
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['customer_id', 'action', 'amount', 'status', 'type'];
    }
}