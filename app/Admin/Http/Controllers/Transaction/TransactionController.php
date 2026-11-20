<?php

namespace App\Admin\Http\Controllers\Transaction;

use App\Admin\DataTables\Transaction\TransactionDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Core\Repositories\Transaction\TransactionRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function __construct(
        protected TransactionRepositoryInterface $repository,
    )
    {}

    public function index(TransactionDataTable $datatable): View|JsonResponse
    {
        return $datatable->render('admin.transactions.index', [
            'breadcrums' => $this->breadcrums()->addByRouteName(trans('Lịch sử giao dịch'))
        ]);
    }

    public function delete($id): RedirectResponse|JsonResponse
    {
        try {
            $this->repository->delete($id);

            if(request()->ajax())
            {
                return utilities()->responseAjax();
            }

            return to_route('admin.transaction.index')->with('success', __('notifySuccess'));
        } catch (\Throwable $th) {

            if(request()->ajax())
            {
                throw $th;
            }
            return back()->withErrors(['errors' => $th->getMessage()]);
        }
    }

}
