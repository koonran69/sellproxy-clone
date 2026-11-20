<?php

namespace App\Admin\Http\Controllers\Proxy;

use App\Admin\DataTables\Proxy\VariationDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Proxy\VariationRequest;
use App\Core\Enums\DefaultStatus;
use App\Models\Attribute;
use App\Models\Variation;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class VariationController extends Controller
{

    public function __construct(
        protected Attribute $modelAttri,
        protected Variation $model
    ) {
    }

    public function index($attrId, VariationDataTable $datatable): View|JsonResponse
    {
        $attribute = $this->modelAttri->findOrFail($attrId);

        return $datatable->with('attr', $attribute)->render('admin.proxies.variations.index', [
            'attribute' => $attribute,
            'breadcrums' => $this->breadcrums()->addByRouteName(trans('Thuộc tính'), 'admin.proxy.attribute.index')->add(trans('Biến thể'))
        ]);
    }

    public function create($attrId): View
    {
        return view('admin.proxies.variations.modal.add')->with('attri_id', $attrId);
    }

    public function store(VariationRequest $request)
    {
        try {
            $data = $request->validated();

            $variation = $this->model->create($data);

            if ($request->ajax()) {
                return utilities()->responseAjax();
            }

            if ($variation) {
                return $request->input('submitter') == 'save'
                    ? utilities()->responseBack()
                    : utilities()->toRoute('admin.variation.index');
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
        $variation = $this->model->findOrFail($id);
        return view('admin.proxies.variations.modal.edit')
            ->with('variation', $variation)
            ->with('status', DefaultStatus::asSelectArray());
    }

    public function update(VariationRequest $request)
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