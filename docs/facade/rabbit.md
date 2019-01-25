## Rabbit 消息队列

RabbitMQ 消息队列 AMQP 操作类，使用前请确实是否已安装 `php-amqplib/php-amqplib`，如未安装请手动执行

```shell
composer require php-amqplib/php-amqplib
```

!> 当前 window 系统下需要使用 `"php-amqplib/php-amqplib": "^2.8.2-rc3"` 才可正常运行

#### 开发配置

默认下 rabbitmq 配置参数为：

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

#### start(Closure $closure, array $args = [], array $config = [])

创建默认信道

- `closure` Closure，信道处理
- `args` array，连接参数
- `config` array，配置参数

#### connect(Closure $closure, array $args = [], array $config = [])

创建自定义信道

- `closure` Closure，信道处理
- `args` array，连接参数
- `config` array，配置参数

#### native()

获取连接对象

#### channel()

获取信道

#### message($text = '', array $config = [])

创建消息对象

#### publish($text = '', array $config = [])

发布消息

#### ack($delivery_tag, $multiple = false)

确认消息

#### reject($delivery_tag, $requeue = false)

拒绝传入的消息

#### nack($delivery_tag, $multiple = false, $requeue = false)

拒绝一个或多个收到的消息

#### revover($requeue = false)

重新发送未确认的消息

#### exchange($exchange)

交换器操作类

#### queue($queue)

队列操作类

#### consumer($consumer)

消费者操作类