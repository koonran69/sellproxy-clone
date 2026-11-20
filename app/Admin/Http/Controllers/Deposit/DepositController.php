<?php

namespace App\Admin\Http\Controllers\Deposit;

use App\Admin\DataTables\Deposit\DepositDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Deposit\DepositRequest;
use App\Admin\Services\Deposit\DepositService;
use App\Core\Enums\Deposit\Status;
use App\Core\Enums\Transaction\ReferenceType;
use App\Core\Enums\Transaction\TransactionStatus;
use App\Core\Http\Requests\Request;
use App\Core\Repositories\Deposit\DepositRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DepositController extends Controller
{
    public function __construct(
        protected DepositRepositoryInterface $repository,
    ) {
    }

    public function index(DepositDataTable $datatable): View|JsonResponse
    {
        return $datatable->render('admin.deposits.index', [
            'breadcrums' => $this->breadcrums()->add(trans('Lịch sử nạp tiền'))
        ]);
    }

    public function create(): View
    {
        return view('admin.deposits.modal.add');
    }

    public function store(DepositRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();

            $deposit = $this->repository->create($data)->load('user');

            $deposit->user->recharge($deposit->amount, ReferenceType::Deposit, $deposit->id);
            $user = $deposit->user;
            $user->available_balance += $deposit->amount;
            $user->save();

            if ($request->ajax()) {
                DB::commit();
                return utilities()->responseAjax();
            }

        } catch (\Throwable $th) {

            if ($request->ajax()) {
                throw $th;
            }
            return back()->withInput()->withErrors(['errors' => $th->getMessage()]);
        }
    }

    public function edit($id): View
    {
        $deposit = $this->repository->findOrFail($id)->load('user');
        return view('admin.deposits.modal.edit')
            ->with('deposit', $deposit);
    }

    public function accept($id)
    {
        $deposit = $this->repository->findOrFail($id)->load('user');

        $deposit->user->recharge($deposit->amount, ReferenceType::Deposit, $deposit->id);
        $user = $deposit->user;
        $user->available_balance += $deposit->amount;
        $user->save();

        $deposit->update(['status' => Status::Success]);

        $deposit->transactions()->update(['status' => TransactionStatus::Paid]);

        if ($deposit) {
            return utilities()->responseAjax();
        }


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
