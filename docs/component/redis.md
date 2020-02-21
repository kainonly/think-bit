## Redis 缓存

Redis 缓存使用 [Predis](https://github.com/nrk/predis) 做为依赖，还需要安装 `kain/think-redis`

```shell
composer require kain/think-redis
```

安装后服务将自动注册，然后需要更新配置 `config/database.php`，例如：

```php
return [

    'redis' => [
        'default' => [
            // 服务器地址
            'host' => Env::get('redis.host', '127.0.0.1'),
            // 密码
            'password' => Env::get('redis.password', null),
            // 端口
            'port' => Env::get('redis.port', 6379),
            // 数据库号
            'database' => Env::get('redis.db', 0),
        ]
    ],
    
];
```

- **scheme** `string` 连接协议，支持 `tcp` `unix` `http`
- **host** `string` 目标服务器的IP或主机名
- **port** `int` 目标服务器的TCP / IP端口
- **path** `string` 使用 `unix socket` 的文件路径
- **database** `int` 逻辑数据库
- **password** `string` 身份验证口令
- **async** `boolean` 指定是否以非阻塞方式建立与服务器的连接
- **persistent** `boolean` 指定在脚本结束其生命周期时是否应保持基础连接资源处于打开状态
- **timeout** `float` 用于连接到Redis服务器的超时
- **read_write_timeout** `float` 在对基础网络资源执行读取或写入操作时使用的超时
- **alias** `string` 通过别名来标识连接
- **weight** `integer` 集群权重
- **iterable_multibulk** `boolean` 当设置为true时，Predis将从Redis返回multibulk作为迭代器实例而不是简单的PHP数组
- **throw_errors** `boolean` 设置为true时，Redis生成的服务器错误将转换为PHP异常

### client(string $name = 'default')

- **name** `string` 配置标识
- **Return** `Predis\Client`

测试写入一个缓存

```php
use think\support\facade\Redis;

Redis::client()->set('name', 'abc')
```

使用 `pipeline` 批量执行一万条写入

```php
use think\support\facade\Redis;

Redis::client()->pipeline(function (Pipeline $pipeline) {
    for ($i = 0; $i < 10000; $i++) {
        $pipeline->set('test:' . $i, $i);
    }
});
```

面向缓存使用事务处理

```php
use think\support\facade\Redis;

// success
Redis::client()->transaction(function (MultiExec $multiExec) {
    $multiExec->set('name:a', 'a');
    $multiExec->set('name:b', 'b');
});

// failed
Redis::client()->transaction(function (MultiExec $multiExec) {
    $multiExec->set('name:a', 'a');
    // mock exception
    throw new Exception('error');
    $multiExec->set('name:b', 'b');
});
```