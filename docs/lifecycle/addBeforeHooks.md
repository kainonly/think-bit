## AddBeforeHooks

新增数据的通用请求处理前置自定义周期

```php
interface AddBeforeHooks
{
    /**
     * 新增前置处理
     * @return boolean
     */
    public function __addBeforeHooks();
}
```

#### __addBeforeHooks()

新增前置周期

- **Return** `boolean`，返回值为 `false` 则在此结束执行

实现接口

```php
use think\bit\traits\AddModel;
use think\bit\lifecycle\AddBeforeHooks;

class AdminClass extends Base implements AddBeforeHooks {
    use AddModel;

    protected $model = 'admin';

    public function __addBeforeHooks()
    {
        return true;
    }
}
```