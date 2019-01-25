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

当接口数据发生更新时则可以使用 `refresh` 函数将缓存刷新

```php
$api = new ApiHash();
$api->refresh();
```

!> 缓存的生产设定不建议使用组合数据或一对一来生成，这样会提高数据的耦合度，增大开发与维护的难度

通过接口缓存获取对应的接口主键

```php
$api = new ApiHash();
$api->get('admin/get');
```

如果使用事务则实现化时赋值参数

```php
Redis::transaction(function (\Redis $redis) {
    $api = new ApiHash($redis);
    $router = new RouterHash($redis);
    return ($api->refresh() && $router->refresh());
});
// true or false
```