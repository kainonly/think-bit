# Cipher

Cipher 是对称加密门面，首先要创建 `config/cipher.php`，设置配置

```php
return [
    'key' => env('cipher.key'),
    'iv' => env('cipher.iv')
];
```

- `key` 加密密钥
- `iv` 偏移量

> 需要安装依赖 `composer require phpseclib/phpseclib`

#### encrypt(string $context, $key = null, $iv = null)

加密明文

- `context` 明文
- `key` 自定义密钥
- `iv` 自定义偏移量
- 返回密文

#### decrypt(string $secret, $key = null, $iv = null)

解密密文

- `secret` 密文
- `key` 自定义密钥
- `iv` 自定义偏移量
- 返回明文

例子.加密明文、解密密文

```php
use think\bit\facade\Cipher;

$secret = Cipher::encrypt('123');
dump($secret);
dump(Cipher::decrypt($secret));
```

#### encryptArray(Array $data, $key = null, $iv = null)

加密数组为密文（需要msgpack支持）

- `data` 数组
- `key` 自定义密钥
- `iv` 自定义偏移量
- 返回密文

#### decryptArray(string $secret, $key = null, $iv = null)

解密密文为数组（需要msgpack支持）

- `secret` 密文
- `key` 自定义密钥
- `iv` 自定义偏移量
- 返回数组

例子.加密数组为密文、解密密文为数组

```php
use think\bit\facade\Cipher;

$secret = Cipher::encryptArray([1,2,3]);
dump($secret);
dump(Cipher::decryptArray($secret));
```

