## LogSystem 系统日志

使用 SystemLog 系统日志, 首先需要配置 `Rabbitmq` , 然后修改配置 `config/queue.php`

```php
return [
    'daq' => [
        'exchange' => 'system',
        'queue' => 'system'
    ]
];
```

- **exchange** 交换器
- **queue** 队列

注册中间件，修改主配置目录下 `config/middleware.php`

```php
return [
    'systemLog' => think\bit\middleware\SystemLog::class
];
```

在控制器中使用

```php
namespace app\system\controller;

use think\Controller;

class Base extends Controller
{
    protected $middleware = ['systemLog'];
}
```

!> 使用前对应配置队列写入服务 https://github.com/kainonly/collection-service