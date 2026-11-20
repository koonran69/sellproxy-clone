<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;

class CategoryController extends Controller
{
    public function __construct(
        public Post $modelPost,
        public Category $model,
    )
    {

    }

    public function show($slug)
    {
        $category = $this->model->findByOrFail(['slug' => $slug], ['children:id,parent_id']);
        
        $posts = $this->modelPost->makeQuery([
            ['categories', 'RELATION', [fn($q) => $q->whereIn('id', $category->children->pluck('id')->push($category->id))]]
        ])->published()->paginate(10);

        return view('public.blog.index')

        ->with('category', $category)

        ->with('posts', $posts)

        ->with('breadcrums', $this->breadcrums()->addByUrl(trans('Blog'), route('blog.index'))->add($category->name));
    }
}
