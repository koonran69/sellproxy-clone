<?php

namespace App\Admin\Http\Controllers\Proxy;

use App\Admin\DataTables\Proxy\TypeDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Proxy\TypeRequest;
use App\Core\Enums\DefaultStatus;
use App\Models\ProxyType;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class TypeController extends Controller
{
    public function __construct(
        protected ProxyType $model,
    ) {
    }

    public function index(TypeDataTable $datatable): View|JsonResponse
    {
        return $datatable->render('admin.proxies.types.index', [
            'breadcrums' => $this->breadcrums()->add(trans('Loại'))
        ]);
    }

    public function create(): View
    {
        return view('admin.proxies.types.modal.add')->with('status', DefaultStatus::asSelectArray());
    }

    public function store(TypeRequest $request)
    {
        try {
            $data = $request->validated();

            $this->model->create($data);

            if ($request->ajax()) {
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
        $type = $this->model->findOrFail($id);

        return view('admin.proxies.types.modal.edit')
            ->with('type', $type)
            ->with('status', DefaultStatus::asSelectArray());
    }

    public function update(TypeRequest $request)
    {
        try {

            $data = $request->validated();
            $category = $this->model->findOrFail($data['id']);
            $category->update($data);

            if ($request->ajax()) {
                return utilities()->responseAjax();
            }

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id): JsonResponse
    {
        try {
            $this->model->findOrFail($id)->delete();

            return response()->json([
                'msg' => trans('notifySuccess')
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}