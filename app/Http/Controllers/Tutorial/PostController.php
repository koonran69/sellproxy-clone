<?php

namespace App\Http\Controllers\Tutorial;

use App\Core\Enums\BlogType;
use App\Core\Enums\DefaultStatus;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;

class PostController extends Controller
{
    public function __construct(
        public Post $model,

    )
    {

    }
    public function show($slug)
    {
        $post = $this->model->findByOrFail(['slug' => $slug]);
        $relatedPosts = $this->model->where('id', '!=', $post->id)
            ->orderBy('created_at', 'desc')
            ->where('type', BlogType::Tutorial)
            ->where('status', DefaultStatus::Published)
            ->limit(10)->get();

        $firstCategory = $post->categories()->orderBy('id')->first();

        return view('public.tutorial.posts.show')
        ->with('meta_title', $post->title_seo)
        ->with('post', $post)->with('relatedPosts', $relatedPosts)

        ->with('breadcrums', $this->breadcrums()
            ->add($firstCategory->getTranslation('name', app()->getLocale()), route('tutorial.category.show', ['slug' =>
                $firstCategory->slug]))
            ->add($post->getTranslation('title', app()->getLocale(), false) ?: $post->getTranslation('title', 'vi')));
    }
}
