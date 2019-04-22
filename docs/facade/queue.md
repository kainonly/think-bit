## Queue 队列处理

 是用于简化数据收集消息队列写入的函数, 首先需要配置 `Rabbitmq`, 然后在修改配置 `config/queue.php`

```php
return [
    'daq' => [
        'exchange' => 'system',
        'queue' => 'system'
    ]
];
```

- **exchange** 交换器
- **queue** 队列

#### push($namespace, $data = [])

数据收集队列写入

- **$namespace** `string` 行为命名
- **data** `array` 数据

使用如下

```php
Queue::push('pay_order', [
    'order' => Tools::orderNumber('L1', 'A1', '1100'),
    'product' => Tools::uuid(),
    'user' => Tools::uuid(),
    'create_time' => time(),
    'update_time' => time()
]);
```

!> 使用前对应配置队列写入服务 https://github.com/kainonly/collection-service