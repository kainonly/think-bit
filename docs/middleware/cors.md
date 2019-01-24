## CORS 跨站访问

使用CORS中间定义跨站的请求策略，你需要在主配置或对应的模块下创建配置 `config/cors.php`，例如：

```php
return [
    'allow_origin' => [
        'https://api.developer.com'
    ],
    'with_credentials' => true,
    'option_max_age' => 2592000,
    'methods' => 'GET,OPTIONS,POST,PUT',
    'headers' => 'Content-Type,X-Requested-With,X-Token'
];
```

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

#### 配置详情

| 名称             | 类型    | 说明                   |
| ---------------- | ------- | ---------------------- |
| allow_origin     | array   | 允许跨域的域名         |
| with_credentials | boolean | 允许ajax请求携带Cookie |
| option_max_age   | boolean | 缓存OPTIONS请求        |
| methods          | string  | 允许请求类型           |
| headers          | string  | 允许定义的头部         |

!> 如果允许所有域名跨域，则将 `allow_origin` 设置为 `[*]`，但 `with_credentials` 将失效，并且ajax请求不能携带cookie。