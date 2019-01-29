# GetBeforeHooks

获取单个数据的通用请求处理前置自定义周期

```php
interface GetBeforeHooks
{
    /**
     * 获取单个数据的前置处理
     * @return boolean
     */
    public function __getBeforeHooks();
}
```

#### __getBeforeHooks()

获取单个数据的前置周期函数

- **Return** `boolean`，返回值为 `false` 则在此结束执行

实现接口

```php
use think\bit\lifecycle\GetBeforeHooks;

class AdminClass extends Base implements GetBeforeHooks {
    use GetModel;

    protected $model = 'admin';

    public function __getBeforeHooks()
    {
        return true;
    }
}
```