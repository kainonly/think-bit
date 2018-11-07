# EditAfterHooks

编辑数据的通用请求处理后置自定义周期

#### 实现接口

```php
use think\bit\lifecycle\EditAfterHooks;

class NoBodyClass extends Base implements EditAfterHooks {
    public function __editAfterHooks()
    {
        return true;
    }
}
```

#### __editAfterHooks()

- 返回 `true` 为后置处理成功，返回 `false` 为处理失败，自定义返回结果可使用 `edit_after_result`  

```php
use think\bit\lifecycle\EditAfterHooks;

class NoBodyClass extends Base implements EditAfterHooks {
    public function __editAfterHooks()
    {
        $result = checkChildExist($this->post['id']);//false
        if(!$result) $this->edit_after_result = [
            'error'=> 1,
            'msg'=> 'you msg'
        ];
        return $result;
    }
}
```

#### $this->post

请求数据

#### $this->edit_after_result

自定义返回，默认为 `['error' => 1,'msg' => 'fail:after']`

#### $this->edit_status_switch

是否为状态切换请求