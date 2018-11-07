# EditBeforeHooks

编辑数据的通用请求处理前置自定义周期

#### 实现接口

```php
use think\bit\lifecycle\EditBeforeHooks;

class NoBodyClass extends Base implements EditBeforeHooks {
    public function __editBeforeHooks()
    {
        return true;
    }
}
```

#### overrides __editBeforeHooks()

- 返回 `true` 为前置处理成功，返回 `false` 为处理失败，自定义返回结果可使用 `edit_before_result`  

```php
use think\bit\lifecycle\EditBeforeHooks;

class NoBodyClass extends Base implements EditBeforeHooks {
    public function __editBeforeHooks()
    {
        $result = condition();//false
        if(!$result) $this->edit_before_result = [
            'error'=> 1,
            'msg'=> 'you msg'
        ];
        return $result;
    }
}
```

#### $this->post

请求数据

#### $this->edit_before_result

自定义返回，默认为 `['error' => 1,'msg' => 'fail:before']`

#### $this->edit_status_switch

是否为状态切换请求