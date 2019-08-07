## Cipher 对称加密

Cipher 是将数据对称加密的工具，需要添加配置 `app_secret` 与 `app_id` 到 `config/app.php`

```php
return [
    
    'app_id' => env('app.id', null),
    'app_secret' => env('app.secret', null),

];
```

- **app_id** `string` 应用ID
- **app_secret** `string` 应用密钥

#### encrypt($context, $key, $iv)

加密明文

- **context** `string` 明文
- **key** `string` 自定义密钥
- **iv** `string` 自定义偏移量
- **Return** `string` 密文

```php
dump(Cipher::encrypt('123'));

// s7Tkeof7utaDU4tVsTSbyA==
```

#### decrypt($secret, $key, $iv)

解密密文

- **secret** `string` 密文
- **key** `string` 自定义密钥
- **iv** `string` 自定义偏移量
- **Return** `string` 明文

```php
$secret = Cipher::encrypt('123');

dump($secret);
// s7Tkeof7utaDU4tVsTSbyA==
dump(Cipher::decrypt($secret));
// 123
```

#### encryptArray($data, $key, $iv)

加密数组为密文

- **data** `array` 数组
- **key** `string` 自定义密钥
- **iv** `string` 自定义偏移量
- **Return** `string` 密文

```php
dump(Cipher::encryptArray([1, 2, 3]));

// eFIs2OR2/IXC3vv3febOVA==
```

#### decryptArray($secret, $key, $iv)

解密密文为数组

- **secret** `string` 密文
- **key** `string` 自定义密钥
- **iv** `string` 自定义偏移量
- **Return** `array`

```php
$secret = Cipher::encryptArray([1, 2, 3]);

dump($secret);
// eFIs2OR2/IXC3vv3febOVA==
dump(Cipher::decryptArray($secret));
// array (size=3)
//   0 => int 1
//   1 => int 2
//   2 => int 3
```

