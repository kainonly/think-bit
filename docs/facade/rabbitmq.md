# RabbitMQ

#### 配置

在config文件中创建 `rabbitmq.php`

```php
<?php
return [
    'host' => '127.0.0.1',
    'port' => 5672,
    'user' => 'any',
    'password' => '123',
    'vhost' => '/'
];
```

- `host` 连接地址
- `port` 端口
- `user` 用户名
- `password` 用户密码
- `vhost` 虚拟域名

##### `Rabbit::channel(Closure $closure)`

- `closure` 闭包函数 `function (AMQPChannel $channel)`

```php

```