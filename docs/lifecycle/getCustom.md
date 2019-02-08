## GetCustom

单条数据的通用请求处理自定义返回周期

```php
interface GetCustom
{
    /**
     * 自定义单个数据返回
     * @param array $data
     * @return array
     */
    public function __getCustomReturn(Array $data);
}
```

#### __getCustomReturn($data)

获取单个数据的前置周期函数

- **data** `array` 原数据

实现接口

```php
use think\bit\traits\GetModel;
use think\bit\lifecycle\GetCustom;

class AdminClass extends Base implements GetCustom {
    use GetModel;

    protected $model = 'admin';

    public function __getCustomReturn($data)
    {
        return [
            'error' => 0,
            'data' => $data
        ];
    }
}
```