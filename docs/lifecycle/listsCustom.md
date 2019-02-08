## ListsCustom

分页数据的通用请求处理自定义返回周期

```php
interface ListsCustom
{
    /**
     * 自定义无分页数据返回
     * @param array $lists
     * @param int $total
     * @return array
     */
    public function __listsCustomReturn(Array $lists, int $total);
}
```

#### __listsCustomReturn(Array $lists, int $total)

分页数据自定义返回周期

- **lists** `array` 原数据
- **total** `int` 数据总数

实现接口

```php
use think\bit\traits\ListsModel;
use think\bit\lifecycle\ListsCustom;

class AdminClass extends Base implements ListsCustom {
    use ListsModel;

    protected $model = 'admin';

    public function __listsCustomReturn(Array $lists, int $total)
    {
        return [
            'error' => 0,
            'data' => [
                'lists' => $lists,
                'total' => $total,
            ]
        ];
    }
}
```