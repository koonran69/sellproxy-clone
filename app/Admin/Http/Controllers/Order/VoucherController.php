<?php

namespace App\Admin\Http\Controllers\Order;

use App\Admin\DataTables\Order\VoucherDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Order\AttributeRequest;
use App\Admin\Http\Requests\Voucher\VoucherRequest;
use App\Core\Enums\DefaultStatus;
use App\Core\Enums\Voucher\VoucherStatus;
use App\Core\Enums\Voucher\VoucherType;
use App\Core\Repositories\Voucher\VoucherRepositoryInterface;
use App\Models\Attribute;
use App\Models\MemberLevel;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class VoucherController extends Controller
{

    public function __construct(
        protected VoucherRepositoryInterface $repository,
        protected MemberLevel $memberLevel
    ) {
    }

    public function index(VoucherDataTable $datatable): View|JsonResponse
    {
        return $datatable->render('admin.vouchers.index', [
            'breadcrums' => $this->breadcrums()->add(trans('Voucher'))
        ]);
    }

    public function create(): View
    {
        $memberLevels = $this->memberLevel->getAll();
        $users = User::select('id', 'name', 'email')->get();
        return view('admin.vouchers.create')->with('types', VoucherType::asSelectArray())
            ->with('status', VoucherStatus::asSelectArray())
            ->with('memberLevels', $memberLevels)
            ->with('users', $users)
            ->with('breadcrums', $this->breadcrums()->add(trans('Voucher')));
    }

    public function store(VoucherRequest $request)
    {
        try {
            $data = $request->validated();

            $data['status'] = $request->getStatus();

            $voucher = $this->repository->create($data);

            if ($voucher) {
                return $request->input('submitter') == 'save'
                    ? to_route('admin.voucher.edit', $voucher->id)->with('success', __('notifySuccess'))
                    : to_route('admin.voucher.index')->with('success', __('notifySuccess'));
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
        $voucher = $this->repository->findOrFail($id);
        $memberLevels = $this->memberLevel->getAll();
        $users = User::select('id', 'name', 'email')->get();
        return view('admin.vouchers.edit')
            ->with('voucher', $voucher)
            ->with('users', $users)
            ->with('memberLevels', $memberLevels)
            ->with('types', VoucherType::asSelectArray())->with('status', VoucherStatus::asSelectArray())->with('breadcrums', $this->breadcrums()->add(trans('Voucher')));
    }

    public function update(VoucherRequest $request)
    {
        try {
            $data = $request->validated();

            $data['status'] = $request->getStatus();

            $voucher = $this->repository->update($data['id'], $data);

            if ($voucher) {
                return $request->input('submitter') == 'save'
                    ? to_route('admin.voucher.edit', $voucher->id)->with('success', __('notifySuccess'))
                    : to_route('admin.voucher.index')->with('success', __('notifySuccess'));
            }

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id): JsonResponse
    {
        try {
            $this->repository->delete($id);

            return response()->json([
                'msg' => trans('notifySuccess')
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
