<?php

return [
    // Cấu hình cho Key Xoay
    'rotate_keys' => [
        ['id' => '8ecf9d6e-e464-4c48-9436-f9f00b8dc46c', 'title' => 'Key xoay 1 ngày', 'price' => 3000, 'old_price' => 4000, 'unit' => 'day', 'label' => 'Ngày sử dụng'],
        ['id' => 'd103f032-527f-4fa2-8f80-484ee58158ee', 'title' => 'Key xoay 1 tuần', 'price' => 21000, 'old_price' => 28000, 'unit' => 'week', 'label' => 'Tuần sử dụng'],
        ['id' => '65565a69-d004-43e8-8eab-a4763275ecd3', 'title' => 'Key xoay 1 tháng', 'price' => 67500, 'old_price' => 90000, 'unit' => 'month', 'label' => 'Tháng sử dụng'],
    ],

    // Cấu hình cho Datacenter Proxy
    'datacenter_proxies' => [
        'Vietnam' => [
            'id' => 'c669945e-3ad3-4705-8462-6e91080f8efd',
            'provider' => 'CMC',
            'name' => 'Vietnam', 'flag' => 'data-vn.png',
            'price' => 28000, 'old_price' => 47500, 'base_discount_label' => '-41%',
            'tiers' => [2 => 0.05, 3 => 0.10]
        ],
        'USA' => [
            'id' => '66e4bfec-a4f0-4079-b73b-8fbb068f07b6',
            'provider' => 'US',
            'name' => 'USA', 'flag' => 'data-us.png',
            'price' => 16500, 'old_price' => null, 'base_discount_label' => null,
            'tiers' => [2 => 0.05, 3 => 0.10, 4 => 0.20]
        ],
    ],

    'combos' => [
        // --- Nhóm Proxy Tĩnh (3 gói) ---
        ["id" => "38b5b6f3-c342-4674-acfa-390fd83d6670", "name" => "Combo 100 Proxy Tĩnh", "price" => 100000, "discount_rules" => ["min_unit" => 30, "percent" => 40], "category" => ["unit" => "ngày", "type_unit"=>"day"], "slug" => "combo-tinh-viettel", 'provider'=>'VIETTEL', "proxy_count" => 100, "logo" => "public/proxyhome/assets/images/viettel.png", "width_flag" => 90],
        ["id" => "38b5b6f3-c342-4674-acfa-390fd83d6670", "name" => "Combo 100 Proxy Tĩnh", "price" => 100000, "discount_rules" => ["min_unit" => 30, "percent" => 40], "category" => ["unit" => "ngày", "type_unit"=>"day"], "slug" => "combo-tinh-vnpt", 'provider'=>'VNPT', "proxy_count" => 100, "logo" => "public/proxyhome/assets/images/vnpt.png", "width_flag" => 90],
        ["id" => "38b5b6f3-c342-4674-acfa-390fd83d6670", "name" => "Combo 100 Proxy Tĩnh", "price" => 100000, "discount_rules" => ["min_unit" => 30, "percent" => 40], "category" => ["unit" => "ngày", "type_unit"=>"day"], "slug" => "combo-tinh-fpt", 'provider'=>'FPT', "proxy_count" => 100, "logo" => "public/proxyhome/assets/images/fpt.png", "width_flag" => 90],

        // --- Nhóm Proxy DC VN (2 gói) ---
        ["id" => "846f1870-4724-439e-9613-f01a79831a8a", "name" => "Combo 50 Proxy DC VN", "price" => 1260000, "discount_rules" => ["tiers" => [[2, 5], [3, 10], [4, 20]]], "category" => ["unit" => "tháng", "type_unit"=>"month"], "slug" => "combo-dc-vn-50", 'provider' => 'CMC', "proxy_count" => 50, "logo" => "public/proxyhome/assets/images/flags/data-vn.png", "width_flag" => 60],
        ["id" => "fa821010-9fb0-4dbc-8b2e-47bb6b9ebe7c", "name" => "Combo 100 Proxy DC VN", "price" => 2240000, "discount_rules" => ["tiers" => [[2, 5], [3, 10], [4, 20]]], "category" => ["unit" => "tháng", "type_unit"=>"month"], "slug" => "combo-dc-vn-100", 'provider' => 'CMC', "proxy_count" => 100, "logo" => "public/proxyhome/assets/images/flags/data-vn.png", "width_flag" => 60],

        // --- Nhóm Proxy DC US (2 gói) ---
        ["id" => "6d215f57-f478-4754-bf1f-77f394f16f88", "name" => "Combo 50 Proxy DC US", "price" => 742500, "discount_rules" => ["tiers" => [[2, 5], [3, 10], [4, 20]]], "category" => ["unit" => "tháng", "type_unit"=>"month"], "slug" => "combo-dc-us-50", 'provider' => 'US', "proxy_count" => 50, "logo" => "public/proxyhome/assets/images/flags/data-us.png", "width_flag" => 60],
        ["id" => "0c641ece-a068-4a40-8718-ec30a38aab53", "name" => "Combo 100 Proxy DC US", "price" => 1320000, "discount_rules" => ["tiers" => [[2, 5], [3, 10], [4, 20]]], "category" => ["unit" => "tháng", "type_unit"=>"month"], "slug" => "combo-dc-us-100", 'provider' => 'US', "proxy_count" => 100, "logo" => "public/proxyhome/assets/images/flags/data-us.png", "width_flag" => 60]
    ],

    'locations' => [ 'random' => 'Random', 'HCM' => 'Hồ Chí Minh', 'BDG' => 'Bình Dương', 'HNI' => 'Hà Nội'],
    'providers' => [ 'VIETTEL', 'FPT', 'VNPT' ],
    'unit_prices' => [
        'VIETTEL' => 1200,
        'FPT'     => 1200,
        'VNPT'    => 1200,
    ],
    'unit_price_rotate' => [
        'day' => 3000,
        'week'     => 21000,
        'month'    => 67500,
    ],
    'product_ids' => [
        'static' => [
            'VIETTEL' => '39742e9f-60ea-4052-b1e9-e5b8eaa29aaa',
            'FPT'     => '1784349e-079d-4edd-8556-7636e0d83d3e',
            'VNPT'    => 'b3841c84-a7ed-4027-9840-61e0124f6097',
        ],
        'rotate' => [
            'day' => '8ecf9d6e-e464-4c48-9436-f9f00b8dc46c',
            'week'     => 'd103f032-527f-4fa2-8f80-484ee58158ee',
            'month'    => '65565a69-d004-43e8-8eab-a4763275ecd3',
        ]
    ],
    'protocols' => ['http','socks'],

    'base_url' => env('HOMEPROXY_BASE', 'https://api.homeproxy.vn'),
    'phone'    => env('HOMEPROXY_PHONE'),
    'password' => env('HOMEPROXY_PASSWORD'),
    'early_refresh_seconds' => 60,
    'fallback_token_ttl' => 30 * 60,
    'unit_price_static' => [
        1 => 1200,
        2 => 2400,
        3 => 3600,
        4 => 4800,
        5 => 6000,
        6 => 6480,
        7 => 7560,
        8 => 8640,
        9 => 9720,
        10 => 10800,
        11 => 10560,
        12 => 11520,
        13 => 12480,
        14 => 13440,
        15 => 14400,
        16 => 15360,
        17 => 16320,
        18 => 17280,
        19 => 18240,
        20 => 19200,
        21 => 17640,
        22 => 18480,
        23 => 19320,
        24 => 20160,
        25 => 21000,
        26 => 18720,
        27 => 19440,
        28 => 20160,
        29 => 20880,
        30 => 21600
    ]
];

// array:2 [ // app/Services/ProxyRotateOrderService.php:163
//   "paymentMethod" => "WALLET"
//   "products" => array:1 [
//     0 => array:8 [
//       "rotateInterval" => 0
//       "provider" => "HOMEPROXY"
//       "dayOfUse" => 1
//       "password" => "TG@F%x-k1osu"
//       "user" => "sel_251230_vyjh"
//       "protocolType" => "HTTP"
//       "quantity" => 1
//       "product" => array:1 [
//         "id" => "8ecf9d6e-e464-4c48-9436-f9f00b8dc46c"
//       ]
//     ]
//   ]
// ]

// array:2 [ // app/Services/ProxyRotateOrderService.php:163
//   "paymentMethod" => "WALLET"
//   "products" => array:1 [
//     0 => array:8 [
//       "rotateInterval" => 0
//       "provider" => "HOMEPROXY"
//       "dayOfUse" => 7
//       "password" => "zgqm_@88mQ@A"
//       "user" => "sel_251230_zlrc"
//       "protocolType" => "HTTP"
//       "quantity" => 1
//       "product" => array:1 [
//         "id" => "d103f032-527f-4fa2-8f80-484ee58158ee"
//       ]
//     ]
//   ]
// ]
