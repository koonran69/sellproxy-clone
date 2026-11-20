<?php

namespace App\Admin\Http\Controllers\Proxy;

use App\Admin\DataTables\Proxy\CategoryDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Proxy\CategoryRequest;
use App\Core\Enums\DefaultStatus;
use App\Models\ProxyCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(
        protected ProxyCategory $model,
    ) {
    }

    public function index(CategoryDataTable $datatable): View|JsonResponse
    {
        return $datatable->render('admin.proxies.categories.index', [
            'breadcrums' => $this->breadcrums()->add(trans('Danh mục'))
        ]);
    }

    public function create(): View
    {
        return view('admin.proxies.categories.modal.add')->with('status', DefaultStatus::asSelectArray());
    }

    public function store(CategoryRequest $request)
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

    public function edit($id, $lang = 'vi'): View
    {
        $category = $this->model->findOrFail($id);

        return view('admin.proxies.categories.modal.edit')
            ->with('category', $category)
            ->with('lang', $lang)
            ->with('status', DefaultStatus::asSelectArray());
    }

    public function update(CategoryRequest $request)
    {
        try {

            $data = $request->validated();
            $lang = $data['lang'] ?? 'vi';

            $category = $this->model->findOrFail($data['id']);

            if ($lang === 'vi') {

                $category->update($data);

            } else {

                $category->setTranslation('name', $lang, $data['name']);
                $category->save();
            }

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