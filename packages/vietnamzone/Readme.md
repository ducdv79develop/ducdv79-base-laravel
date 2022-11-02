## Thư viện API tỉnh thành phố khu vực Việt Nam.

- Chúng ta sẽ khai báo "name" của Package tại "require" và khai báo thư mục chứa Package tại "repositories".


<pre>
{
    ...
    "require": {
        ...
        "packages/vietnamzone": "*"
    },
    ...
    "repositories": [
        {
            "type": "path",
            "url": "./packages/*"
        }
    ]
}
</pre>

- Khởi chạy "composer update" để composer nạp "packages/vietnamzone" vào vendor

<pre>
php artisan vietnamzone:migrate
php artisan vietnamzone:migrate_import
// or
php artisan vietnamzone:migrate --import
</pre>
