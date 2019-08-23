## Logging 日志收集

Logging 日志收集器可通过 RabbitMQ 消息队列写入可选择可包含的信息数据，然后将 Logging 异步写入存储的日志数据库中分析需要的系统运行情况、用户操作行为或喜好等等，首先使用 `composer` 安装操作服务

```shell
composer require kain/think-amqp
```

然后需要更新配置 `config/queue.php`

```php
return [

    'logging' => [
        'exchange' => 'app.logging.direct',
    ]
    
];
```

- **exchange** `string` 交换器路径

#### push($namespace, $raws = [])

日志收集队列写入

- **$namespace** `string` 行为命名
- **raws** `array` 原始数据

使用如下

```php
Logging::push('pay_order', [
    'order' => Tools::orderNumber('L1', 'A1', '1100'),
    'product' => Tools::uuid(),
    'user' => Tools::uuid(),
    'create_time' => time(),
    'update_time' => time()
]);
```
