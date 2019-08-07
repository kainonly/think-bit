## BitRedis 缓存模型

使用 BitRedis 定义缓存操作模型，例如：管理员缓存，该场景仅适用中小型的数据缓存，如果数据量巨大，请使用其他方式设计缓存。

```php
class Admin extends BitRedis
{
    protected $key = 'Admin';

    /**
     * 缓存刷新
     * @return bool
     */
    public function refresh()
    {
        $this->redis->del([$this->key]);
        $lists = Db::name('admin')->where([
            'status' => 1
        ])->column('username,password', 'username');
        if (empty($lists)) return true;
        return $this->redis->hmset($this->key, $lists);
    }

    /**
     * 获取口令
     * @param string $username 用户名
     * @return string
     */
    public function get($username)
    {
        if (!$this->redis->exists($this->key)) $this->refresh();
        return $this->redis->hget($this->key, $username);
    }
}
```

当对应的 `Admin` 数据模型发生变化时，可以在变化周期内使用缓存模型的 `refresh()` 来重置刷新，即可生效

```php

(new Admin())->refresh();

```

通过缓存模型定义个获取规则获取对应数据，例如：使用管理员 `username` 做为索引键，查询出对应的验证 `HASH` 值

```php

(new Admin())->get('kain');

```

使用事务

```php
Redis::client()->transaction(function (MultiExec $multiExec) {
    (new Admin($multiExec))->refresh();
    (new Someone($multiExec))->refresh();
});
```