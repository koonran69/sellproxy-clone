<?php

namespace App\Admin\Http\Controllers\Coin;

use App\Admin\DataTables\Coin\CoinDataTable;
use App\Admin\DataTables\QA\QADataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Coin\CoinRequest;
use App\Admin\Http\Requests\QA\QARequest;
use App\Core\Enums\DefaultStatus;
use App\Core\Repositories\Coin\CoinRepositoryInterface;
use App\Core\Repositories\QA\QARepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CoinController extends Controller
{

    public function __construct(
        protected CoinRepositoryInterface $repository,
    ) {
    }

    public function index(CoinDataTable $datatable): View|JsonResponse
    {
        return $datatable->render('admin.coins.index', [
            'breadcrums' => $this->breadcrums()->add(trans('Coin'))
        ]);
    }

    public function create(): View
    {
        return view('admin.coins.create')->with('status', DefaultStatus::asSelectArray())
            ->with('breadcrums', $this->breadcrums()->add(trans('Coin')));
    }

    public function store(CoinRequest $request)
    {
        try {
            $data = $request->validated();
            $qa = $this->repository->create($data);

            if ($qa) {
                return $request->input('submitter') == 'save'
                    ? to_route('admin.coin.edit', $qa->id)->with('success', __('notifySuccess'))
                    : to_route('admin.coin.index')->with('success', __('notifySuccess'));
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
        $coin = $this->repository->findOrFail($id);
        return view('admin.coins.edit')
            ->with('coin', $coin)
            ->with('status', DefaultStatus::asSelectArray())->with('breadcrums', $this->breadcrums()->add(trans('Coin')));
    }

    public function update(CoinRequest $request)
    {
        try {
            $data = $request->validated();

            $qa = $this->repository->update($data['id'], $data);

            if ($qa) {
                return $request->input('submitter') == 'save'
                    ? to_route('admin.coin.edit', $qa->id)->with('success', __('notifySuccess'))
                    : to_route('admin.coin.index')->with('success', __('notifySuccess'));
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
