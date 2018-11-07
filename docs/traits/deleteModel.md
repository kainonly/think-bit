# DeleteModel

DeleteModel 是针对删除数据的通用请求处理，支持ThinkPHP下定义的数据库

#### 周期流程

执行通用请求 -> 验证器场景 -> (是否前置处理) -> 条件选择 -> 通用处理 -> (是否后置处理) -> 返回通用处理请求

> 条件选择：如果请求参数存 `post['id']`，那么 `post['where']` 存在即成为附加条件；如果 `post['id']` 不存在参数中，那么 `post['where']` 为主要条件

- `post['id']` 类型 `int|string` 或 `int[]|string[]`
- `post['where]` 必须为数组条件 `[['name','=','test']]`

#### 引入特性

必须定义模型名称

```php
use think\bit\traits\DeleteModel;

class NoBodyClass extends Base {
    use DeleteModel;

    protected $model = 'nobody';
}
```

可定义验证器属性 `$this->delete_validate`，默认为 `['id' => 'require']`

```php
use think\bit\traits\DeleteModel;

class NoBodyClass extends Base {
    use DeleteModel;

    protected $model = 'nobody';
    protected $delete_validate = [
        'id' => 'require'
        'name' => 'require',
    ];
}
```

#### overrides __deleteBeforeHooks()

自定义前置处理

#### $this->delete_before_result

新增自定义前置返回，默认为 `['error' => 1,'msg' => 'fail:before']`

#### overrides __deleteAfterHooks()

自定义后置处理

#### $this->delete_after_result

新增自定义后置返回，默认为 `['error' => 1,'msg' => 'fail:after']`