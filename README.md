# Think Bit

辅助 ThinkPHP 快速集成 CURD API 的工具集

![Packagist Version](https://img.shields.io/packagist/v/kain/think-bit.svg?style=flat-square)
![Packagist](https://img.shields.io/packagist/dt/kain/think-bit.svg?color=blue&style=flat-square)
![PHP from Packagist](https://img.shields.io/packagist/php-v/kain/think-bit.svg?color=blue&style=flat-square)
![Packagist](https://img.shields.io/packagist/l/kain/think-bit.svg?color=blue&style=flat-square)

#### 安装

```shell
composer require kain/think-bit
```

#### 扩展配置

首先需要将 `config/app.php` 配置文件更新与新增相关定义

```php
return [

    // 应用名称
    'app_name' => Env::get('app.name', null),
    // 应用标识
    'app_id' => Env::get('app.id', null),
    // 应用密钥
    'app_secret' => Env::get('app.secret', null),
    // 应用地址
    'app_host' => Env::get('app.host', 'http://localhost:8000'),
    // 管理后台域名
    'app_backstage' => Env::get('app.backstage', 'http://localhost:4200'),
];
```

#### 相关扩展

从 `kain/think-bit` 版本 `>= 6.0.6` 组件开始独立组件，并逐步遵循 `PSR` 规范与 `PHP` 严格模式

- [kain/think-extra](https://packagist.org/packages/kain/think-extra) ThinkPHP 工具扩展库
- [kain/think-support](https://packagist.org/packages/kain/think-support) ThinkPHP 依赖与功能支持库
- [kain/think-redis](https://packagist.org/packages/kain/think-redis) ThinkPHP Redis 扩展
- [kain/think-amqp](https://packagist.org/packages/kain/think-amqp) ThinkPHP RabbitMQ 消息队列 AMQP 操作类
- [kain/think-elastic](https://packagist.org/packages/kain/think-elastic) ThinkPHP ElasticSearch 扩展
- [kain/think-aliyun-extra](https://packagist.org/packages/kain/think-aliyun-extra) ThinkPHP 阿里云相关扩展


#### 依赖安装

在容器项目中可以使用 `docker-compose` 编排

```yml
version: '3.7'
services:
  dev:
    image: composer
    command: 'composer update --prefer-dist -o --ignore-platform-reqs'
    volumes:
      - /composer:/tmp
      - ./:/app
  update:
    image: composer
    command: 'composer update --prefer-dist -o --no-dev --ignore-platform-reqs'
    volumes:
      - /composer:/tmp
      - ./:/app
```

然后执行 `composer` 更新

```shell
docker-compose run --rm --no-deps update
```

#### 推荐库

- [topthink/think-helper](https://www.kancloud.cn/manual/thinkphp6_0/1149630) Think 助手工具库
- [composer require guzzlehttp/guzzle](http://docs.guzzlephp.org/en/stable/) GuzzleHttp 请求库
- [nesbot/carbon](https://carbon.nesbot.com/docs/) Carbon 时间处理库
- [overtrue/wechat](https://www.easywechat.com/docs) EasyWechat 微信第三方库
- [overtrue/easy-sms](https://github.com/overtrue/easy-sms) EasySMS 短信库
- [overtrue/pinyin](https://github.com/overtrue/pinyin) Pinyin 拼音库
- [casbin/casbin](https://github.com/php-casbin/php-casbin/blob/master/README_CN.md) PHP-Casbin 授权库
- [swiftmailer/swiftmailer](https://swiftmailer.symfony.com/docs/introduction.html) swiftmailer 邮件库