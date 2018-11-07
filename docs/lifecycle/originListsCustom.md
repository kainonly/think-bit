# OriginListsCustom

列表数据的通用请求处理自定义返回周期

#### 实现接口

```php
use think\bit\lifecycle\OriginListsCustom;

class NoBodyClass extends Base implements OriginListsCustom {
    public function __originListsCustomReturn(Array $lists)
    {
        return [
            'error' => 0,
            'data' => $lists
        ];
    }
}
```

#### overrides __originListsCustomReturn(Array $lists)

- `lists` 是默认获取到的列表数据
- 返回通用请求对象

```php
use think\bit\lifecycle\OriginListsCustom;

class NoBodyClass extends Base implements OriginListsCustom {
    public function __originListsCustomReturn(Array $lists)
    {
        $_lists = change($lists);
        return [
            'error' => 0,
            'data' => $_lists
        ];
    }
}
```

#### $this->post

请求数据