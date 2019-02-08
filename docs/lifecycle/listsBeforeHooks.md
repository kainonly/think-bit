## ListsBeforeHooks

分页数据的通用请求处理前置自定义周期

```php
interface ListsBeforeHooks
{
    /**
     * 分页数据获取前置处理
     * @return boolean
     */
    public function __listsBeforeHooks();
}
```

#### __listsBeforeHooks()

分页数据前置周期

- **Return** `boolean`，返回值为 `false` 则在此结束执行

实现接口

```php
use think\bit\traits\ListsModel;
use think\bit\lifecycle\ListsBeforeHooks;

class AdminClass extends Base implements ListsBeforeHooks {
    use ListsModel;

    protected $model = 'admin';

    public function __listsBeforeHooks()
    {
        return true;
    }
}
```