<?php

namespace App\Admin\Http\Controllers\Blog\Category;

use App\Core\Enums\BlogType;
use App\Models\Category;
use Illuminate\View\View;
use App\Core\Enums\DefaultStatus;
use App\Core\Facades\UtilitiFacade;
use App\Admin\Http\Controllers\Controller;
use App\Admin\DataTables\Blog\Category\CategoryDataTable;
use App\Admin\Http\Requests\Blog\Category\CategoryRequest;

class CategoryController extends Controller
{
    public function __construct(
        public Category $model,
    ) {

    }

    public function index(CategoryDataTable $datatable)
    {
        return $datatable->render('admin.blog.categories.index', [
            'breadcrums' => $this->breadcrums()->add(trans('Blog'))->add('Danh mục')
        ]);
    }

    public function create(): View
    {
        return view('admin.blog.categories.modal.add', [
            'categories' => $this->model->getFlatTree(['type' => BlogType::Blog]),
            'status' => DefaultStatus::asSelectArray()
        ]);
    }

    public function store(CategoryRequest $request)
    {
        try {

            $data = $request->validated();
            $data['type'] = BlogType::Blog;
            $this->model->create($data);

            return UtilitiFacade::responseAjax();

        } catch (\Throwable $th) {
            return UtilitiFacade::responseAjax(error: true, msg: $th->getMessage());
        }
    }

    public function edit($id, $lang = 'vi'): View
    {
        $categories = $this->model->getFlatTree([
            ['id', 'not_in', [$id]],
            'type' => BlogType::Blog
        ]);

        $category = $this->model->findOrFail($id);

        return view(
            'admin.blog.categories.modal.edit',
            [
                'category' => $category,
                'lang' => $lang,
                'categories' => $categories,
                'status' => DefaultStatus::asSelectArray(),
            ],
        );
    }

    public function update(CategoryRequest $request)
    {
        try {
            $data = $request->validated();
            $lang = $data['lang'] ?? 'vi';

            $category = $this->model->findOrFail($data['id']);
            $data['type'] = BlogType::Blog;
            if ($lang === 'vi') {
                $category->update($data);
            } else {
                foreach (['name', 'description', 'title_seo', 'desc_seo'] as $field) {
                    $translations = $category->getTranslations($field);
                    $translations[$lang] = $data[$field] ?? null;
                    $category->setTranslations($field, $translations);
                }
                $category->save();
            }

            if ($request->ajax()) {
                return utilities()->responseAjax();
            }
        } catch (\Throwable $th) {
            return utilities()->responseAjax(error: true, msg: $th->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $this->model->destroy($id);
            return utilities()->responseAjax();
        } catch (\Throwable $th) {
            return utilities()->responseAjax(error: true, msg: $th->getMessage());
        }
    }
}
