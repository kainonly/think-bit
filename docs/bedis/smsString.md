## SmsString

手机验证码缓存类

#### factory(string $phone, string $code, int $timeout = 60)

设置手机验证码缓存

- `phone` 手机号
- `code` 验证码
- `timeout` 超时时间，默认60秒

#### check(string $phone, string $code, bool $once = false)

验证手机验证码

- `phone` 手机号
- `code` 验证码
- `once` 验证成功后失效，默认`false`