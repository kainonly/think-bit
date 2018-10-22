# JSON Web Token 跨域认证

#### 配置

在config文件中创建 `jwt.php`

```php
<?php
$private = <<<EOD
-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQClGBhwq9wJo3n3oe5eBIsF9UeCmGN9iJ9fyzlnTbZ3xeLiqrSn
f+yVWAeKWjwMozJuQsfNzKlfqs2nV99StbIuLZQ6gPW+xm+Lp9d6p++qQ3swvsDp
xh9mMTZxAe0oljpAD83/puINOCYClo9o3CmSEUf+1gLWHOqg/B12FgDOkQIDAQAB
AoGBAIO5P/bWCNBf8PbV6tx0/3+XfqECeY81rQO/oGN+K/JQn4B+93kVpmxaOln3
OSZUJ+61tbnMa+961m+IuxTBCBJra9m3Q4+qpvPdkhAsTHzvhmX5ZzX9xQeV5YCb
EfACnra0JPq0p3bxIe4PiaxHIkAlzETfxt3IiES5T3wXr2xpAkEA2yrrItyD20X4
599D6tIE3pur67dkU4TfVpsW4vUXG1jtBs9QQacnXjqCAupFVbJIOEo+XQ/NXJ7j
BuETRPR/GwJBAMDW0Cj+JGWhzRXaAhZ64orMjhkSAPQVAKqBZGY4LZQ6GQue3GOu
osu6Szworee+DjUCmGo+ZF+krCizAPRCx8MCQQCNkpW9OTC7jeGQ9nnKz8txeKF/
bEGUabpTGW+ZP7SjZ7gEtBolrrIRfj3JYEdVagqYweyy9Kg1cjU4ll96JW2NAkB5
EGNu2N6Qz5updEyLQGqpKPKs2piuo+DfKoyVf/9dZ3wBx6IlEqYxsKs7AW7sZm0U
6qQ1TyZExWUvx/F5Z9NxAkA5eVifhrypYJTv6+ygp60BdGjwXWdh/+zrOOpmIyU3
saelWgwbVco+rj+LYtHIfjNQwgxLHY2WfmkajgkY+AfX
-----END RSA PRIVATE KEY-----
EOD;
$public = <<<EOD
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQClGBhwq9wJo3n3oe5eBIsF9UeC
mGN9iJ9fyzlnTbZ3xeLiqrSnf+yVWAeKWjwMozJuQsfNzKlfqs2nV99StbIuLZQ6
gPW+xm+Lp9d6p++qQ3swvsDpxh9mMTZxAe0oljpAD83/puINOCYClo9o3CmSEUf+
1gLWHOqg/B12FgDOkQIDAQAB
-----END PUBLIC KEY-----
EOD;
return [
    'sign' => 'PvZ4zuQkX6zqi@82',
    'private' => $private,
    'public' => $public
];
```

- `sign` 同源加密算法密钥
- `private` RSA加密算法私钥
- `public` RSA加密算法公钥

> 同时设置三种密钥，sign用于校验csrf，RSA则用于不可控的客户端

在config中 `middleware.php` 加入

```php
<?php
return [
    'jwt' => \bit\middleware\JwtVerify::class,
];
```

> 在控制器中使用中间件请参考，https://www.kancloud.cn/manual/thinkphp5_1/564279