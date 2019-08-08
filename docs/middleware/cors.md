## CORS 跨站访问

使用CORS中间定义跨站的请求策略，你需要在主配置或对应的模块下创建配置 `config/cors.php`，例如：

```php
return [
    'allow_origin' => [
        'https://api.developer.com'
    ],
    'with_credentials' => true,
    'option_max_age' => 2592000,
    'only_post' => false,
    'methods' => 'GET,OPTIONS,POST,PUT',
    'headers' => 'Content-Type,X-Requested-With,X-Token'
];
```

- **allow_origin** `array` 允许跨域的域名
- **with_credentials** `boolean` 允许跨域请求携带Cookie
- **option_max_age** `int` 缓存OPTIONS请求时长
- **only_post** `boolean` 仅允许POST请求跨域
- **methods** `string` 允许跨域的请求类型
- **headers** `string` 允许定义的头部

!> 如果存在通用域名跨域，跨域请求无法携带Cookie。

注册中间件，修改主配置目录下 `config/middleware.php`

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

在路由中使用

```php
Route::rule('index','index')->middleware('cors');
```