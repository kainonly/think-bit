# GetModel

GetModel 是针对获取单条数据的通用请求处理，支持ThinkPHP下定义的数据库

#### 周期流程

执行通用请求 -> 验证器 -> 条件选择与合并 -> 通用处理 -> (是否自定义返回数据) -> 返回处理请求

> 条件选择与合并：如果请求参数存 `post['id']`，那么 `post['where']` 存在即成为附加条件；如果 `post['id']` 不存在参数中，那么 `post['where']` 为主要条件。选择好的条件会与设定固定的条件属性 `get_condition` 进行合并

- `post['id']` 类型 `int|string` 或 `int[]|string[]`
- `post['where]` 必须为数组条件 `[['name','=','test']]`

#### 引入特性

必须定义模型名称

```php
use think\bit\traits\GetModel;

class NoBodyClass extends Base {
    use GetModel;

    protected $model = 'nobody';
}
```

可定义验证器属性 `$this->get_validate`，默认为 `['id' => 'require']`

```php
use think\bit\traits\GetModel;

class NoBodyClass extends Base {
    use GetModel;

    protected $model = 'nobody';
    protected $get_validate = [
        'id' => 'require'
        'status' => 'require',
    ];
}
```

可定义固定条件属性 `$this->get_condition`，默认为 `[]`

```php
use think\bit\traits\GetModel;

class NoBodyClass extends Base {
    use GetModel;

    protected $model = 'nobody';
    protected $get_condition = [
        ['status', '=', 1]
    ];
}
```

#### overrides __getCustomReturn()

自定义返回数据

#### $this->get_field

单条数据返回字段，默认为 `['update_time,create_time', true]`

> `$this->get_field[0]` 为指定字段，`$this->get_field[1]` 为是否排除