# Redis

Redis 是一个开源的使用ANSI C语言编写、遵守BSD协议、支持网络、可基于内存亦可持久化的日志型、Key-Value数据库，并提供多种语言的API。
它通常被称为数据结构服务器，因为值（value）可以是 字符串(String), 哈希(Map), 列表(list), 集合(sets) 和 有序集合(sorted sets)等类型。

#### 配置

在ThinkPHP项目中下创建 `config/redis.php`

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
- 返回 `<Redis>`

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

> 门面 Redis 基于 phpredis ，详情参考 https://github.com/phpredis/phpredis

#### Bedis

Redis 在给我们带来优异的读写性能时，同时也带来了恢复性差、团队协作性困难等问题，因此建议在我们所使用到的缓存键中分别定义缓存的生产方式、获取方式以及恢复方式等，Bedis则是这样一个抽象类。

为人员缓存定义缓存列表类

```php
namespace app\redis\model;

use bit\common\Bedis;
use think\Db;

class Person extends Bedis
{
    protected $key = 'person_lists';

    function factory($key)
    {
        $data = Db::name('any')->where(['id' => $key])->find();
        $this->redis->hSet($this->key, $key, msgpack_pack($data));
    }

    function get($key)
    {
        $this->unusual();
        return msgpack_unpack($this->redis->hGet($this->key, $key));
    }

    function delete($key)
    {
        $this->redis->hDel($this->key, $key);
    }

    private function unusual()
    {
        if (!$this->redis->exists($this->key)) $this->repair();
    }

    private function repair()
    {
        $rows = Db::name('any')->select();

        foreach ($rows as $key => $value) {
            $this->redis->hSet($this->key, $value['key'], msgpack_pack($value));
        }
    }
}
```

这样定义后我们就可以在其他模块中方便使用，比如生产一个人员缓存

```php
$person = new Person();
$person->factory('1');
```

获取这个人员缓存

```php
$person->get('1');
```

如果使用事务则实现化时赋值参数

```php
Redis::transaction(function (\Redis $redis) {
    $person = new Person($redis);
    $car = new Car($redis);
    return ($person->factory('1') && $car->factory('1'));
});// true or false
```