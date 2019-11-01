## SMS 短信验证

手机短信验证码缓存类

#### factory($phone, $code, $timeout)

设置手机验证码缓存

- **phone** `string` 手机号
- **code** `string` 验证码
- **timeout** `int` 超时时间，默认60秒
- **Return** `bool`

```php
Sms::create()->factory('12345678910', '13125');
```

#### check($phone, $code, $once)

验证手机验证码

- **phone** `string` 手机号
- **code** `string` 验证码
- **once** `bool` 验证成功后失效，默认`false`
- **Return** `bool`

```php
$sms = Sms::create();
$checked = $sms->check('12345678910', '11224');
dump($checked);
// false
$checked = $sms->check('12345678910', '13125');
dump($checked);
// true
$checked = $sms->check('12345678910', '13125', true);
dump($checked);
// true
$checked = $sms->check('12345678910', '13125');
dump($checked);
// false
```

#### time($phone)

获取验证时间

- **phone** `string` 手机号
- **Return** `bool|array`

```php
$sms = Sms::create();
$sms->factory('12345678910', '13125', 3600);

$data = $sms->time('12345678910');
dump($data);
// array (size=2)
//   'publish_time' => int 1548644216
//   'timeout' => int 3600
```

- **publish_time** `int` 指发布时间
- **timeout** `int` 指有效时间