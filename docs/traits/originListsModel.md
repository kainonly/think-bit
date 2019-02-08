## OriginListsModel

OriginListsModel 是针对列表数据的通用请求处理，支持ThinkPHP下定义的数据库

#### 周期流程

执行通用请求 -> 验证器场景 -> 条件合并 -> 通用处理 -> (是否自定义返回数据) -> 返回处理请求

> 条件合并：`post['where']` 条件会与设定固定的条件属性 `lists_origin_condition` 进行合并，检测 `post['like']` 是否存在并合并模糊搜索

- `post['where]` 必须为数组条件 `[['name','=','test']]`
- `post['like']` 模糊搜索条件，默认 `[]`
    - `field` 模糊搜索字段名
    - `value` 模糊搜索字段值
  
例如，定义发送请求中的 `post['like']`

```json
[
    {"field": "name", "value": "a"}
]
```

#### 引入特性

必须定义模型名称

```php
use think\bit\traits\OriginListsModel;

class NoBodyClass extends Base {
    use OriginListsModel;

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

可定义固定条件属性 `$this->lists_origin_condition`，默认为 `[]`

```php
use think\bit\traits\OriginListsModel;

class NoBodyClass extends Base {
    use OriginListsModel;

    protected $model = 'nobody';
    protected $lists_origin_condition = [
        ['status', '=', 1]
    ];
}
```

#### $this->lists_origin_orders

定义返回分页数据的排序，默认为 `'create_time desc'`

#### $this->lists_origin_field

列表数据返回字段，默认为 `['update_time,create_time', true]`

> `$this->lists_origin_field[0]` 为指定字段，`$this->lists_origin_field[1]` 为是否排除

#### overrides __originListsCustomReturn()

自定义列表数据返回

#### 返回数据

- `error` 响应状态
- `data` 返回列表数据
- `msg` 回馈代码