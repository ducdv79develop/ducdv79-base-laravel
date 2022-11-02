## Gửi sms thông qua dịch vụ API của speedsms.

- Chúng ta sẽ khai báo "name" của Package tại "require" và khai báo thư mục chứa Package tại "repositories".


<pre>
{
    ...
    "require": {
        ...
        "packages/speedsms": "dev-main"
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

- Khởi chạy "composer update" để composer nạp "packages/speedsms" vào vendor
