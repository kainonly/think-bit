## DeletePrepHooks

删除数据的通用请求处理在事务之后模型写入之前的的自定义周期

```php
interface DeletePrepHooks
{
    /**
     * 在事务之后模型写入之前的处理
     * @return mixed
     */
    public function __deletePrepHooks();
}
```

#### __deletePrepHooks()

删除在事务之后模型写入之前的周期

- **Return** `boolean`，返回值为 `false` 则在此结束执行进行事务回滚

实现接口

```php
use think\bit\traits\DeleteModel;
use think\bit\lifecycle\DeletePrepHooks;

class AdminClass extends Base implements DeletePrepHooks {
    use DeleteModel;

    protected $model = 'admin';

    public function __deletePrepHooks()
    {
        return true;
    }
}
```