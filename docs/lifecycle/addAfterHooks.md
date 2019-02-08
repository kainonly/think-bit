## AddAfterHooks

新增数据的通用请求处理后置自定义周期

```php
interface AddAfterHooks
{
    /**
     * 新增后置处理
     * @param string|int $pk 主键
     * @return mixed
     */
    public function __addAfterHooks($pk);
}
```

#### __addAfterHooks($pk)

新增后置周期

- **pk** `string|int` 模型写入后返回的主键
- **Return** `boolean`，返回值为 `false` 则在此结束执行进行事务回滚

实现接口

```php
use think\bit\traits\AddModel;
use think\bit\lifecycle\AddAfterHooks;

class AdminClass extends Base implements AddAfterHooks {
    use AddModel;

    protected $model = 'admin';

    public function __addAfterHooks($pk)
    {
        return true;
    }
}
```