## 全局返回 JSON

强制响应为 JSON，省略每个 Action 都要设置响应输出，首先加入 `middleware.php`

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
