<?php

namespace App\Admin\Http\Controllers\Customer;

use App\Admin\DataTables\Customer\TransactionDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Core\Repositories\CustomerTransaction\CustomerTransactionRepositoryInterface;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    public function __construct(
        public CustomerTransactionRepositoryInterface $repository
    )
    {
    }

    public function index(TransactionDataTable $datatable): JsonResponse | View
    {
        return $datatable->render('admin.customers.transactions.index', [
            'breadcrums' => $this->breadcrums()->add(trans('customers transactions')),
        ]);
    }


}
