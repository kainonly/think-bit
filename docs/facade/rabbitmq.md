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

#### 定义渠道

##### `Rabbit::channel(Closure $closure)`

- `closure` 闭包函数 `function (AMQPChannel $channel)`

例如，发布一个消息队列

```php
use think\bit\facade\Rabbit;
Rabbit::channel(function (AMQPChannel $channel) {
    $channel->queue_declare('hello', false, false, false, false);
    $channel->basic_publish(new AMQPMessage('abc'), '', 'hello');
});
```

> Rabbit 是对官方php-amqplib的门面定义，操作可参考 http://www.rabbitmq.com/tutorials/tutorial-one-php.html