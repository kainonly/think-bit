## Bedis 缓存类

!>Redis 在给我们带来优异的读写性能时，同时也带来了恢复性差、团队协作性困难等问题，因此建议在我们所使用到的缓存键中分别定义缓存的刷新方式以及获取方式等，Bedis则是这样一个抽象类。

使用Bedis缓存类为接口定义HASH缓存

```php
class ApiHash extends Bedis
{
    protected $key = 'api_hash';

    function refresh()
    {
        $this->redis->del($this->key);
        $lists = Db::name('api')->where([
            'status' => 1
        ])->column('id', 'api');
        if (empty($lists)) return true;
        return $this->redis->hMSet($this->key, $lists);
    }

    public function get($api)
    {
        try {
            if (!$this->redis->exists($this->key)) $this->refresh();
            return $this->redis->hGet($this->key, $api);
        } catch (\Exception $e) {
            return '';
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