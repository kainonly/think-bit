## Hash 密码

Hash 是用于密码加密与验证的工具函数，需要配置 `app.app_hash`，默认使用 `argon2i` 也可以选择 `argon2id`

#### make($password, $options = [])

加密密码

- **password** `string` 密码
- **options** `array` 加密参数 `['memory' => 1024,'time' => 2,'threads' => 2]`

```php
Hash::make('123456789');
```

#### check($password, $hashPassword)

验证密码

- **password** `string` 密码
- **hashPassword** `string` 密码散列值

```php
$hash = Hash::make('123456789');
dump(Hash::check('12345678', $hash));
// false
dump(Hash::check('123456789', $hash));
// true
```