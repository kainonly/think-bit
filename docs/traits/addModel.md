# AddModel

AddModel 是针对新增数据的通用请求处理，支持ThinkPHP下定义的数据库

#### 周期流程

执行通用请求 -> 验证器场景 -> (是否前置处理) -> 通用处理 -> (是否后置处理) -> 返回通用处理请求

#### 引入特性

必须定义模型名称

```php
use think\bit\traits\AddModel;

class NoBodyClass extends Base {
    use AddModel;

    protected $model = 'nobody';
}
```

需要对应创建验证器场景 `validate/NoBodyClass`

```php
use think\Validate;

class NoBodyClass extends Validate
{
    protected $rule = [
        'name' => 'require',
    ];

    protected $scene = [
        'add' => ['name'],
    ];
}
```

#### __addBeforeHooks()

自定义前置处理

#### add_before_result

新增自定义前置返回，默认为 `['error' => 1,'msg' => 'fail:before']`

#### __addAfterHooks($pk)

自定义后置处理

#### add_after_result

新增自定义后置返回，默认为 `['error' => 1,'msg' => 'fail:after']`