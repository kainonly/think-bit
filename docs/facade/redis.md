# Redis

#### 基础处理

##### `Redis::model($index = null)`

- `index` redis 库

设置一个字符串缓存

```php
Redis::model(0)->set('name', 'kain');
```

> 选择redis库之后返回phpredis对象，使用使用方法请看 https://github.com/phpredis/phpredis

#### 事务处理

##### `Redis::transaction(Closure $closure)`

- `closure` 闭包函数 `function (\Redis $redis)`

执行一段缓存事务设置

```php
Redis::transaction(function (\Redis $redis) {
    $redis->set('name1', 'kain');
    $redis->set('name2', 'php');
});
```

> 事务将返回 `true` 或 `false`

#### 模型

> Redis在给我们带来优异的读写性能时，同时也带来了恢复性差、团队协作性困难等问题，因此建议在我们所使用到的缓存键中分别定义缓存的生产方式、获取方式以及恢复方式等。

为人员缓存定义缓存列表类

```php
namespace app\redis\model;

use bit\common\Bedis;
use think\Db;

class Person extends Bedis
{
    protected $key = 'person_lists';

    /**
     * 生产缓存
     * @param $key
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function factory($key)
    {
        $data = Db::name('any')->where(['id' => $key])->find();
        $this->redis->hSet($this->key, $key, msgpack_pack($data));
    }

    /**
     * 获取缓存
     * @param $key
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function get($key)
    {
        $this->unusual();
        return msgpack_unpack($this->redis->hGet($this->key, $key));
    }

    /**
     * 删除缓存
     * @param $key
     */
    function delete($key)
    {
        $this->redis->hDel($this->key, $key);
    }

    /**
     * 非正常判断
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function unusual()
    {
        if (!$this->redis->exists($this->key)) $this->repair();
    }

    /**
     * 恢复缓存
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
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
});
```

> 当然这只是为了解决团队协作与缓存恢复等问题的一种设计方式，正常情况下我们还需要补充异常处理与一些特殊的判断。