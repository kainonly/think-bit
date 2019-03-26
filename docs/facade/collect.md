## Collect 数据收集

Collect 是用于简化数据收集消息队列写入的函数, 首先需要配置 `Rabbitmq`, 然后在修改配置 `config/queue.php`

```php
return [
    'collect' => [
        'exchange' => '',
        'queue' => ''
    ]
];
```

- **exchange** 交换器
- **queue** 队列

#### push($motivation, $data = [], $time_field = [])

数据收集队列写入

- **motivation** `string` 行为命名
- **data** `array` 数据
- **time_field** `array` 时间字段

使用如下

```php
Collect::push('pay_order', [
    'order' => Tools::orderNumber('L1', 'A1', '1100'),
    'product' => Tools::uuid(),
    'user' => Tools::uuid(),
    'create_time' => time(),
    'update_time' => time()
], ['create_time', 'update_time']);
```

!> 使用前对应配置队列写入服务 https://github.com/kainonly/collection-service