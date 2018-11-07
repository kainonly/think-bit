# DeleteAfterHooks

删除数据的通用请求处理后置自定义周期

#### 实现接口

```php
use think\bit\lifecycle\DeleteAfterHooks;

class NoBodyClass extends Base implements DeleteAfterHooks {
    public function __deleteAfterHooks()
    {
        return true;
    }
}
```

#### __deleteAfterHooks()

- 返回 `true` 为后置处理成功，返回 `false` 为处理失败，自定义返回结果可使用 `delete_after_result`  

```php
use think\bit\lifecycle\DeleteAfterHooks;

class NoBodyClass extends Base implements DeleteAfterHooks {
    public function __deleteAfterHooks()
    {
        $result = checkChildExist($this->post['id']);//false
        if(!$result) $this->delete_after_result = [
            'error'=> 1,
            'msg'=> 'you msg'
        ];
        return $result;
    }
}
```

#### $this->post

请求数据

#### $this->delete_after_result

自定义返回，默认为 `['error' => 1,'msg' => 'fail:after']`