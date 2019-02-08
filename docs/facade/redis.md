## Redis 缓存

PhpRedis 操作类，使用前请确实是否已安装 [Redis](http://pecl.php.net/package/redis) 扩展，你需要在主配置或对应的模块下创建配置 `config/redis.php`，例如：

```php
return [
    'connect' => 'localhost',
    'port' => 6379,
    'auth' => '12345678',
    'select' => 0
];
```

- **connect** `string` 连接地址
- **port** `int` 端口
- **auth** `string` 验证密码
- **select** `int` 库号

#### model ($index)

定义 Redis 操作模型

- **index** `int|null` 库号，默认 `null`
- **Return** `Redis`

设置一个字符串缓存

```php
use think\bit\facade\Redis;

Redis::model()->set('hello', 'world');
```

#### transaction(Closure $closure)

定义 Redis 事务处理

- **closure** `Closure`
- **Return** `boolean`

执行一段缓存事务设置

```php
use think\bit\facade\Redis;

Redis::transaction(function (\Redis $redis) {
    return (
        $redis->set('name1', 'js') &&
        $redis->set('name2', 'php')
    );
});
// true or false
```