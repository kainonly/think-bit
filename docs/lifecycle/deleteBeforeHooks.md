## DeleteBeforeHooks

删除数据的通用请求处理前置自定义周期

```php
interface DeleteBeforeHooks
{
    /**
     * 删除前置处理
     * @return boolean
     */
    public function __deleteBeforeHooks();
}
```

#### __deleteBeforeHooks()

删除前置周期

- **Return** `boolean`，返回值为 `false` 则在此结束执行

实现接口

```php
use think\bit\traits\DeleteModel;
use think\bit\lifecycle\DeleteBeforeHooks;

class AdminClass extends Base implements DeleteBeforeHooks {
    use AddModel;

    protected $model = 'admin';

    public function __deleteBeforeHooks()
    {
        return true;
    }
}
```