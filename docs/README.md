Think-Bit
=======

基于 ThinkPHP5 设计的 RESTFul API 辅助框架

![Packagist Version](https://img.shields.io/packagist/v/kain/think-bit.svg?style=flat-square)
![Packagist](https://img.shields.io/packagist/dt/kain/think-bit.svg?color=blue&style=flat-square)
![PHP from Packagist](https://img.shields.io/packagist/php-v/kain/think-bit.svg?color=blue&style=flat-square)
![Packagist](https://img.shields.io/packagist/l/kain/think-bit.svg?color=blue&style=flat-square)

#### 安装

```shell
composer require kain/think-bit
```

#### 配置参数

首先需要将 `config/app.php` 配置文件更新与新增相关定义

```php
return [
    // 应用名称
    'app_name' => env('app.name', null),
    // 应用ID
    'app_id' => env('app.id', null),
    // 应用密钥
    'app_secret' => env('app.secret', null),
    // 应用地址
    'app_host' => env('app.host', 'http://localhost:8000'),
    // 管理后台域名
    'app_backstage' => env('app.backstage', 'http://localhost:4200'),
    // 密码模式
    'app_hash' => env('app.hash', 'argon2i'),
    // 应用调试模式
    'app_debug' => env('app.debug', true),
    // 应用Trace
    'app_trace' => env('app.trace', true),
    // 默认输出类型
    'default_return_type' => 'json',
];
```

在 `application/tags.php` 中增加扩展验证

```php
return [
    // 应用初始化
    'app_init' => [
        \think\bit\common\BitValidate::class
    ],
];
```

使用 `composer` 安装与更新可附带优化参数提高性能

```shell
composer install --optimize-autoloader --no-dev --ignore-platform-reqs --no-scripts

composer update --optimize-autoloader --no-dev --ignore-platform-reqs --no-scripts
```
