# CORS 跨域资源共享

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