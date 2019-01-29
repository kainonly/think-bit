## ListsBeforeHooks

新增数据的通用请求处理前置自定义周期

#### 实现接口

```php
use think\bit\lifecycle\ListsBeforeHooks;

class NoBodyClass extends Base implements ListsBeforeHooks {
    public function __listsBeforeHooks()
    {
        return true;
    }
}
```

#### overrides __listsBeforeHooks()

- 返回 `true` 为前置处理成功，返回 `false` 为处理失败，自定义返回结果可使用 `lists_before_result`  

```php
use think\bit\lifecycle\ListsBeforeHooks;

class NoBodyClass extends Base implements ListsBeforeHooks {
    public function __listsBeforeHooks()
    {
        $result = condition();//false
        if(!$result) $this->lists_before_result = [
            'error'=> 1,
            'msg'=> 'you msg'
        ];
        return $result;
    }
}
```

#### $this->post

请求数据

#### $this->lists_before_result

自定义返回，默认为 `['error' => 1,'msg' => 'error:before_fail']`