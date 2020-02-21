## Token 令牌

Token 是 JSON Web Token 方案的功能服务，此服务必须安装 `kain/think-extra`，首先更新配置 `config/token.php`

```php
return [
    'system' => [
        'issuer' => 'system',
        'audience' => 'someone',
        'expires' => 3600,
    ],
];
```

当中 `system` `xsrf` 就是 `Token` 的 Label 标签，可以自行定义名称

- **issuer** `string` 发行者
- **audience** `string` 听众
- **expires** `int` 有效时间

安装后服务将自动注册可通过依赖注入使用

```php
use think\extra\contract\TokenInterface;

class Index extends BaseController
{
    public function index(TokenInterface $token)
    {
        $token->create('system', 'xxx-xxx-xxx-xxx', 'abc');
    }
}
```

#### create(string $scene, string $jti, string $ack, array $symbol = [])

生成令牌

- **scene** `string` 场景标签
- **jti** `string` Token ID
- **ack** `string` Token 确认码
- **symbol** `array` 标识组
- **Return** `\Lcobucci\JWT\Token|false`

```php
use think\support\facade\Token;

$token = Token::create('system', 'xxx-xxx-xxx-xxx', 'abc');

dump($token);
// Token {#81 ▼
//   -headers: array:3 [▼
//     "typ" => "JWT"
//     "alg" => "HS256"
//     "jti" => EqualsTo {#75 ▶}
//   ]
//   -claims: array:6 [▼
//     "iss" => EqualsTo {#73 ▶}
//     "aud" => EqualsTo {#74 ▶}
//     "jti" => EqualsTo {#75 ▶}
//     "ack" => Basic {#76 ▶}
//     "symbol" => Basic {#77 ▶}
//     "exp" => GreaterOrEqualsTo {#78 ▶}
//   ]
//   -signature: Signature {#80 ▼
//     #hash: b"’û²¦·å_ÞO6ÏŽÇ]g\x16€·GaoQã\tÁ\x1FT„Þíþ\x1E"
//   }
//   -payload: array:3 [▼
//     0 => "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImp0aSI6Inh4eC14eHgteHh4LXh4eCJ9"
//     1 => "eyJpc3MiOiJzeXN0ZW0iLCJhdWQiOiJldmVyeW9uZSIsImp0aSI6Inh4eC14eHgteHh4LXh4eCIsImFjayI6ImFiYyIsInN5bWJvbCI6W10sImV4cCI6MTU3MjU4NjU0Mn0"
//     2 => "kvuyprflX95PNs-Ox11nFoC3R2FvUeMJwR9UhN7t_h4"
//   ]
// }

dump((string)$token);

// "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImp0aSI6Inh4eC14eHgteHh4LXh4eCJ9.eyJpc3MiOiJzeXN0ZW0iLCJhdWQiOiJldmVyeW9uZSIsImp0aSI6Inh4eC14eHgteHh4LXh4eCIsImFjayI6ImFiYyIsInN5bWJvbCI6W10sImV4cCI6MTU3MjU4NjU0Mn0.kvuyprflX95PNs-Ox11nFoC3R2FvUeMJwR9UhN7t_h4 ◀"
```

#### get(string $tokenString)

获取令牌对象

- **tokenString** `string` 字符串令牌
- **Return** `\Lcobucci\JWT\Token`

```php
use think\support\facade\Token;

$tokenString = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImp0aSI6Inh4eC14eHgteHh4LXh4eCJ9.eyJpc3MiOiJzeXN0ZW0iLCJhdWQiOiJldmVyeW9uZSIsImp0aSI6Inh4eC14eHgteHh4LXh4eCIsImFjayI6ImFiYyIsInN5bWJvbCI6W10sImV4cCI6MTU3MjU4NjU0Mn0.kvuyprflX95PNs-Ox11nFoC3R2FvUeMJwR9UhN7t_h4';

$token = Token::get($tokenString);

dump($token);

// Token {#80 ▼
//   -headers: array:3 [▼
//     "typ" => "JWT"
//     "alg" => "HS256"
//     "jti" => EqualsTo {#75 ▶}
//   ]
//   -claims: array:6 [▼
//     "iss" => EqualsTo {#73 ▶}
//     "aud" => EqualsTo {#74 ▶}
//     "jti" => EqualsTo {#75 ▶}
//     "ack" => Basic {#76 ▶}
//     "symbol" => Basic {#77 ▶}
//     "exp" => GreaterOrEqualsTo {#78 ▶}
//   ]
//   -signature: Signature {#79 ▼
//     #hash: b"’û²¦·å_ÞO6ÏŽÇ]g\x16€·GaoQã\tÁ\x1FT„Þíþ\x1E"
//   }
//   -payload: array:3 [▼
//     0 => "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImp0aSI6Inh4eC14eHgteHh4LXh4eCJ9"
//     1 => "eyJpc3MiOiJzeXN0ZW0iLCJhdWQiOiJldmVyeW9uZSIsImp0aSI6Inh4eC14eHgteHh4LXh4eCIsImFjayI6ImFiYyIsInN5bWJvbCI6W10sImV4cCI6MTU3MjU4NjU0Mn0"
//     2 => "kvuyprflX95PNs-Ox11nFoC3R2FvUeMJwR9UhN7t_h4"
//   ]
// }
```

#### verify(string $scene, string $tokenString)

验证令牌有效性

- **scene** `string` 场景标签
- **tokenString** `string` 字符串令牌
- **Return** `stdClass`
  - **expired** `bool` 是否过期
  - **token** `\Lcobucci\JWT\Token` 令牌对象

```php
use think\support\facade\Token;

$tokenString = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImp0aSI6Inh4eC14eHgteHh4LXh4eCJ9.eyJpc3MiOiJzeXN0ZW0iLCJhdWQiOiJldmVyeW9uZSIsImp0aSI6Inh4eC14eHgteHh4LXh4eCIsImFjayI6ImFiYyIsInN5bWJvbCI6W10sImV4cCI6MTU3MjU4NjU0Mn0.kvuyprflX95PNs-Ox11nFoC3R2FvUeMJwR9UhN7t_h4';
$result = Token::verify('system', $tokenString);

dump($result);
// {#68 ▼
//   +"expired": false
//   +"token": Token {#80 ▼
//     -headers: array:3 [▶]
//     -claims: array:6 [▶]
//     -signature: Signature {#79 ▶}
//     -payload: array:3 [▶]
//   }
// }
```