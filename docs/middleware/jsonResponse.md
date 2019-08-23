## 全局返回 JSON

因为在 `ThinkPHP6` 中 `default_return_type` 已经废弃，而请求没有定义 `Content-Type:application/json` 默认是不会采用 `json` 返回，所以使用 `JsonResponse` 中间件可以强制响应为 JSON，避免每个 Action 都要设置响应输出，首先加入 `middleware.php`

```php
<?php
return [
    'json' => \think\bit\middleware\JsonResponse::class,
];
```

在控制器中重写 `$middleware`

```php
<?php

namespace app\index\controller;

use app\index\BaseController;

class Index extends BaseController
{
    protected $middleware = ['json'];

    public function index()
    {
        return [];
    }
}
```
