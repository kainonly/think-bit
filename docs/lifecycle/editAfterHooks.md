## EditAfterHooks

编辑数据的通用请求处理后置自定义周期

```php
interface EditAfterHooks
{
    /**
     * 修改后置处理
     * @return mixed
     */
    public function __editAfterHooks();
}
```

#### __editBeforeHooks()

编辑前置周期

- **Return** `boolean`，返回值为 `false` 则在此结束执行进行事务回滚

实现接口

```php
use think\bit\traits\EditModel;
use think\bit\lifecycle\EditAfterHooks;

class AdminClass extends Base implements EditAfterHooks {
    use EditModel;

    protected $model = 'admin';

    public function __editAfterHooks()
    {
        return true;
    }
}
```