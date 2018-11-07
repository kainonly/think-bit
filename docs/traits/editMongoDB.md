# EditMongoDB

EditMongoDB 是针对删除数据的通用请求处理，仅支持 MongoDB PHP Library

#### 周期流程

执行通用请求 -> 验证器 ->(是否为状态请求) -> (不是状态请求，验证器场景) -> (是否前置处理) -> 通用处理 -> (是否后置处理) -> 返回通用处理请求

> 条件选择：如果请求的条件参数只能从 `post['id']` 或 `post['where']` 选择。

- `post['id']` 类型 `string`
- `post['where]` 需满足 MongoDB CRUD operation 即可

#### 引入特性

必须定义模型名称

```php
use think\bit\traits\EditMongoDB;

class NoBodyClass extends Base {
    use EditMongoDB;

    protected $model = 'nobody';
}
```

可定义验证器属性 `$this->edit_validate`，该验证器会执行在状态请求判断之前，默认为 `['id' => 'require', 'switch' => 'bool']`

```php
use think\bit\traits\EditMongoDB;

class NoBodyClass extends Base {
    use EditMongoDB;

    protected $model = 'nobody';
    protected $edit_validate = [
        'id' => 'require'
        'switch' => 'bool',
        'status' => 'require',
    ];
}
```

如果非状态请求需要对应创建验证器场景 `validate/NoBodyClass`

```php
use think\Validate;

class NoBodyClass extends Validate
{
    protected $rule = [
        'name' => 'require',
    ];

    protected $scene = [
        'edit' => ['name'],
    ];
}
```

#### $this->edit_status_switch

是否为状态请求

#### overrides __editBeforeHooks()

自定义前置处理

#### $this->add_before_result

新增自定义前置返回，默认为 `['error' => 1,'msg' => 'fail:before']`

#### overrides __editAfterHooks()

自定义后置处理

#### $this->edit_after_result

新增自定义后置返回，默认为 `['error' => 1,'msg' => 'fail:after']`

#### 返回数据

- `error` 响应状态
- `msg` 回馈代码