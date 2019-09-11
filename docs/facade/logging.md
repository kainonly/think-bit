## Logging 数据收集

Logging 通过 RabbitMQ 消息队列异步对数据进行收集，首先使用 `composer` 安装操作服务

```shell
composer require kain/think-logging
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

数据收集队列写入

- **$namespace** `string` 行为命名
- **raws** `array` 原始数据

使用如下

```php
Logging::push('pay_order', [
    'order' => 'oa1578456215654',
    'product' => 'b527920b-e933-4431-9231-14a1831f571d',
    'user' => 'c801fbc1-2464-4449-b221-b56f4d8a5e93',
    'create_time' => time(),
    'update_time' => time()
]);
```
