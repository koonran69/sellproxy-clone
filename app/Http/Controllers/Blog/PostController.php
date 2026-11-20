<?php

namespace App\Http\Controllers\Blog;

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
            ->where('type', BlogType::Blog)
            ->where('status', DefaultStatus::Published)
            ->limit(10)->get();

        $firstCategory = $post->categories()->orderBy('id')->first();

        // 1. Xử lý an toàn cho breadcrumb của Category (phòng trường hợp bài viết không có danh mục nào)
        $breadcrumbs = $this->breadcrums();

        if ($firstCategory) {
            $breadcrumbs->add(
                $firstCategory->getTranslation('name', app()->getLocale()),
                route('blog.category.show', ['slug' => $firstCategory->slug])
            );
        }

        // 2. Xử lý an toàn cho tiêu đề bài viết (fallback sang ngôn ngữ mặc định nếu bản dịch hiện tại trống)
        $currentLocale = app()->getLocale();
        $postTitle = $post->getTranslation('title', $currentLocale, false)
            ?: $post->getTranslation('title', 'vi')
                ?: $post->title; // Fallback cuối cùng nếu có cột title thông thường

        $breadcrumbs->add($postTitle);

        return view('public.blog.posts.show')
            ->with('meta_title', $post->title_seo)
            ->with('post', $post)
            ->with('relatedPosts', $relatedPosts)
            ->with('breadcrums', $breadcrumbs);
    }
}
