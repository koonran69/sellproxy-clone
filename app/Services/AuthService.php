<?php

namespace App\Services;

use App\Core\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    private $userRepo;

    public function __construct(UserRepositoryInterface  $userRepo) {
        $this->userRepo = $userRepo;
    }

    public function register($data) {
        try {
            $data['password'] = Hash::make($data['password']);
            return $this->userRepo->create($data);
        } catch (\Exception $exception) {
            \Log::info('user register fail', [ $exception->getMessage() ]);
        }
        return false;
    }

    public function login(array $credentials) {
        if (Auth::attempt($credentials)) {
            return Auth::user();
        }
        return false;
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

    }
}