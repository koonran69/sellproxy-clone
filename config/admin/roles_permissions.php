<?php

return [
    'cache_name' => 'admin-role-permission-',

    'route_name_prefix' => 'admin.',

    //Loai bo cac route khong duoc ap dung
    'whitelist_routes_name' => [
        'admin.ckfinder.browser',
        'admin.ckfinder.connector',
        'admin.logout',
        'admin.password.update',
        'admin.password.change',
        'admin.profile.update',
        'admin.profile.index',
        'admin.dashboard',
        'admin.login.index',
        'admin.login.handle',
        'admin.home'
    ]
];