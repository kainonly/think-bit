## Auth 鉴权验证

AuthVerify 鉴权验证是一个抽象定义中间件，使用时需要根据场景继承定义，例如

```php
class SystemAuthVerify extends AuthVerify
{
    protected $scene = 'system';
}
```

- **scene** `string` 场景标签

然后在将中间件注册在应用的 `middleware.php` 配置下

```php
return [
    'auth' => \app\system\middleware\SystemAuthVerify::class
];
```

在控制器中重写 `$middleware`

```php
<?php

namespace app\system\controller;

class Index extends BaseController
{
    protected $middleware = ['auth'];

    public function index()
    {
        return [];
    }
}
```