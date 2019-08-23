## Auth 登录鉴权

Auth 登录鉴权基于 JWT 方案，采用 Cookie 进行存储认证，使用前需要补充 JWT 配置 `config/jwt.php`

```php
return [
    'system' => [
        'auth' => 'system_token',
        'issuer' => 'system',
        'audience' => 'someone',
        'expires' => 3600,
        'auto_refresh' => 604800,
    ],
];
```

- **auth** `string` 存储在 Cookie 中的键名
- **issuer** `string` 发行者
- **audience** `string` 听众
- **expires** `int` 令牌有效期限，单位<秒>
- **auto_refresh** `int` 自动刷新期限，单位<秒>

> Auth 登录鉴权建议设定 `auto_refresh`，这样系统可以持续性自动更新鉴权 Token，从而不影响用户使用的体验

#### set(string $scene, array $symbol)

设置鉴权 Token

- **scene** `string` 场景标签
- **symbol** `array` 标识
- **Return** `bool`

登录成功后设定登录鉴权，加入用户与权限标识，Token 将自动存储在键名为 `system_token` 的 Cookie 中

> 如果是前后端分离，并且前端与后端所在域名不一致，请在 [CORS 跨站设置](/middleware/cors) 中启用 `allow_credentials`；如果前后端分离在同域下，需要增加 XSRF 防护

```php
Auth::set('system', [
    'username' => 'kain',
    'role' => 'system'
]);
```

#### verify(string $scene)

验证登录鉴权 Token

- **scene** `string` 场景标签
- **Return** `bool`

```php
Auth::verify('system');
```

#### symbol(string $scene)

获取标识

- **scene** `string` 场景标签
- **Return** `stdClass`

```php
Auth::symbol('system')

// {#68 ▼
//   +"username": "kain"
//   +"role": "system"
// }
```

#### clear(string $scene)

清除登录鉴权

```php
Auth::clear('system');
```

- **scene** `string` 场景标签