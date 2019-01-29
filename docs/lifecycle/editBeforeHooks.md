# EditBeforeHooks

编辑数据的通用请求处理前置自定义周期

```php
interface EditBeforeHooks
{
    /**
     * 修改前置处理
     * @return boolean
     */
    public function __editBeforeHooks();
}
```

#### __editBeforeHooks()

修改前置周期函数

- **Return** `boolean`，返回值为 `false` 则在此结束执行

实现接口

```php
use think\bit\lifecycle\EditBeforeHooks;

class AdminClass extends Base implements EditBeforeHooks {
    use EditModel;

    protected $model = 'admin';

    public function __editBeforeHooks()
    {
        return true;
    }
}
```