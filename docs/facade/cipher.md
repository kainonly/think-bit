## Cipher 数据加密

Cipher 可以将字符串或数组进行加密解密的工具，需要添加配置 `app_secret` 与 `app_id` 到 `config/app.php`

```php
return [

    'app_id' => env('app.id', null),
    'app_secret' => env('app.secret', null),

];
```

- **app_id** `string` 应用ID
- **app_secret** `string` 应用密钥

#### encrypt($context)

加密数据

- **context** `string|array` 数据
- **Return** `string` 密文

```php
Cipher::encrypt('123');

// FLgXf5EXF6eGEqphO3WVJQ==

Cipher::encrypt([
    'name' => 'kain'
]);

// IyGcnXqDT6ersFhAKdduUQ==
```

#### decrypt(string $ciphertext, bool $auto_conver = true)

解密数据

- **ciphertext** `string` 密文
- **auto_conver** `bool` 数据属于数组时是否自动转换
- **Return** `string|array` 明文

```php
$result = Cipher::encrypt([
    'name' => 'kain'
]);

Cipher::decrypt($result);

// array:1 [▼
//   "name" => "kain"
// ]
```