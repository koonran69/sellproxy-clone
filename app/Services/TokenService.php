<?php

namespace App\Services;

use Firebase\JWT\JWT;

class TokenService
{
    private $validUsername;
    private $validPassword;
    private $secretKey;

    public function __construct() {
        $this->validUsername = config('payment.token_auth_basic.username');
        $this->validPassword = config('payment.token_auth_basic.password');
        $this->secretKey = config('payment.token_auth_basic.secret_key');
    }

    public function generateToken() {

        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            http_response_code(400);
            return ["error" => "Authorization header is missing or invalid"];
        }

        $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
        if (strpos($authHeader, 'Basic ') !== 0) {
            http_response_code(400);
            return ["error" => "Invalid Authorization header"];
        }

        $base64Credentials = substr($authHeader, 6);
        $credentials = base64_decode($base64Credentials);
        list($username, $password) = explode(':', $credentials);

        if ($username === $this->validUsername && $password === $this->validPassword) {
            $token = $this->createJwtToken($username);
            return [
                "access_token" => $token,
                "token_type" => "Bearer",
                "expires_in" => 300
            ];
        } else {
            http_response_code(401);
            return ["error" => "Invalid credentials"];
        }
    }

    private function createJwtToken($username) {
        $issuedAt = time();
        $expirationTime = $issuedAt + 300;
        $payload = [
            'iss' => env('APP_URL'),
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'username' => $username
        ];

        return JWT::encode($payload, $this->secretKey, 'HS512');
    }
}