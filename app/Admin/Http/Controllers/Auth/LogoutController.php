<?php

namespace App\Admin\Http\Controllers\Auth;

use App\Admin\Http\Controllers\Controller;
use App\Core\Responses\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    //
    public function logout(Request $request): RedirectResponse
    {
        auth('admin')->logout();

        $request->session()->invalidate();
 
        $request->session()->regenerateToken();

        return Response::toRoute('admin.login.index', msg: __('Logout Success.'));
    }
}
