## DeleteAfterHooks

删除数据的通用请求处理后置自定义周期

```php
interface DeleteAfterHooks
{
    /**
     * 删除后置处理
     * @return mixed
     */
    public function __deleteAfterHooks();
}
```

#### __deleteAfterHooks()

删除后置周期

- **Return** `boolean`，返回值为 `false` 则在此结束执行进行事务回滚

实现接口

```php
use think\bit\traits\DeleteModel;
use think\bit\lifecycle\DeleteAfterHooks;

class AdminClass extends Base implements DeleteAfterHooks {
    use AddModel;

    protected $model = 'admin';

    public function __deleteAfterHooks()
    {
        return true;
    }
}
```