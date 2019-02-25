## LogSystem 系统日志

使用 LogSystem 系统日志, 首先需要 `Rabbitmq` 配置 `config/rabbitmq.php` , 然后在主配置或对应的模块下设置配置 `config/log.php`

```php
return [
    'publish' => 'api.developer.com',
    'exchange' => 'log.system',
    'queue' => 'log.system'
];
```

- **publish** 发布域名
- **exchange** 交换器
- **queue** 队列

注册中间件，修改主配置目录下 `config/middleware.php`

```php
return [
    'log_system' => think\bit\middleware\LogSystem::class
];
```

在控制器中使用

```php
namespace app\system\controller;

use think\Controller;

class Base extends Controller
{
    protected $middleware = ['log_system'];
}
```

!> 使用前对应配置队列写入服务 https://github.com/kainonly/collection-service