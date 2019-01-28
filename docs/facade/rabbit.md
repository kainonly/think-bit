## Rabbit 消息队列

RabbitMQ 消息队列 AMQP 操作类，使用前请确实是否已安装 `php-amqplib/php-amqplib`，如未安装请手动执行

```shell
composer require php-amqplib/php-amqplib
```

!> 当前 window 系统下需要使用 `"php-amqplib/php-amqplib": "^2.8.2-rc3"` 才可正常运行

#### 连接参数 :id=args

默认下 rabbitmq 连接参数为：

| 配置名称            | 默认值    | 说明             |
| ------------------- | --------- | ---------------- |
| hostname            | localhost | AMQP连接地址     |
| port                | 5672      | AMQP连接端口     |
| username            | guest     | 连接用户         |
| password            | guest     | 连接用户口令     |
| virualhost          | /         | 虚拟主机         |
| insist              | false     | 不允许代理重定向 |
| login_method        | AMQPLAIN  | 登录方法         |
| login_response      | null      | 登录响应         |
| locale              | en_US     | 国际化           |
| connection_timeout  | 3.0       | 连接超时         |
| read_write_timeout  | 3.0       | 读写超时         |
| context             | null      | 内容             |
| keepalive           | false     | 保持连接         |
| heartbeat           | 0         | 连接心跳         |
| channel_rpc_timeout | 0.0       | 信道RPC超时      |

你需要在主配置或对应的模块下创建配置 `config/rabbitmq.php`，例如：

```php
return [
    'hostname' => 'localhost',
    'port' => 5672,
    'username' => 'guest',
    'password' => 'guest',
];
```

也可以配合 Env 实现开发、生产分离配置：

```php
return [
    'hostname' => env('rabbitmq.hostname', 'localhost'),
    'port' => env('rabbitmq.port', 5672),
    'username' => env('rabbitmq.username', 'guest'),
    'password' => env('rabbitmq.password', 'guest'),
];
```

#### start($closure, $args = [], $config = [])

创建默认信道

- **closure** `Closure` 信道处理
- **args** `array` [连接参数](facade/rabbit#args)
- **config** `array` 操作配置

| 操作配置名称 | 类型    | 默认值 | 说明       |
| ------------ | ------- | ------ | ---------- |
| transaction  | boolean | false  | 开启事务   |
| channel_id   | string  | null   | 定义信道ID |
| reply_code   | int     | 0      | 回复码     |
| reply_text   | string  | ''     | 回复文本   |
| method_sig   | array   | [0,0]  | -          |

```php
Rabbit::start(function () {
    Rabbit::queue('hello')->create();
});
```

#### connect($closure, $args = [], $config = [])

创建自定义信道

- **closure** `Closure` 信道处理
- **args** `array` 连接参数
- **config** `array` 操作配置

| 操作配置名称 | 类型    | 默认值 | 说明       |
| ------------ | ------- | ------ | ---------- |
| transaction  | boolean | false  | 开启事务   |
| channel_id   | string  | null   | 定义信道ID |
| reply_code   | int     | 0      | 回复码     |
| reply_text   | string  | ''     | 回复文本   |
| method_sig   | array   | [0,0]  | -          |

```php
Rabbit::connect(function () {
    Rabbit::queue('hello')->create();
}, [
    'hostname' => 'developer.com',
    'port' => 5672,
    'username' => 'kain',
    'password' => '******'
]);
```

#### native()

获取连接对象

- **Return** `AMQPStreamConnection`

```php
Rabbit::start(function () {
    dump(Rabbit::native());
    dump(Rabbit::native()->getChannelId());
});
```

#### channel()

获取信道

- **Return** `AMQPChannel`

```php
Rabbit::start(function () {
    dump(Rabbit::native());
    dump(Rabbit::native()->getChannelId());
});
```

#### message($text = '', $config = [])

创建消息对象

- **text** `string|array` 消息
- **config** `array` 操作配置
- **Return** `AMQPMessage`

```php
Rabbit::start(function () {
    Rabbit::message('test');
});
```

#### publish($text = '', $config = [])

发布消息

- **text** `string|array` 消息
- **config** `array` 操作配置

```php
 Rabbit::start(function () {
    Rabbit::exchange('extest')->create('direct');
    Rabbit::queue('hello')->create();
    Rabbit::queue('hello')->bind('extest', [
        'routing_key' => 'rtest'
    ]);
    Rabbit::publish('test', [
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
Rabbit::start(function () {
    $exchange = Rabbit::exchange('extest');
});
```

##### -> create($type, $config = [])

声明交换器

- **type** `string` 交换器类型 **(direct、headers、fanout、topic)**
- **config** `array` 操作配置

| 操作配置名称 | 类型    | 默认值 | 说明             |
| ------------ | ------- | ------ | ---------------- |
| passive      | boolean | false  | 检验队列是否存在 |
| durable      | boolean | false  | 是否持久化       |
| auto_delete  | boolean | true   | 自动删除         |
| internal     | boolean | false  | 仅交换绑定有效   |
| nowait       | boolean | false  | 客户端不等待回复 |
| arguments    | array   | []     | 扩展参数         |
| ticket       | string  | null   | -                |

```php
Rabbit::start(function () {
    Rabbit::exchange('extest')->create('direct');
});
```

##### -> bind($destination, $config = [])

起源交换器绑定交换器

- **destination** `string` 绑定交换器
- **config** `array` 操作配置

| 操作配置名称 | 类型    | 默认值 | 说明             |
| ------------ | ------- | ------ | ---------------- |
| routing_key  | string  | ''     | 路由键           |
| nowait       | boolean | false  | 客户端不等待回复 |
| arguments    | array   | []     | 扩展参数         |
| ticket       | string  | null   | -                |

```php
Rabbit::start(function () {
    Rabbit::exchange('extest')->create('direct');
    Rabbit::exchange('newtest')->create('direct');
    Rabbit::exchange('newtest')->bind('extest');
});
```

##### -> unbind($destination, $config = [])

起源交换器解除绑定的交换器

- **destination** `string` 绑定交换器
- **config** `array` 操作配置

| 操作配置名称 | 类型    | 默认值 | 说明             |
| ------------ | ------- | ------ | ---------------- |
| routing_key  | string  | ''     | 路由键           |
| nowait       | boolean | false  | 客户端不等待回复 |
| arguments    | array   | []     | 扩展参数         |
| ticket       | string  | null   | -                |

```php
Rabbit::start(function () {
    Rabbit::exchange('extest')->create('direct');
    Rabbit::exchange('newtest')->create('direct');
    Rabbit::exchange('newtest')->bind('extest');
    Rabbit::exchange('newtest')->unbind('extest');
});
```

##### -> delete($config = [])

删除交换器

- **config** `array` 操作配置

| 操作配置名称 | 类型    | 默认值 | 说明                       |
| ------------ | ------- | ------ | -------------------------- |
| if_unused    | boolean | false  | 仅删除没有队列绑定的交换器 |
| nowait       | boolean | false  | 客户端不等待回复           |
| ticket       | string  | null   | -                          |

```php
Rabbit::start(function () {
    Rabbit::exchange('extest')->delete();
});
```

#### queue($queue)

队列操作类

- **queue** `string` 队列名称

```php
Rabbit::start(function () {
    $queue = Rabbit::queue('hello');
    $queue->create();
});
```

##### -> create($config = [])

声明队列

- **config** `array` 操作配置

```php
Rabbit::start(function () {
    Rabbit::queue('hello')->create();
});
```

##### -> bind($exchange, $config = [])

绑定队列

- **exchange** `string`
- **config** `array` 操作配置

```php
Rabbit::start(function () {
    Rabbit::exchange('extest')->create('direct');
    $queue = Rabbit::queue('hello');
    $queue->create();
    $queue->bind('extest');
});
```

##### -> unbind($exchange, $config = [])

解除绑定

- **exchange** `string`
- **config** `array` 操作配置

```php
Rabbit::start(function () {
    Rabbit::exchange('extest')->create('direct');
    $queue = Rabbit::queue('hello');
    $queue->create();
    $queue->bind('extest');
    $queue->unbind('extest');
});
```

##### -> purge($config = [])

清除队列

- **config** `array` 操作配置

```php
Rabbit::start(function () {
    Rabbit::exchange('extest')->create('fanout');
    $queue = Rabbit::queue('hello');
    $queue->create();
    $queue->bind('extest');
    Rabbit::publish('message', [
        'exchange' => 'extest',
    ]);
    $queue->purge();
});
```

##### -> delete($config = [])

删除队列

- **config** `array` 操作配置

```php
Rabbit::start(function () {
    $queue = Rabbit::queue('hello');
    $queue->create();
    $queue->delete();
});
```

##### -> get($config = [])

获取队列信息

- **config** `array` 操作配置

```php
Rabbit::start(function () {
    Rabbit::exchange('extest')->create('fanout');
    $queue = Rabbit::queue('hello');
    $queue->create();
    $queue->bind('extest');
    Rabbit::publish('message', [
        'exchange' => 'extest',
    ]);
    dump($queue->get()->body);
});

// message
```

#### consumer($consumer)

消费者操作类

- **consumer** `string` 消费者名称

##### - start($queue, array $config = [])

启用消费者

- **queue** `string`
- **config** `array`

##### - cancel(array $config = [])

结束消费者

- **config** `array`

#### ack($delivery_tag, $multiple = false)

确认消息

- **delivery_tag** `string`
- **multiple** `boolean`

#### reject($delivery_tag, $requeue = false)

拒绝传入的消息

- **delivery_tag** `string`
- **requeue** `boolean`

#### nack($delivery_tag, $multiple = false, $requeue = false)

拒绝一个或多个收到的消息

- **delivery_tag** `string`
- **multiple** `boolean`
- **requeue** `boolean`

#### revover($requeue = false)

重新发送未确认的消息

- **requeue** `boolean`