## Auth 登录鉴权

Auth 创建登录后将 Token 字符串存储在Cookie 中，通过主控制去引用该特性

```php
use app\system\controller\BaseController;
use think\support\traits\Auth;

class Main extends BaseController
{
    use Auth;
}
```

#### refreshTokenExpires()

设置令牌自动刷新的总时效，通过重写自定义

- **Return** `int` 默认 `604800`，单位< 秒 >

```php
use app\system\controller\BaseController;
use think\support\traits\Auth;

class Main extends BaseController
{
    use Auth;

    protected function refreshTokenExpires()
    {
        return 7200;
    }
}
```

#### create(string $scene, array $symbol = [])

创建登录鉴权

- **scene** `string` 场景标签
- **symbol** `array` 标识
- **Return** `array`

在登录验证成功后调用

```php
use app\system\controller\BaseController;
use think\support\traits\Auth;

class Main extends BaseController
{
    use Auth;

    public function login()
    {
        // $raws = ...
        // ...
        // 登录验证成功

        return $this->create('system', [
            'user' => $raws['username'],
            'role' => explode(',', $raws['role'])
        ]);
    }
}
```

#### authVerify(string $scene)

验证登录

- **scene** `string` 场景标签

```php
use app\system\controller\BaseController;
use think\support\traits\Auth;

class Main extends BaseController
{
    use Auth;

    public function verify()
    {
        return $this->authVerify('system');
    }
}
```

#### destory(string $scene)

销毁登录鉴权

- **scene** `string` 场景标签

```php
use app\system\controller\BaseController;
use think\support\traits\Auth;

class Main extends BaseController
{
    use Auth;

    public function logout()
    {
        return $this->destory('system');
    }
}
```