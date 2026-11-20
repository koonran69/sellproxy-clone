<?php

return [

    'viet_qr' => [
        'api_endpoint' => env('VIET_QR_API_ENDPOINT'),
        'username' => env('VIET_QR_USER_NAME'),
        'password' => env('VIET_QR_PASSWORD'),
        'bank_account' => env('VIET_QR_BANK_ACCOUNT'),
        'bank_code' => env('VIET_QR_BANK_CODE'),
        'user_bank_name' => env('VIET_QR_USER_BANK_NAME'),
    ],

    'token_auth_basic' => [
        'username' => env('TOKEN_AUTH_BASIC_USERNAME', 'ktech_test'),
        'password' => env('TOKEN_AUTH_BASIC_PASSWORD', '@ktech@123!@#'),
        'secret_key' => env('TOKEN_AUTH_BASIC_SECRET_KEY', 'zdCIwcYjt9HVUyMjUli3VzdG29GF2VyMbZXrdG11cta'),
    ],

    'heleket' => [
        'merchant_uuid' => env('HELEKET_MERCHANT_UUID', ''),
        'api_key' => env('HELEKET_API_KEY', ''),
        'api_url' => env('HELEKET_API_URL', 'https://api.heleket.com/v1/payment'),
    ],

];