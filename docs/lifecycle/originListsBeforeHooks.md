## OriginListsBeforeHooks

列表数据请求前置处理周期

```php
interface OriginListsBeforeHooks
{
    /**
     * 列表数据获取前置处理
     * @return boolean
     */
    public function __originListsBeforeHooks();
}
```

#### __originListsBeforeHooks()

列表数据前置周期

- **Return** `boolean`，返回值为 `false` 则在此结束执行

实现接口

```php
use think\bit\traits\OriginListsModel;
use think\bit\lifecycle\OriginListsBeforeHooks;

class AdminClass extends Base implements OriginListsBeforeHooks {
    use OriginListsModel;

    protected $model = 'admin';

    public function __originListsBeforeHooks()
    {
        $this->lists_origin_before_result = [
            'error'=> 1,
            'msg'=> 'error:only'
        ];
        return false;
    }
}
```