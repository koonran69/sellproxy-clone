<?php

namespace App\Admin\Http\Controllers\Tutorial\Post;

use App\Admin\DataTables\Tutorial\Post\PostDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Blog\Post\PostRequest;
use App\Core\Enums\BlogType;
use App\Core\Enums\DefaultStatus;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct(public Post $modelPost, public Category $modelCat)
    {
    }

    public function index(PostDataTable $datatable)
    {
        return $datatable->render('admin.tutorial.posts.index', [
            'breadcrums' => $this->breadcrums()->add(trans('Hướng dẫn'))->add('Bài đăng'),
        ]);
    }

    public function create(): View
    {
        return view('admin.tutorial.posts.create', [
            'breadcrums' => $this->breadcrums()->add(trans('Hướng dẫn'))->addByRouteName(__('Bài đăng'), 'admin.blog.post.index')->add(__('add')),
            'status' => DefaultStatus::asSelectArray(),
            'categories' => $this->modelCat->getFlatTree(['type' => BlogType::Tutorial]),
        ]);
    }

    public function store(PostRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            $catIds = $data['categories_id'];
            $data['admin_id'] = auth('admin')->id();
            unset($data['categories_id']);
            $data['type'] = BlogType::Tutorial;
            $post = $this->modelPost->create($data);

            $post->categories()->attach($catIds);

            DB::commit();

            if ($post) {
                return $request->input('submitter') == 'save'
                    ? utilities()->toRoute('admin.tutorial.post.edit', $post->id)
                    : utilities()->toRoute('admin.tutorial.post.index');
            }

            return utilities()->responseBack();
        } catch (\Throwable $th) {
            DB::rollBack();
            return utilities()->responseBack(error: true, msg: $th->getMessage(), withInput: true);
        }
    }

    public function edit($id, $lang = 'vi'): View
    {
        $post = $this->modelPost->findOrFail($id);

        return view('admin.tutorial.posts.edit', [
            'breadcrums' => $this->breadcrums()->add(trans('Hướng dẫn'))->addByRouteName(__('Bài đăng'), 'admin.blog.post.index')->add(__('edit')),
            'post' => $post,
            'lang' => $lang,
            'status' => DefaultStatus::asSelectArray(),
            'categories' => $this->modelCat->getFlatTree(['type' => BlogType::Tutorial]),
        ]);
    }

    public function update(PostRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $catIds = $data['categories_id'];
            $data['type'] = BlogType::Tutorial;
            unset($data['categories_id']);

            $post = $this->modelPost->findOrFail($data['id']);

            $post->fill($data);

            $post->save();

            $post->categories()->sync($catIds);
            DB::commit();
            if ($post) {
                return $request->input('submitter') == 'save' ? utilities()->responseBack() : utilities()->toRoute('admin.blog.post.index');
            }

            return utilities()->responseBack();
        } catch (\Throwable $th) {
            // throw $th;
            DB::rollBack();
            return utilities()->responseBack(error: true, msg: $th->getMessage(), withInput: true);
        }
    }

    public function delete($id)
    {
        try {
            $this->modelPost->findOrFail($id)->delete();
            if (request()->ajax()) {
                return utilities()->responseAjax();
            }
            return utilities()->toRoute('admin.tutorial.post.index');
        } catch (\Throwable $th) {
            //throw $th;

            if (request()->ajax()) {
                return utilities()->responseAjax(error: true, msg: $th->getMessage());
            }

            return utilities()->responseBack(error: true, msg: $th->getMessage());
        }
    }
}
