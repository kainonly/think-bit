## listsCustom

分页列表数据的通用请求处理自定义返回周期

#### 实现接口

```php
use think\bit\lifecycle\ListsCustom;

class NoBodyClass extends Base implements ListsCustom {
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

#### overrides __listsCustomReturn(Array $lists, int $total)

- `lists` 是默认获取到的分页列表数据
- `total` 是数据总数
- 返回通用请求对象

```php
use think\bit\lifecycle\ListsCustom;

class NoBodyClass extends Base implements ListsCustom {
    public function __listsCustomReturn(Array $lists, int $total)
    {
        $_lists = change($lists);
        return [
            'error' => 0,
            'data' => [
                'lists' => $_lists,
                'total' => $total,
            ]
        ];
    }
}
```

#### $this->post

请求数据