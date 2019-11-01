## Refresh Token 缓存

Refresh Token 是用于自动刷新、验证对应 Token 的缓存模型

#### factory(string $jti, string $ack, int $expires)

生产 Token 对应的 Refresh Token

- **jti** `string` JSON Web Token ID
- **ack** `string` Token ID 验证码
- **expires** `int` 有限时间，单位<秒>
- **Return** `bool`

```php
$jti = Ext::uuid()->toString();
$ack = Str::random();

$token = (new Builder())
    ->issuedBy($issuer)
    ->permittedFor($audience)
    ->identifiedBy($jti, true)
    ->withClaim('ack', $ack)
    ->expiresAt(time() + $expires)
    ->getToken($signer, new Key($secret));

RefreshToken::create()->factory($jti, $ack, $auto_refresh);
```

#### verify(string $jti, string $ack)

验证 Token 的 Token ID 有效性

- **jti** `string` JSON Web Token ID
- **ack** `string` Token ID 验证码
- **Return** `bool`

```php
RefreshToken::create()->verify($jti, $ack);
```

#### clear(string $jti, tring $ack)

清除 Token 对应的 Refresh Token

- **jti** `string` JSON Web Token ID
- **ack** `string` Token ID 验证码
- **Return** `bool`

```php
RefreshToken::create()->clear($jti, $ack);
```