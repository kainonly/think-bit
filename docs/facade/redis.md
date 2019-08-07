## Redis 缓存

PhpRedis 操作类，使用前请确实是否已安装 [Redis](http://pecl.php.net/package/redis) 扩展，你需要更新配置 `config/database.php`，例如：

```php
return [
    'redis' => [
        'host' => env('redis.host', '127.0.0.1'),
        'password' => env('redis.password', null),
        'port' => env('redis.port', 6379),
        'database' => env('redis.db', 0),
    ],
];
```

- **host** `string` 连接地址
- **password** `string` 验证密码
- **port** `int` 端口
- **database** `int` 缓存库

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