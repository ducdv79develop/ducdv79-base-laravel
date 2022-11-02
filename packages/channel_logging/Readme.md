## Mẫu tạo thư viện.

- Chúng ta sẽ khai báo "name" của Package tại "require" và khai báo thư mục chứa Package tại "repositories".


<pre>
{
    ...
    "require": {
        ...
        "packages/channel_logging": "dev-main"
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

- Khởi chạy "composer update" để composer nạp "packages/channel_logging" vào vendor
