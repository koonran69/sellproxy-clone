<?php

namespace App\Http\Controllers;

use App\Core\Supports\Breadcrums;

abstract class Controller
{
    //
    public function breadcrums()
    {
        $this->breadcrums = (new Breadcrums)->addByUrl(trans('Trang chủ'), route('home'));

        return $this->breadcrums;
    }
}
