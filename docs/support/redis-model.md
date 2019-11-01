## RedisModel 缓存模型

使用 RedisModel 定义缓存模型，目的是将分散的缓存操作统一定义，例如：设定Acl访问控制表的缓存模型

```php
class Acl extends RedisModel
{
    protected $key = 'system:acl';
    private $rows = [];

    /**
     * 清除缓存
     * @return bool
     */
    public function clear()
    {
        return (bool)$this->redis->del([$this->key]);
    }

    /**
     * @param string $key 访问控制键
     * @param int $policy 控制策略
     * @return array
     * @throws \Exception
     */
    public function get(string $key, int $policy)
    {
        if (!$this->redis->exists($this->key)) {
            $this->update($key);
        } else {
            $this->rows = json_decode($this->redis->hget($this->key, $key), true);
        }

        switch ($policy) {
            case 0:
                return explode(',', $this->rows['read']);
            case 1:
                return array_merge(
                    explode(',', $this->rows['read']),
                    explode(',', $this->rows['write'])
                );
            default:
                return [];
        }
    }

    /**
     * 更新缓存
     * @param string $key 访问控制键
     * @throws \Exception
     */
    private function update(string $key)
    {
        $lists = Db::name('acl')
            ->where('status', '=', 1)
            ->field(['key', 'write', 'read'])
            ->select();

        if (empty($lists)) {
            return;
        }

        $this->redis->pipeline(function (Pipeline $pipeline) use ($key, $lists) {
            foreach ($lists as $index => $value) {
                $pipeline->hset($this->key, $value['key'], json_encode([
                    'write' => $value['write'],
                    'read' => $value['read']
                ]));
                if ($key == $value['key']) {
                    $this->rows = [
                        'write' => $value['write'],
                        'read' => $value['read']
                    ];
                }
            }
        });
    }
}
```

当对应的 `acl` 表数据发生变更时，执行 `clear()` 来清除缓存

```php
Acl::create()->clear();
```

通过缓存模型自定义的获取规则获取对应的数据，例如：查访问键 `admin` 对应的数据，如缓存不存在则生成缓存并返回数据

```php
Acl::create()->get('admin', 0);
```

如果同时要执行多个缓存模型，可以注入事务对象

```php
Redis::transaction(function (MultiExec $multiExec) {
    Someone1::create($multiExec)->factory();
    Someone2::create($multiExec)->factory();
    Someone3::create($multiExec)->factory();
});
```