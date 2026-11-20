<?php

namespace App\Http\Controllers;

use App\Jobs\SendProxyJob;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function formRegister(Request $request) {
        return view("public.auth.formRegister");
    }

    public function postRegister(Request $request) {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'repassword' => 'required|same:password',
            'accept_terms' => 'accepted'
        ],[
            'name.required' => 'Họ tên là bắt buộc',
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã được sử dụng',
            'password.required' => 'Mật khẩu là bắt buộc',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'repassword.required' => 'Xác nhận mật khẩu là bắt buộc',
            'repassword.same' => 'Xác nhận mật khẩu không khớp',
            'accept_terms.accepted' => 'Bạn phải đồng ý với điều khoản dịch vụ'
        ]);

        $user = $this->authService->register($request->all());
        if(!$user) {
            session()->flash('error', 'Đăng ký thất bại. Vui lòng thử lại.');
            return redirect()->back()->withInput();
        }
        session()->flash('show_success_register_modal', true);
        return redirect()->route('home');
    }

    public function formLogin(Request $request) {
        return view("public.auth.formLogin");
    }

    public function postLogin(Request $request) {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ],[
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email không hợp lệ',
            'password.required' => 'Mật khẩu là bắt buộc',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
        ]);

        $credentials = $request->only('email', 'password');

        $user = $this->authService->login($credentials);

        if ($user) {
            return redirect()->intended(route('home'))->with('success', 'Đăng nhập thành công!');
        }

        return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng!']);
    }

    public function logout(Request $request) {
        $this->authService->logout($request);
        return redirect()->route('auth.login');
    }
}
