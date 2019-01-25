# Redis 缓存

PhpRedis 

在ThinkPHP项目中下创建 `config/redis.php`，设置配置

```php
return [
    'connect' => 'localhost',
    'port' => '6379',
    'auth' => '123',
    'select' => 0
];
```

- `connect` 连接地址
- `port` 端口
- `auth` 验证密码
- `select` 库号

#### model ($index = null)

定义 Redis 操作模型

- `$index` 库号
- 返回 `<\Redis>`

例子.设置一个字符串缓存

```php
use think\bit\facade\Redis;

Redis::model()->set('hello', 'world');
```

#### transaction(Closure $closure)

定义 Redis 事务处理

- `$closure` 函数定义为 `function (\Redis $redis)`
- 返回 `<bool>`

执行一段缓存事务设置

```php
use think\bit\facade\Redis;

Redis::transaction(function (\Redis $redis) {
    return (
        $redis->set('name1', 'js') &&
        $redis->set('name2', 'php')
    );
});// true or false
```