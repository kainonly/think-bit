## 响应返回 JSON

使用 `JsonResponse` 中间件的路由响应统一为 JSON，首先加入 `middleware.php`

```php
<?php
return [
    'json' => \think\bit\middleware\JsonResponse::class
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
