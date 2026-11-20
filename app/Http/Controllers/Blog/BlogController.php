<?php

namespace App\Http\Controllers\Blog;

use App\Core\Enums\BlogType;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;

class BlogController extends Controller
{

    public function __construct(
        public Post $modelPost
    )
    {

    }

    public function index()
    {
        $posts = $this->modelPost->makeQuery(['type' => BlogType::Blog])->published()->paginate(10);

        return view('public.blog.index')

        ->with('posts', $posts)

        ->with('breadcrums', $this->breadcrums()->add(trans('Hướng dẫn')));
    }
}
