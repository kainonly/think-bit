## AMQP 消息队列

AMQP 消息队列操作类使用 [kain/simplify-amqp](https://github.com/kainonly/simplify-amqp) 做为依赖，首先使用 `composer` 安装操作服务

```shell
composer require kain/think-amqp
```

安装后服务将自动注册，然后需要更新配置 `config/queue.php`，例如：

```php
return [

    'rabbitmq' => [
        'default' => [
            // 服务器地址
            'hostname' => Env::get('rabbitmq.host', 'localhost'),
            // 端口号
            'port' => Env::get('rabbitmq.port', 5672),
            // 虚拟域
            'virualhost' => Env::get('rabbitmq.virualhost', '/'),
            // 用户名
            'username' => Env::get('rabbitmq.username', 'guest'),
            // 密码
            'password' => Env::get('rabbitmq.password', 'guest'),
        ]
    ]

];
```

### client(string $name = 'default')

- **name** `string` 配置标识
- **Return** `simplify\amqp\AMQPClient`

AMQP 客户端

### channel(Closure $closure, string $name = 'default', array $options = [])

创建默认信道

- **closure** `Closure` 信道处理
- **name** `string` 配置标识
- **options** `array` 操作配置
  - **transaction** `boolean` 开启事务，默认 `false`
  - **channel_id** `string` 定义信道ID，默认 `null`
  - **reply_code** `int` 回复码，默认 `0`
  - **reply_text** `string` 回复文本，默认 `''`
  - **method_sig** `array` 默认 `[0,0]`

```php
use think\support\facade\AMQP;
use simplify\amqp\AMQPManager;

AMQP::channel(function (AMQPManager $manager) {
    // Declare
    $manager->queue('test')
        ->setDeclare([
            'durable' => true
        ]);

    // Or delete
    $manager->queue('test')
        ->delete();
});
```

### channeltx(Closure $closure, string $name = 'default', array $options = [])

创建包含事务的信道

```php
use think\support\facade\AMQP;
use simplify\amqp\AMQPManager;

AMQP::channeltx(function (AMQPManager $manager) {
    $manager->publish(
        AMQPManager::message(
            json_encode([
                "name" => "test"
            ])
        ),
        '',
        'test'
    );
    // 当返回为 false 时，将不提交发布消息
    return true;
});
```

> 关于 `simplify\amqp\AMQPManager` 对象完整使用可查看 [simplify-amqp](https://github.com/kainonly/simplify-amqp) 的单元测试 `tests` 目录