# AddAfterHooks

新增数据的通用请求处理后置自定义周期

#### 实现接口

```php
use think\bit\lifecycle\AddAfterHooks;

class NoBodyClass extends Base implements AddAfterHooks {
    public function __addAfterHooks($pk)
    {
        return true;
    }
}
```

#### __addAfterHooks($pk)

- `$pk` 通用处理后的主键
- 返回 `true` 为后置处理成功，返回 `false` 为处理失败，自定义返回结果可使用 `add_after_result`  

```php
use think\bit\lifecycle\AddAfterHooks;

class NoBodyClass extends Base implements AddAfterHooks {
    public function __addAfterHooks($pk)
    {
        $result = someone();//false
        if(!$result) $this->add_after_result = [
            'error'=> 1,
            'msg'=> 'you msg'
        ];
        return $result;
    }
}
```

#### $this->post

请求数据

#### $this->add_after_result

自定义返回，默认为 `['error' => 1,'msg' => 'fail:after']`