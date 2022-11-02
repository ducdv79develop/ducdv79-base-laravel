<?php

return [
    'version' => 'v1',
    'base_path' => '/packages/vietnamzone/migrations/',
    'data_base_path' => '/packages/vietnamzone/data/',
    'data_filename' => 'danh_sach_tinh_quan_huyen_phuong_xa___09_06_2022.xls',
    'data_file_version_export' => '09-06-2022',
    'migrations' => [
        'provinces' => '2022_01_01_000001_create_provinces_table.php',
        'districts' => '2022_01_01_000002_create_districts_table.php',
        'wards' => '2022_01_01_000003_create_wards_table.php',
    ],

    'tables' => [
        'provinces' => 'provinces',
        'districts' => 'districts',
        'wards' => 'wards',
    ],

    'columns' => [
        'province_id' => 'province_id',
        'district_id' => 'district_id',
        'name' => 'name',
        'address_code' => 'address_code',
        'rank' => 'rank',
        'name_en' => 'name_en',
    ],

    'code_default' => env('ADDRESS_CODE_DEFAULT', '31006'),
    'shipping_fee' => [
        'default' => 30000,
        'message' => 'Giao hàng trong vòng 24h trong bán kính 15km.',
        'message_error' => 'Địa chỉ này chưa được hỗ trợ giao hàng. Vui lòng liên hệ tư vấn 0915776440',
        'province_id' => [
            // demo province_id => shipping_fee
//            1 => 70000,    //  Hà Nội
            25 => 100000,  //  Ninh Bình
//            50 => 50000,   //  HCM
            58 => 30000,   //  Kiên Giang
            59 => 40000,   //  Cần Thơ
            63 => 50000,   //  Cà Mau
        ],
        'district_id' => [],
        'ward_id' => [],
    ],
];
