# OriginListsBeforeHooks

列表数据请求前置处理周期

#### 实现接口

```php
use think\bit\lifecycle\OriginListsBeforeHooks;

class NoBodyClass extends Base implements OriginListsBeforeHooks {
    public function __originListsBeforeHooks()
    {
        return true;
    }
}
```

#### overrides __originListsBeforeHooks()

- 返回 `true` 为前置处理成功，返回 `false` 为处理失败，自定义返回结果可使用 `origin_lists_before_result`  

```php
use think\bit\lifecycle\OriginListsBeforeHooks;

class NoBodyClass extends Base implements OriginListsBeforeHooks {
    public function __originListsBeforeHooks()
    {
        $result = condition();//false
        if(!$result) $this->origin_lists_before_result = [
            'error'=> 1,
            'msg'=> 'you msg'
        ];
        return $result;
    }
}
```

#### $this->post

请求数据

#### $this->origin_lists_before_result

自定义返回，默认为 `['error' => 1,'msg' => 'error:before_fail']`