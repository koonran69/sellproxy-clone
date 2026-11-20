<?php

namespace App\View\Composers\Home;

use App\Models\Category;
use App\Models\Post;
use Illuminate\View\View;

class BlockTabPost
{
    public function compose(View $view): void
    {
        $posts = Post::getBy([], [], 4);
        $categories = Category::with('posts')->whereHas('posts')->published()->get();
        $view->with([
            'categories' => $categories,
            'posts' => $posts,
        ]);
    }
}
