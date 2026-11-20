<?php

namespace App\Admin\Http\Controllers\Proxy;

use App\Admin\DataTables\Proxy\AttributeDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Proxy\AttributeRequest;
use App\Admin\Http\Requests\Proxy\CategoryRequest;
use App\Core\Enums\DefaultStatus;
use App\Models\Attribute;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class AttributeController extends Controller
{

    public function __construct(
        protected Attribute $model,
    ) {
    }

    public function index(AttributeDataTable $datatable): View|JsonResponse
    {
        return $datatable->render('admin.proxies.attributes.index', [
            'breadcrums' => $this->breadcrums()->add(trans('Thuộc tính'))
        ]);
    }

    public function create(): View
    {
        return view('admin.proxies.attributes.modal.add')->with('status', DefaultStatus::asSelectArray());
    }

    public function store(AttributeRequest $request)
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
        $attribute = $this->model->findOrFail($id);
        return view('admin.proxies.attributes.modal.edit')
            ->with('attribute', $attribute)
            ->with('status', DefaultStatus::asSelectArray());
    }

    public function update(AttributeRequest $request)
    {
        try {

            $this->model->findOrFail($request->input('id'))->update($request->validated());

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