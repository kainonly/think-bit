## OriginListsCustom

列表数据的通用请求处理自定义返回周期

```php
interface OriginListsCustom
{
    /**
     * 自定义无分页数据返回
     * @param array $lists
     * @return array
     */
    public function __originListsCustomReturn(Array $lists);
}
```

#### __originListsCustomReturn(Array $lists)

列表数据自定义返回周期

- **lists** `array` 原数据

实现接口

```php
use think\bit\traits\OriginListsModel;
use think\bit\lifecycle\OriginListsCustom;

class AdminClass extends Base implements OriginListsCustom {
    use OriginListsModel;

    protected $model = 'admin';

    public function __originListsCustomReturn(Array $lists)
    {
        return [
            'error' => 0,
            'data' => $lists
        ];
    }
}
```