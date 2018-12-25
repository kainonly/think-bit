# Cipher

在ThinkPHP项目中下创建 `config/cipher.php`，设置配置

```php
return [
    'key' => env('cipher.key'),
    'iv' => env('cipher.iv')
];
```

- `key` 加密密钥
- `iv` 偏移量

#### encrypt(string $context)

加密明文

- `context` 明文
- 返回密文

#### decrypt(string $secret)

解密密文

- `secret` 密文
- 返回明文

例子.加密明文、解密密文

```php
use think\bit\facade\Cipher;

$secret = Cipher::encrypt('123');
dump($secret);
dump(Cipher::decrypt($secret));
```

#### encryptArray(Array $data)

加密数组为密文

- `data` 数组
- 返回密文

#### decryptArray(string $secret)

解密密文为数组

- `secret` 密文
- 返回数组

例子.加密数组为密文、解密密文为数组

```php
use think\bit\facade\Cipher;

$secret = Cipher::encryptArray([1,2,3]);
dump($secret);
dump(Cipher::decryptArray($secret));
```

