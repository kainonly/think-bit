## RedisModel 缓存模型

使用 RedisModel 定义缓存模型，目的是将分散的缓存操作统一定义，与数据库即时执行同步去耦合，同时支持多个模型注入事务，例如：设定Acl访问控制表的缓存模型

```php
class Acl extends RedisModel
{
    protected $key = 'system:acl';

    /**
     * 刷新访问控制缓存
     * @return bool
     * @throws \Exception
     */
    public function refresh()
    {
        $this->redis->del([$this->key]);
        $lists = Db::name('acl')
            ->where('status', '=', 1)
            ->field(['key', 'write', 'read'])
            ->select();

        if (empty($lists)) {
            return true;
        }

        return !empty($this->redis->pipeline(
            function (Pipeline $pipeline) use ($lists) {
                foreach ($lists as $key => $value) {
                    $pipeline->hset($this->key, $value['key'], json_encode([
                        'write' => $value['write'],
                        'read' => $value['read']
                    ]));
                }
            }
        ));
    }

    /**
     * @param string $key 访问键
     * @return mixed
     * @throws \Exception
     */
    public function get(string $key)
    {
        if (!$this->redis->exists($this->key)) {
            $this->refresh();
        }

        return json_decode($this->redis->hget($this->key, $url), true);
    }
}
```

当对应的 `acl` 表数据发生变更时，执行 `refresh()` 来重置刷新

```php
(new Acl())->refresh();
```

通过缓存模型自定义的获取规则获取对应的数据，例如：查访问键 `admin` 对应的数据

```php
(new Acl())->get('admin');
```

如果同时要执行多个缓存模型，可以注入事务对象

```php
Redis::transaction(function (MultiExec $multiExec) {
    (new Acl($multiExec))->refresh();
    (new Someone1($multiExec))->refresh();
    (new Someone2($multiExec))->refresh();
    (new Someone3($multiExec))->refresh();
});
```