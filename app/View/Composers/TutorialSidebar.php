<?php
 
namespace App\View\Composers;

use App\Core\Enums\BlogType;
use App\Core\Enums\DefaultStatus;
use App\Models\Category;
use Illuminate\View\View;

class TutorialSidebar
{
    public function compose(View $view): void
    {
        $data = Category::getToTree(
            [
                'status' => DefaultStatus::Published,
                'type' => BlogType::Tutorial
            ]
        );

        $view->with('data', $data);
    }
}