<?php

namespace App\Admin\Http\Controllers\WithDrawal;

use App\Admin\DataTables\Deposit\DepositDataTable;
use App\Admin\DataTables\WithDrawals\WithDrawalsDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Deposit\DepositRequest;
use App\Admin\Services\Deposit\DepositService;
use App\Core\Enums\Deposit\Status;
use App\Core\Enums\Transaction\ReferenceType;
use App\Core\Enums\Transaction\TransactionStatus;
use App\Core\Enums\WithdrawalStatus;
use App\Core\Http\Requests\Request;
use App\Core\Repositories\Deposit\DepositRepositoryInterface;
use App\Core\Repositories\WithDrawals\WithDrawalsRepositoryInterface;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class WithDrawalController extends Controller
{
    public function __construct(
        protected WithDrawalsRepositoryInterface $repository,
    ) {
    }

    public function index(WithDrawalsDataTable $datatable): View|JsonResponse
    {
        return $datatable->render('admin.withdrawals.index', [
            'breadcrums' => $this->breadcrums()->add(trans('Yêu cầu rút tiền'))
        ]);
    }

    public function create(): View
    {
        return view('admin.withdrawals.modal.add');
    }

    public function store(DepositRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();

            $deposit = $this->repository->create($data)->load('user');

            $deposit->user->recharge($deposit->amount, ReferenceType::Deposit, $deposit->id);

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
        try {
            DB::beginTransaction();

            $withdrawal = $this->repository->findOrFail($id);
            $withdrawal->status = WithdrawalStatus::Approved;
            $withdrawal->processed_at = Carbon::now()->toDateTimeString();
            $withdrawal->save();

            $user = $withdrawal->user;
            $user->balance -= $withdrawal->amount;
            $user->save();

            $transaction = Transaction::create([
                'user_id' => $user->id,
                'code' => 'PRX' . uniqid_real(6),
                'amount' => $withdrawal->amount,
                'status' => TransactionStatus::Paid,
                'reference_id' => $withdrawal->id,
                'reference_type' => get_class($withdrawal),
                'note' => 'Rút tiền từ số dư thực'
            ]);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }
        return utilities()->responseAjax();
    }

    public function reject($id)
    {
        try {
            DB::beginTransaction();

            $withdrawal = $this->repository->findOrFail($id);
            $withdrawal->status = WithdrawalStatus::Rejected;
            $withdrawal->processed_at = Carbon::now()->toDateTimeString();
            $withdrawal->note = 'Thông tin rút tiền không hợp lệ';
            $withdrawal->save();

            $user = $withdrawal->user;
            $user->available_balance += $withdrawal->amount;
            $user->save();

            $transaction = Transaction::create([
                'user_id' => $user->id,
                'code' => 'PRX' . uniqid_real(6),
                'amount' => $withdrawal->amount,
                'status' => TransactionStatus::Paid,
                'reference_id' => $withdrawal->id,
                'reference_type' => get_class($withdrawal),
                'note' => "Hoàn tiền do từ chối lệnh rút #$withdrawal->id"
            ]);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }
        return utilities()->responseAjax();
    }
}
