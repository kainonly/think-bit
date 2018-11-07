# DeleteMongoDB

DeleteMongoDB 是针对删除数据的通用请求处理，仅支持 MongoDB PHP Library

#### 周期流程

执行通用请求 -> 验证器场景 -> (是否前置处理) -> 条件选择 -> 通用处理 -> (是否后置处理) -> 返回通用处理请求

> 条件选择： `post['where']` 必须存在

- `post['where]` 需满足 MongoDB CRUD operation，例如 `['id' => 'xxx']`，主键将自动转换为ObjectId

#### 引入特性

必须定义模型名称

```php
use think\bit\traits\DeleteMongoDB;

class NoBodyClass extends Base {
    use DeleteMongoDB;

    protected $model = 'nobody';
}
```

可定义验证器属性 `$this->delete_validate`，默认为 `['id' => 'require']`

```php
use think\bit\traits\DeleteMongoDB;

class NoBodyClass extends Base {
    use DeleteMongoDB;

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

#### 返回数据

- `error` 响应状态
- `msg` 回馈代码