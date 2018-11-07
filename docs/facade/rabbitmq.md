# RabbitMQ

在ThinkPHP项目中下创建 `config/rabbitmq.php`，设置配置

```php
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

#### channel(Closure $closure)

定义渠道，自动断开连接

- `closure` 函数定义为 `function (AMQPChannel $channel)`
- 返回 `<AMQPChannel>`

例子.发布一个消息队列

```php
use think\bit\facade\Rabbit;

Rabbit::channel(function (AMQPChannel $channel) {
    $channel->queue_declare('hello', false, false, false, false);
    $channel->basic_publish(new AMQPMessage('abc'), '', 'hello');
});
```

> `Rabbit` 是对官方 php-amqplib 的门面定义，操作可参考 http://www.rabbitmq.com/tutorials