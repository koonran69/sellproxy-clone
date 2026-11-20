<?php
 
namespace App\View\Composers;

use App\Core\Enums\BlogType;
use App\Core\Enums\DefaultStatus;
use App\Models\Category;
use Illuminate\View\View;

class BlogSidebar
{
    public function compose(View $view): void
    {
        $data = Category::getToTree(
            [
                'status' => DefaultStatus::Published,
                'type' => BlogType::Blog
            ]
        );

        $view->with('data', $data);
    }
}