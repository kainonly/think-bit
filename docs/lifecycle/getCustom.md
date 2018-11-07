# GetCustom

获取单条数据的通用请求处理自定义返回周期

#### 实现接口

```php
use think\bit\lifecycle\GetCustom;

class NoBodyClass extends Base implements GetCustom {
    public function __getCustomReturn(Array $data)
    {
        return [
            'error' => 0,
            'data' => $data
        ];
    }
}
```

#### __getCustomReturn(Array $data)

- `data` 是默认获取到的单条数据
- 返回通用请求对象

```php
use think\bit\lifecycle\GetCustom;

class NoBodyClass extends Base implements GetCustom {
    public function __getCustomReturn(Array $data)
    {
        $_data = change($data);
        return [
            'error' => 0,
            'data' => $_data
        ];
    }
}
```

#### $this->post

请求数据