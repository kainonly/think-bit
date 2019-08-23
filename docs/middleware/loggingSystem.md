## LoggingSystem 系统日志 `实验`

LoggingSystem 系统日志是使用 Logging 日志收集器收集请求数据，异步监控每个请求所发送的数据, 首先需要完成 [Logging](/facade/logging) ，然后注册中间件，修改主配置目录下 `config/middleware.php`

```php
return [
    'loggingSystem' => \think\amqp\middleware\LoggingSystem::class
];
```

在控制器中使用

```php
namespace app\system\controller;

use think\Controller;

class Base extends Controller
{
    protected $middleware = ['loggingSystem'];
}
```

!> 使用前对应配置队列写入服务 https://github.com/kainonly/amqp-logging-service