<?php

return [
    "environment" => env("COINGATE_ENV"),
    'api_key' => env("COINGATE_API_KEY"),
    "callback_url" => env("COINGATE_CALLBACK_URL"),
    "success_url" => env("COINGATE_SUCCESS_URL"),
    "cancel_url" => env("COINGATE_CANCEL_URL")
];