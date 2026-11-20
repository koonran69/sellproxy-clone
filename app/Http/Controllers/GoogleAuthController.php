<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class GoogleAuthController extends Controller
{
    public function handleGoogleLogin(Request $request)
    {
        $token = $request->input('token');

        $response = Http::get("https://www.googleapis.com/oauth2/v3/userinfo", [
            'access_token' => $token
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Invalid Google token'], 401);
        }

        $googleUser = $response->json();

        $user = User::where('email', $googleUser['email'])->first();

        if (!$user) {
            $user = User::create([
                'name' => $googleUser['name'],
                'email' => $googleUser['email'],
                'google_id' => $googleUser['sub'],
                'password' => bcrypt(str()->random(16))
            ]);
        }

        Auth::login($user);

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'redirect_url' => '/'
        ]);
    }
}
