#### Bedis 缓存定义

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