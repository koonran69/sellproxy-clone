<?php

return [
    [
        'title' => 'Dashboard',
        'route_name' => 'admin.dashboard',
        'icon' => '<i class="ti ti-home"></i>',
        'sub' => []
    ],
    [
        'title' => 'Lịch sử đăng nhập Proxy',
        'route_name' => 'admin.proxy.history_login.index',
        'icon' => '<i class="ti ti-history"></i>',
        'sub' => []
    ],
    [
        'title' => 'Proxy',
        'route_name' => '',
        'icon' => '<i class="ti ti-brand-producthunt"></i>',
        'sub' => [
            [
                'title' => 'add',
                'route_name' => 'admin.proxy.create',
                'icon' => '<i class="ti ti-plus"></i>'
            ],
            [
                'title' => 'Danh sách',
                'route_name' => 'admin.proxy.index',
                'icon' => '<i class="ti ti-list"></i>',
            ],
            [
                'title' => 'Quản lý CDKey',
                'route_name' => 'admin.cdkey.index',
                'icon' => '<i class="ti ti-list"></i>',
            ],
            [
                'title' => 'Danh mục',
                'route_name' => 'admin.proxy.category.index',
                'icon' => '<i class="ti ti-category"></i>',
            ],
            [
                'title' => 'Loại',
                'route_name' => 'admin.proxy.type.index',
                'icon' => '<i class="ti ti-list-letters"></i>',
            ],
            [
                'title' => 'Thuộc tính',
                'route_name' => 'admin.proxy.attribute.index',
                'icon' => '<i class="ti ti-layout-distribute-vertical"></i>',
            ],
        ],
    ],

    [
        'title' => 'Proxy Line',
        'route_name' => '',
        'icon' => '<i class="ti ti-moneybag"></i>',
        'sub' => [
            [
                'title' => 'Quốc gia hỗ trợ',
                'route_name' => 'admin.proxy_country_available.index',
                'icon' => '<i class="ti ti-list"></i>'
            ],
            [
                'title' => 'Quản lý gói',
                'route_name' => 'admin.proxyline.index',
                'icon' => '<i class="ti ti-list"></i>'
            ]
        ]
    ],

    [
        'title' => 'Đơn hàng ProxyLine',
        'route_name' => 'admin.proxyline_order.index',
        'icon' => '<i class="ti ti-reorder"></i>',
        'sub' => []
    ],

    [
        'title' => 'Proxy Residential',
        'route_name' => '',
        'icon' => '<i class="ti ti-reorder"></i>',
        'sub' => [
            [
                'title' => 'Đơn hàng',
                'route_name' => 'admin.proxy_residential_order.index',
                'icon' => '<i class="ti ti-list"></i>',
            ],
            [
                'title' => 'Giao dịch',
                'route_name' => 'admin.proxy_residential_order.transaction.index',
                'icon' => '<i class="ti ti-list"></i>',
            ]
        ]
    ],

    [
        'title' => 'Home proxy',
        'route_name' => '',
        'icon' => '<i class="ti ti-reorder"></i>',
        'sub' => [
            [
                'title' => 'Đơn hàng',
                'route_name' => 'admin.homeproxy.index',
                'icon' => '<i class="ti ti-list"></i>',
            ],
            [
                'title' => 'Giao dịch',
                'route_name' => 'admin.homeproxy.transaction.index',
                'icon' => '<i class="ti ti-list"></i>',
            ]
        ]
    ],

    [
        'title' => 'VPS (sellvps247)',
        'route_name' => '',
        'icon' => '<i class="ti ti-reorder"></i>',
        'sub' => [
            [
                'title' => 'Đơn hàng',
                'route_name' => 'admin.vps.index',
                'icon' => '<i class="ti ti-list"></i>',
            ],
            [
                'title' => 'Giao dịch',
                'route_name' => 'admin.vps.transaction.index',
                'icon' => '<i class="ti ti-list"></i>',
            ]
        ]
    ],
    [
        'title' => 'Proxy (sellvps247)',
        'route_name' => '',
        'icon' => '<i class="ti ti-reorder"></i>',
        'sub' => [
            [
                'title' => 'Đơn hàng',
                'route_name' => 'admin.vps.proxy.indexProxy',
                'icon' => '<i class="ti ti-list"></i>',
            ],
            [
                'title' => 'Giao dịch',
                'route_name' => 'admin.vps.proxy.transactionProxy.index',
                'icon' => '<i class="ti ti-list"></i>',
            ]
        ]
    ],

    [
        'title' => 'Đơn hàng',
        'route_name' => '',
        'icon' => '<i class="ti ti-reorder"></i>',
        'sub' => [
            [
                'title' => 'add',
                'route_name' => 'admin.order.create',
                'icon' => '<i class="ti ti-plus"></i>'
            ],
            [
                'title' => 'Danh sách',
                'route_name' => 'admin.order.index',
                'icon' => '<i class="ti ti-list"></i>',
            ],
            [
                'title' => 'Voucher',
                'route_name' => 'admin.voucher.index',
                'icon' => '<i class="ti ti-ticket"></i>',
            ],
        ],
    ],

    [
        'title' => 'Khách hàng',
        'route_name' => '',
        'icon' => '<i class="ti ti-users"></i>',
        'sub' => [
            [
                'title' => 'Danh sách',
                'route_name' => 'admin.user.index',
                'icon' => '<i class="ti ti-list"></i>',
            ],
            [
                'title' => 'Hạng thành viên',
                'route_name' => 'admin.member_level.index',
                'icon' => '<i class="ti ti-chart-arrows-vertical"></i>',
            ],
        ],
    ],
    [
        'title' => 'Lịch sử nạp tiền',
        'route_name' => 'admin.deposit.index',
        'icon' => '<i class="ti ti-report-money"></i>',
        'sub' => []
    ],
    [
        'title' => 'Yêu cầu rút tiền',
        'route_name' => 'admin.withdrawal.index',
        'icon' => '<i class="ti ti-report-money"></i>',
        'sub' => []
    ],
    [
        'title' => 'Lịch sử giao dịch',
        'route_name' => 'admin.transaction.index',
        'icon' => '<i class="ti ti-transaction-dollar"></i>',
        'sub' => []
    ],
    [
        'title' => 'Blog',
        'route_name' => '',
        'icon' => '<i class="ti ti-book"></i>',
        'roles' => [],
        'sub' => [
            [
                'title' => 'Thêm bài viết',
                'route_name' => 'admin.blog.post.create',
                'icon' => '<i class="ti ti-plus"></i>',
            ],
            [
                'title' => 'Bài viết',
                'route_name' => 'admin.blog.post.index',
                'icon' => '<i class="ti ti-list"></i>',
            ],
            [
                'title' => 'Danh mục',
                'route_name' => 'admin.blog.category.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
            ]
        ]
    ],
    [
        'title' => 'Hướng dẫn',
        'route_name' => '',
        'icon' => '<i class="ti ti-book"></i>',
        'roles' => [],
        'sub' => [
            [
                'title' => 'Thêm bài viết',
                'route_name' => 'admin.tutorial.post.create',
                'icon' => '<i class="ti ti-plus"></i>',
            ],
            [
                'title' => 'Bài viết',
                'route_name' => 'admin.tutorial.post.index',
                'icon' => '<i class="ti ti-list"></i>',
            ],
            [
                'title' => 'Danh mục',
                'route_name' => 'admin.tutorial.category.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
            ]
        ]
    ],
    [
        'title' => 'Trang',
        'route_name' => '',
        'icon' => '<i class="ti ti-users"></i>',
        'sub' => [
            [
                'title' => 'Danh sách',
                'route_name' => 'admin.page.index',
                'icon' => '<i class="ti ti-list"></i>',
            ],
        ],
    ],
    [
        'title' => 'Admins',
        'route_name' => '',
        'icon' => '<i class="ti ti-user"></i>',
        'sub' => [
            [
                'title' => 'add',
                'route_name' => 'admin.admin.create',
                'icon' => '<i class="ti ti-plus"></i>'
            ],
            [
                'title' => 'list',
                'route_name' => 'admin.admin.index',
                'icon' => '<i class="ti ti-list"></i>'
            ]
        ]
    ],
    [
        'title' => 'Vai trò và quyền',
        'route_name' => '',
        'icon' => '<i class="ti ti-shield-lock"></i>',
        'sub' => [
            [
                'title' => 'Vai trò',
                'route_name' => 'admin.role.index',
                'icon' => '<i class="ti ti-list"></i>'
            ],
            [
                'title' => 'Quyền',
                'route_name' => 'admin.permission.index',
                'icon' => '<i class="ti ti-list"></i>'
            ]
        ]
    ],
    [
        'title' => 'Q&A',
        'route_name' => '',
        'icon' => '<i class="ti ti-question-mark"></i>',
        'sub' => [
            [
                'title' => 'add',
                'route_name' => 'admin.qa.create',
                'icon' => '<i class="ti ti-plus"></i>'
            ],
            [
                'title' => 'Danh sách',
                'route_name' => 'admin.qa.index',
                'icon' => '<i class="ti ti-list"></i>',
            ],
        ],
    ],
    [
        'title' => 'Liên hệ',
        'route_name' => '',
        'icon' => '<i class="ti ti-address-book"></i>',
        'sub' => [
            [
                'title' => 'Danh sách',
                'route_name' => 'admin.contact.index',
                'icon' => '<i class="ti ti-list"></i>',
            ],
        ],
    ],
    [
        'title' => 'Proxy Login Logs',
        'route_name' => 'admin.proxy_login_log.index',
        'icon' => '<i class="ti ti-history"></i>',
        'sub' => []
    ],
    [
        'title' => 'Cài đặt',
        'route_name' => '',
        'icon' => '<i class="ti ti-settings"></i>',
        'sub' => [
            [
                'title' => 'Chung',
                'route_name' => 'admin.setting.index',
                'icon' => '<i class="ti ti-tool"></i>',
                'param' => [
                    'group' => App\Core\Enums\Setting\SettingGroup::General->value,
                ],
            ],
            [
                'title' => 'Ngân hàng',
                'route_name' => 'admin.setting.bank_account',
                'icon' => '<i class="ti ti-building-bank"></i>',
                'roles' => [],
            ],

            [
                'title' => 'Mạng xã hội',
                'route_name' => 'admin.setting.index',
                'icon' => '<i class="ti ti-social"></i>',
                'param' => [
                    'group' => App\Core\Enums\Setting\SettingGroup::Social->value,
                ],
                'roles' => [],
            ],

            [
                'title' => 'Cấu hình Coin',
                'route_name' => 'admin.setting.index',
                'icon' => '<i class="ti ti-coins"></i>',
                'param' => [
                    'group' => App\Core\Enums\Setting\SettingGroup::Coin->value,
                ],
                'roles' => [],
            ],

            [
                'title' => 'Ẩn/Hiện nút xoá',
                'route_name' => 'admin.setting.index',
                'icon' => '<i class="ti ti-coins"></i>',
                'param' => [
                    'group' => App\Core\Enums\Setting\SettingGroup::TurnDelete->value,
                ],
                'roles' => [],
            ],
        ],
    ],
];
