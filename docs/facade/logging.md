## Logging 队列处理

是用于简化数据收集消息队列写入的函数, 首先需要配置 `Rabbitmq`，并安装库

```shell
composer require kain/think-logging
```

!> 使用前需配置 Logging 队列写入服务 https://github.com/kainonly/amqp-logging-service

配置 `config/queue.php`

```php
return [
    'logging' => [
        'exchange' => 'app.logging.direct',
    ]
];
```

- **exchange** 交换器路径

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
