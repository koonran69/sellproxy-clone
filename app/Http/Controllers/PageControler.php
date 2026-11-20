<?php

namespace App\Http\Controllers;

use App\Core\Enums\DefaultStatus;
use App\Models\Coin;
use App\Models\Page;
use Illuminate\Http\Request;

class PageControler extends Controller
{
    public function aboutPage(Request $request) {
        $page = Page::where('slug', 'gioi-thieu')->first();
        $data['page'] = $page;
        return view("public.pages.about")->with($data);
    }
}
