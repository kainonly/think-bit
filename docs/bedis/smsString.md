## SmsString 短信验证

手机短信验证码缓存类

#### factory($phone, $code, $timeout)

设置手机验证码缓存

- `phone` string，手机号
- `code` string，验证码
- `timeout` int，超时时间，默认60秒
- 返回 `bool`

#### check($phone, $code, $once)

验证手机验证码

- `phone` string，手机号
- `code` string，验证码
- `once` bool，验证成功后失效，默认`false`
- 返回 `bool`

#### time($phone)

获取验证时间

- `phone` string，手机号
- 返回 `bool`