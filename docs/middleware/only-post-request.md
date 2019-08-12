## 只允许 POST 请求

使用 `OnlyPostRequest` 中间件限制 POST 以外的请求方式，首先加入 `middleware.php`

```php
<?php
return [
    'post' => \think\bit\middleware\OnlyPostRequest::class,
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