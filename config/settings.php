<?php
const LOGIN_EMAIL = 1;
const LOGIN_ID = 2;
return [
    'keycode' => [
        'keyup' => 38,
        'keydown' => 40,
    ],
    /*
    |--------------------------------------------------------------------------
    | System Setting
    |--------------------------------------------------------------------------
    */
    'google_drive' => [
        'url' => 'https://docs.google.com/uc?id=',
        'url_view' => 'https://drive.google.com/file/d/',
        'client_id' => env('GOOGLE_DRIVE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_DRIVE_CLIENT_SECRET'),
        'storage_id' => env('GOOGLE_DRIVE_FOLDER_ID'),
        'storage' => [
            'avatar' => '/1DvcpA6vq8A7jXvO_B70KMGOE97eVSTFK',
            'banner' => '/1P1i41dWMFvZHvmkRfOMFt_imHL8kHayR',
            'category' => '/1BzgSIcFUAKRtr3-WxmvvP4wLzdSYujKg',
            'event' => '/1tSoJkIUGfVWED_Er7B2HGgGzfQiHI64r',
            'export' => '/12qonJOiVOruYEJ58w-qyJqkRWGnppxeJ',
            'product' => '/19z_aMGGFjbohwYYHWRbORJ9hDV-fb2iE',
            'upload' => '/1HeKjfiZc9Fjggc7Iye21oXDbz2iNAqk3',
        ]
    ],
    /*
    |--------------------------------------------------------------------------
    | Customer login
    |--------------------------------------------------------------------------
    */
    'customer_login_case' => LOGIN_EMAIL, // Login case 1: only Email , 2 only ID
    'paginate' => [
        'admin' => [
            20, 50, 100, 250 , 500
        ],
        'expire_time' => 2147483647, // 2^31 - 1 maximum time value
    ],
    'cookie' => [
        'expire_time_max' => 2147483647/60, // 2^31 - 1 maximum time value
        'expire_time_1_month' => 43200, // 30 * 24 * 60 minutes per month
    ],
    'domain' => [
        'shop' => env('WEBSITE_DOMAIN_SHOP', 'noithatlucmo.com'),
        'ssl_shop' => env('WEBSITE_DOMAIN_SSL_SHOP', false),
        'admin' => env('WEBSITE_DOMAIN_ADMIN', 'admin.noithatlucmo.com'),
        'ssl_admin' => env('WEBSITE_DOMAIN_SSL_ADMIN', false),
        'finance' => env('WEBSITE_DOMAIN_FINANCE', 'finance.noithatlucmo.com'),
        'ssl_finance' => env('WEBSITE_DOMAIN_SSL_FINANCE', false),
        // setting finance
    ],
    /*
    |--------------------------------------------------------------------------
    | Setting shop
    |--------------------------------------------------------------------------
    */
    'shop' => [
        'hotline' => env('SHOP_SETTING_HOTLINE', '0123456789')
    ]
];
