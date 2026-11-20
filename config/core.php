<?php
if (!function_exists('host_proxy_residential')) {
    function host_proxy_residential() {
        $host = env('HOST_PROXY_RESIDENTIAL', '');
        if (!empty($host) && substr($host, -1, 1) != '/') {
            $host = $host . '/';
        }
        return $host;
    }
}

if (!function_exists('host_vps_api_server')) {
    function host_vps_api_server() {
        $host = env('HOST_VPS_API_SERVER', '');
        if (!empty($host) && substr($host, -1, 1) != '/') {
            $host = $host . '/';
        }
        return $host;
    }
}

if (!function_exists('host_vps_api')) {
    function host_vps_api() {
        $host = env('HOST_VPS_API', '');
        if (!empty($host) && substr($host, -1, 1) != '/') {
            $host = $host . '/';
        }
        return $host;
    }
}

return [
    'frontend_url' => env('APP_URL'),
    'images' => [
        'favicon' => '/public/core/assets/images/favicon-32x32.png',
        'avatar' => '/public/core/assets/images/avatar-user.png',
        'default' => '/public/core/assets/images/default-image.png',
        'logo' => '/public/core/assets/images/logo.png',
        'norecord' => '/public/core/assets/images/norecord.svg'
    ],
    'format' => [
        'datetime' => 'd-m-Y H:i',
        'date' => 'd-m-Y',
        'position_currency' => 'right'
    ],
    'currency' => 'đ',
    'date_range_limit_proxy' => [
        5, 30, 90, 360
    ],
    'proxy_line_api_key' => env('PROXYLINE_API_KEY'),
    'proxy_residential_key' => [
        'host' => host_proxy_residential(),
        'api_key' => env('PROXY_RESIDENTIAL_API_KEY'),
        'api_secret_key' => env('PROXY_RESIDENTIAL_API_SECRET_KEY'),
    ],
    'rate' => [
        'VND' => 36000,
        'USD' => 1
    ],
    'vps_key' => [
        'host_api_server' => host_vps_api_server(),
        'host_api' => host_vps_api(),
        'client_id' => env('VPS_API_CLIENT_ID'),
        'api_account_username' => env('VPS_API_ACCOUNT_USERNAME'),
        'api_account_password' => env('VPS_API_ACCOUNT_PASSWORD'),
    ]
];
