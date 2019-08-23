## CORS 跨站设置

使用CORS中间定义跨站的请求策略，你需要在主配置或对应的模块下创建配置 `config/cors.php`，例如：

```php
return [

    'allow_origin' => [
        'http://localhost:3000',
    ],
    'allow_credentials' => false,
    'allow_methods' => ['GET', 'OPTIONS', 'POST', 'PUT'],
    'expose_headers' => [],
    'allow_headers' => ['Content-Type', 'X-Requested-With', 'X-Token'],
    'max_age' => 0,

];
```

- **allow_origin** `array` 允许访问该资源的外域 URI，对于不需要携带身份凭证的请求，服务器可以指定该字段的值为通配符 `['*']`
- **allow_credentials** `boolean` 允许浏览器读取response的内容
- **expose_headers** `array` 允许浏览器访问的头放入白名单
- **allow_headers** `string` 允许携带的首部字段
- **allow_methods** `array` 允许使用的 HTTP 方法
- **max_age** `int` preflight请求的结果能够被缓存多久


注册中间件 `config/middleware.php`

```php
return [
    'cors' => \think\bit\middleware\Cors::class
];
```

在控制器中引入

```php
abstract class BaseController
{

    protected $middleware = ['cors'];

}
```