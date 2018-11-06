# CORS 跨域资源共享

跨域资源共享(CORS) 是一种机制，它使用额外的 HTTP 头来告诉浏览器  让运行在一个 origin (domain) 上的Web应用被准许访问来自不同源服务器上的指定的资源。当一个资源从与该资源本身所在的服务器不同的域或端口请求一个资源时，资源会发起一个跨域 HTTP 请求。

#### 配置

在ThinkPHP项目中下创建 `config/cors.php`

```php
return [
    'allow_origin' => [
        'http://localhost',
        'https://any.com'
    ],
    'with_credentials' => true,
    'option_max_age' => 2592000,
    'methods' => 'POST',
    'headers' => 'Content-Type,X-Requested-With,X-Token'
];
```

- `allow_origin` 允许跨域的域名
- `with_credentials` 开启同源策略
- `option_max_age` 缓存option请求
- `methods` 允许请求类型
- `headers` 允许请求头部

修改ThinkPHP项目中 `config/middleware.php`

```php
return [
    'cors' => \bit\middleware\Cors::class,
];
```

在控制器中使用

```php
namespace app\index\controller;

use think\Controller;

class Index extends Controller
{
    protected $middleware = ['cors'];

    public function index()
    {
        return 'index';
    }
}
```