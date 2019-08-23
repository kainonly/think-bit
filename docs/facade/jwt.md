## Jwt 令牌

Jwt 是目前最流行的跨站身份验证解决方案之一，首先更新配置 `config/jwt.php` 设定生成 JWT 的标签

```php
return [
    'system' => [
        'auth' => 'system_token',
        'issuer' => 'system',
        'audience' => 'someone',
        'expires' => 3600,
        'auto_refresh' => 604800,
    ],
    'xsrf' => [
        'issuer' => 'system',
        'audience' => 'someone',
        'expires' => 120,
        'auto_refresh' => 0
    ]
];
```

当中 `system` `xsrf` 就是 `JWT` 的 Label 标签，可以自行定义名称

- **auth** `string` 存储在 Cookie 中的键名，用于 [Auth 用户鉴权](/facade/auth) 
- **issuer** `string` 发行者
- **audience** `string` 听众
- **expires** `int` 令牌有效期限，单位<秒>
- **auto_refresh** `int` 自动刷新期限，单位<秒>

> 当 `auto_refresh` 为 `0` 时，生成的 Token 将不会自动刷新，当大于 `0` 时，JWT 会存储对应的 Token ID 的 Refresh Token 在 Redis 中，JWT 将自动验证 Token 有效性进行自动刷新

#### setToken(string $scene, array $symbol = [])

生成 Token

- **scene** `string` 场景标签
- **symbol** `array` 标识

生成一次性 Xsrf Token

```php
$token = Jwt::setToken('xsrf', [
    'random' => Str::random()
]);
```

#### verify(string $scene, string $token)

验证 Token 有效性

- **scene** `string` 场景标签
- **token** `string` 字符串 Token

```php
 $result = Jwt::verify('xsrf', $token);
```

#### getToken(string $token = null)

获取 Token 对象

- **token** `string` 字符串 Token

> `token` 参数不设定时会从执行 `setToken` 或 `verify` 中获取所属的 Token 对象

```php
$stoken = Jwt::setToken('xsrf', [
    'random' => Str::random()
]);

Jwt::verify('xsrf', $stoken);

$token = Jwt::getToken();

dump($token->getClaim('symbol'));

// {#85 ▼
//   +"random": "p7uxKYWSDDor4wm1"
// }
```