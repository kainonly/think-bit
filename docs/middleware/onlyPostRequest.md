## 只允许 POST 请求

在前后端分离场景下，请求全局采用 `POST` 类型，可以避免请求字段清晰泄漏，防止请求直接被恶意利用，首先加入 `middleware.php`

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