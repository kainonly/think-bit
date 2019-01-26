# OriginListsMongoDB

OriginListsMongoDB 是针对列表数据的通用请求处理，仅支持 MongoDB PHP Library

#### 周期流程

执行通用请求 -> 验证器场景 -> 条件合并 -> 通用处理 -> (是否自定义返回数据) -> 返回处理请求

> 条件合并：`post['where']` 条件会与设定固定的条件属性 `lists_origin_condition` 进行合并，检测 `post['like']` 是否存在并合并模糊搜索

- `post['where]` 需满足 MongoDB CRUD operation 即可

#### 引入特性

必须定义模型名称

```php
use think\bit\traits\OriginListsMongoDB;

class NoBodyClass extends Base {
    use OriginListsMongoDB;

    protected $model = 'nobody';
}
```

需要对应创建验证器场景 `validate/NoBodyClass`

```php
use think\Validate;

class NoBodyClass extends Validate
{
    protected $rule = [
        'status' => 'require',
    ];

    protected $scene = [
        'origin' => ['status'],
    ];
}
```

可定义固定条件属性 `$this->lists_origin_condition`，默认为 `[]`，需满足 MongoDB CRUD operation

```php
use think\bit\traits\OriginListsMongoDB;

class NoBodyClass extends Base {
    use OriginListsMongoDB;

    protected $model = 'nobody';
    protected $lists_origin_condition = [
        ['status' => 1]
    ];
}
```

#### overrides __originListsCustomReturn()

自定义列表数据返回

#### 返回数据

- `error` 响应状态
- `data` 返回列表数据
- `msg` 回馈代码