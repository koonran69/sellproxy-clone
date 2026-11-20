<?php

namespace App\Admin\Http\Controllers\Auth;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Auth\ProfileRequest;
use App\Core\Responses\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        $auth = auth('admin')->user();

        return view('admin.auth.profile', [
            'auth' => $auth,
            'breadcrums' => $this->breadcrums()->add(__('Profile'))
        ]);
    }

    public function update(ProfileRequest $request): RedirectResponse
    {
        auth('admin')->user()->update($request->validated());

        return Response::responseBack();
    }

}
