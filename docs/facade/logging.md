## Logging 队列处理

是用于简化数据收集消息队列写入的函数, 首先需要配置 `Rabbitmq`，并安装库

```shell
composer require kain/think-logging
```

然后在修改配置 `config/queue.php`

```php
return [
    'logging' => [
        'exchange' => 'system',
        'queue' => 'system'
    ]
];
```

- **exchange** 交换器
- **queue** 队列

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

!> 使用前对应配置队列写入服务 https://github.com/kainonly/amqp-logging-service
