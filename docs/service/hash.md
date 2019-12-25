## Hash 密码

Hash 用于密码加密与验证，此服务必须安装 `kain/think-extra`，需要添加配置 `config/hashing.php`

```php
return [

    // 散列类型
    'driver' => 'argon2id',
    // Bcrypt 配置
    'bcrypt' => [
        'rounds' => env('BCRYPT_ROUNDS', 10),
    ],
    // Argon2i 与Argon2id 配置
    'argon' => [
        'memory' => 1024,
        'threads' => 2,
        'time' => 2,
    ],

];
```

- **driver** `bcrypt|argon|argon2id` 加密算法
- **bcrypt** `array` bcrypt 的配置
- **argon** `array` argon2i 与 argon2id 的配置

安装后服务将自动注册可通过依赖注入使用

```php
use think\extra\contract\HashInterface;

class Index extends BaseController
{
    public function index(HashInterface $hash)
    {
        $hash->create('123456');
    }
}
```

#### create($password, $options = [])

加密密码

- **password** `string` 密码
- **options** `array` 加密参数

```php
use think\support\facade\Hash;

Hash::create('123456789');
```

#### check($password, $hashPassword)

验证密码

- **password** `string` 密码
- **hashPassword** `string` 密码散列值

```php
use think\support\facade\Hash;

$hash = Hash::create('123456789');

// "$argon2id$v=19$m=65536,t=4,p=1$QmlpMEpNY2x3S0FMZ1phVg$XBhTEMcblOge1svlB2/5NNieCDfoT1BvJDinuyBwkKQ"

Hash::check('12345678', $hash);

// false

Hash::check('123456789', $hash);

// true
```