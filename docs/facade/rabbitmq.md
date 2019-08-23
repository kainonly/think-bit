## RabbitMQ 消息队列

RabbitMQ 消息队列 AMQP 操作类使用 [kain/tidy-amqp](https://github.com/kainonly/tidy-amqp) 做为依赖，首先使用 `composer` 安装操作服务

```shell
composer require kain/think-amqp
```

然后需要更新配置 `config/queue.php`，例如：

```php
return [

    'rabbitmq' => [
        'hostname' => env('rabbitmq.host', 'localhost'),
        'port' => env('rabbitmq.port', 5672),
        'virualhost' => env('rabbitmq.virualhost', '/'),
        'username' => env('rabbitmq.username', 'guest'),
        'password' => env('rabbitmq.password', 'guest'),
    ]

];
```

### channel($closure, $args = [], $config = [])

创建默认信道

- **closure** `Closure` 信道处理
- **args** `array` 连接参数
  - **hostname** `localhost` AMQP连接地址
  - **port** `5672` AMQP连接端口
  - **username** `guest` 连接用户
  - **password** `guest` 连接用户口令
  - **virualhost** `/` 虚拟主机
  - **insist** `false` 不允许代理重定向
  - **login_method** `AMQPLAIN` 登录方法
  - **login_response** `null` 登录响应
  - **locale** `en_US` 国际化
  - **connection_timeout** `3.0` 连接超时
  - **read_write_timeout** `3.0` 读写超时
  - **context** `null` 内容
  - **keepalive** `false` 保持连接
  - **heartbeat** `0` 连接心跳
  - **channel_rpc_timeout** `0.0` 信道RPC超时
- **config** `array` 操作配置
  - **transaction** `boolean` 开启事务，默认 `false`
  - **channel_id** `string` 定义信道ID，默认 `null`
  - **reply_code** `int` 回复码，默认 `0`
  - **reply_text** `string` 回复文本，默认 `''`
  - **method_sig** `array` 默认 `[0,0]`

```php
AMQP::channel(function (RabbitClient $client) {
    $client->queue('hello')->create();
});
```

#### getChannel()

获取信道

- **Return** `AMQPChannel`

```php
AMQP::channel(function (RabbitClient $client) {
    $client->getChannel();
});
```

#### message($text = '', $config = [])

创建消息对象

- **text** `string|array` 消息
- **config** `array` 操作配置
- **Return** `AMQPMessage`

```php
AMQP::channel(function (RabbitClient $client) {
    $client->message('test');
});
```

#### publish($text = '', $config = [])

发布消息

- **text** `string|array` 消息
- **config** `array` 操作配置

```php
AMQP::channel(function (RabbitClient $client) {
    $client->exchange('extest')->create('direct');
    $client->queue('hello')->create();
    $client->queue('hello')->bind('extest', [
        'routing_key' => 'rtest'
    ]);
    $client->publish('test', [
        'exchange' => 'extest',
        'routing_key' => 'rtest'
    ]);
});
```

#### exchange($exchange)

交换器操作类

- **exchange** `string` 交换器名称
- **Return** `Exchange` 交换器类

```php
AMQP::channel(function (RabbitClient $client) {
    $exchange = $client->exchange('extest');
});
```

##### -> create($type, $config = [])

声明交换器

- **type** `string` 交换器类型 **(direct、headers、fanout、topic)**
- **config** `array` 操作配置
  - **passive** `boolean` 检验队列是否存在，默认 `false`
  - **durable** `boolean` 是否持久化，默认 `false`
  - **auto_delete** `boolean` 自动删除，默认 `true`
  - **internal** `boolean` 仅交换绑定有效，默认 `false`
  - **nowait** `boolean` 客户端不等待回复，默认 `false`
  - **arguments** `array` 扩展参数，默认 `[]`
  - **ticket** `string` 默认 `null`
- **Return** `mixed|null`

```php
AMQP::channel(function (RabbitClient $client) {
    $client->exchange('extest')->create('direct');
});
```

##### -> bind($destination, $config = [])

起源交换器绑定交换器

- **destination** `string` 绑定交换器
- **config** `array` 操作配置
  - **routing_key** `string` 路由键，默认 `''`
  - **nowait** `boolean` 客户端不等待回复，默认 `false`
  - **arguments** `array` 扩展参数，默认 `[]`
  - **ticket** `string` 默认 `null`
- **Return** `mixed|null`

```php
AMQP::channel(function (RabbitClient $client) {
    $client->exchange('extest')->create('direct');
    $client->exchange('newtest')->create('direct');
    $client->exchange('newtest')->bind('extest');
});
```

##### -> unbind($destination, $config = [])

起源交换器解除绑定的交换器

- **destination** `string` 绑定交换器
- **config** `array` 操作配置
  - **routing_key** `string` 路由键，默认 `''`
  - **nowait** `boolean` 客户端不等待回复，默认 `false`
  - **arguments** `array` 扩展参数，默认 `[]`
  - **ticket** `string` 默认 `null`
- **Return** `mixed`

```php
AMQP::channel(function (RabbitClient $client) {
    $client->exchange('extest')->create('direct');
    $client->exchange('newtest')->create('direct');
    $client->exchange('newtest')->bind('extest');
    $client->exchange('newtest')->unbind('extest');
});
```

##### -> delete($config = [])

删除交换器

- **config** `array` 操作配置
  - **if_unused** `boolean` 仅删除没有队列绑定的交换器，默认 `false`
  - **nowait** `boolean` 客户端不等待回复，默认 `false`
  - **ticket** `string` 默认 `null`
- **Return** `mixed|null`

```php
AMQP::channel(function (RabbitClient $client) {
    $client->exchange('extest')->delete();
});
```

#### queue($queue)

队列操作类

- **queue** `string` 队列名称
- **Return** `Queue`

```php
AMQP::channel(function (RabbitClient $client) {
    $client->queue('hello')->create();
});
```

##### -> create($config = [])

声明队列

- **config** `array` 操作配置
  - **passive** `boolean` 检验队列是否存在，默认 `false`
  - **durable** `boolean` 是否持久化，默认 `false`
  - **exclusive** `boolean` 排除队列，默认 `false`
  - **auto_delete** `boolean` 自动删除，默认 `true`
  - **nowait** `boolean` 客户端不等待回复，默认 `false`
  - **arguments** `array` 扩展参数，默认 `[]`
  - **ticket** `string` 默认 `null`
- **Return** `mixed|null`

```php
AMQP::channel(function (RabbitClient $client) {
    $client->queue('hello')->create();
});
```

##### -> bind($exchange, $config = [])

绑定队列

- **exchange** `string` 交换器名称
- **config** `array` 操作配置
  - **routing_key** `string` 路由键，默认 `''`
  - **nowait** `boolean` 客户端不等待回复，默认 `false`
  - **arguments** `array` 扩展参数，默认 `[]`
  - **ticket** `string` 默认 `null`
- **Return** `mixed|null`

```php
AMQP::channel(function (RabbitClient $client) {
    $client->exchange('extest')->create('direct');
    $queue = $client->queue('hello');
    $queue->create();
    $queue->bind('extest');
});
```

##### -> unbind($exchange, $config = [])

解除绑定

- **exchange** `string`
- **config** `array` 操作配置
  - **routing_key** `string` 路由键
  - **arguments** `array` 扩展参数，默认 `[]`
  - **ticket** `string` 默认 `null`
- **Return** `mixed`

```php
AMQP::channel(function (RabbitClient $client) {
    $client->exchange('extest')->create('direct');
    $queue = $client->queue('hello');
    $queue->create();
    $queue->bind('extest');
    $queue->unbind('extest');
});
```

##### -> purge($config = [])

清除队列

- **config** `array` 操作配置
  - **arguments** `array` 扩展参数，默认 `[]`
  - **ticket** `string` 默认 `null`
- **Return** `mixed|null`

```php
AMQP::channel(function (RabbitClient $client) {
    $client->exchange('extest')->create('fanout');
    $queue = $client->queue('hello');
    $queue->create();
    $queue->bind('extest');
    $client->publish('message', [
        'exchange' => 'extest',
    ]);
    $queue->purge();
});
```

##### -> delete($config = [])

删除队列

- **config** `array` 操作配置
  - **if_unused** `boolean` 仅删除没有队列绑定的交换器，默认 `false`
  - **if_empty** `boolean` 完全清空队列，默认 `false`
  - **arguments** `array` 扩展参数，默认 `[]`
  - **ticket** `string` 默认 `null`
- **Return** `mixed|null`

!> `if_empty` 删除队列时，如果在服务器配置中定义了任何挂起的消息，则会将任何挂起的消息发送到死信队列，并且队列中的所有使用者都将被取消

```php
AMQP::channel(function (RabbitClient $client) {
    $queue = $client->queue('hello');
    $queue->create();
    $queue->delete();
});
```

##### -> get($config = [])

获取队列信息

- **config** `array` 操作配置
  - **no_ack** `boolean` 手动确认消息，默认 `false`
  - **ticket** `string` 默认 `null`
- **Return** `mixed`

```php
AMQP::channel(function (RabbitClient $client) {
    $client->exchange('extest')->create('fanout');
    $queue = $client->queue('hello');
    $queue->create();
    $queue->bind('extest');
    $client->publish('message', [
        'exchange' => 'extest',
    ]);
    dump($queue->get()->body);
});

// message
```

#### consumer($consumer)

消费者操作类

- **consumer** `string` 消费者名称
- **Return** `Consumer`

##### -> start($queue, $config = [])

启用消费者

- **queue** `string` 队列名称
- **config** `array` 操作配置
  - **no_local** `boolean` 独占消费，默认 `false`
  - **no_ack** `boolean` 手动确认消息，默认 `false`
  - **exclusive** `boolean` 排除队列，默认 `false`
  - **nowait**  `boolean` 客户端不等待回复，默认 `false`
  - **callback** `Closure` 回调函数，默认 `null`
  - **arguments** `array` 扩展参数，默认 `[]`
  - **ticket** `string` 默认 `null`
- **Return** `mixed|string`

!> `no_local` 请求独占消费者访问权限，这意味着只有此消费者才能访问队列

##### -> cancel($config = [])

结束消费者

- **config** `array` 操作配置
  - **nowait** `boolean` 客户端不等待回复，默认 `false`
  - **noreturn** `boolean` 默认 `false`
- **Return** `mixed`

#### ack($delivery_tag, $multiple = false)

确认消息

- **delivery_tag** `string` 标识
- **multiple** `boolean` 批量

#### reject($delivery_tag, $requeue = false)

拒绝传入的消息

- **delivery_tag** `string` 标识
- **requeue** `boolean` 重新发送

#### nack($delivery_tag, $multiple = false, $requeue = false)

拒绝一个或多个收到的消息

- **delivery_tag** `string` 标识
- **multiple** `boolean` 批量
- **requeue** `boolean` 重新发送

#### revover($requeue = false)

重新发送未确认的消息

- **requeue** `boolean` 重新发送
- **Return** `mixed`