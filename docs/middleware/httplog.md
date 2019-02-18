## HttpLog 执行日志收集

使用 HttpLog 执行日志收集, 首先需要 `Rabbitmq` 配置 `config/rabbitmq.php` , 然后在主配置或对应的模块下设置配置 `config/log.php`

```php
return [
    'publish' => 'api.developer.com'
];
```

注册中间件，修改主配置目录下 `config/middleware.php`

```php
return [
    'httplog' => \bit\middleware\HttpLog::class,
];
```

在控制器中使用

```php
namespace app\index\controller;

use think\Controller;

class Index extends Controller
{
    protected $middleware = ['httplog'];

    public function index()
    {
        return 'index';
    }
}
```

在路由中使用

```php
Route::rule('index','index')->middleware('httplog');
```

#### 配置详情

| 名称    | 类型   | 说明     |
| ------- | ------ | -------- |
| publish | string | 发布域名 |