## 过滤 POST 请求

将 Restful API 请求全局统一为 `POST` 类型，首先加入 `middleware.php`

```php
<?php
return [
    'post' => \think\bit\middleware\FilterPostRequest::class,
];
```

在控制器中重写 `$middleware`

```php
<?php

namespace app\index\controller;

use app\index\BaseController;

class Index extends BaseController
{
    protected $middleware = ['post'];

    public function index()
    {
        return [];
    }
}
```