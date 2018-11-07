# ListsModel

ListsModel 是针对分页数据的通用请求处理，支持ThinkPHP下定义的数据库

#### 周期流程

执行通用请求 -> 分页验证器 -> 条件合并 -> 通用处理 -> 返回处理请求

> 条件合并：`post['where']` 条件会与设定固定的条件属性 `lists_condition` 进行合并，检测 `post['like']` 是否存在并合并模糊搜索

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
use think\bit\traits\ListsModel;

class NoBodyClass extends Base {
    use ListsModel;

    protected $model = 'nobody';
}
```

可定义固定条件属性 `$this->lists_condition`，默认为 `[]`

```php
use think\bit\traits\ListsModel;

class NoBodyClass extends Base {
    use ListsModel;

    protected $model = 'nobody';
    protected $lists_condition = [
        ['status', '=', 1]
    ];
}
```

#### $this->lists_orders

定义返回分页数据的排序，默认为 `'create_time desc'`

#### $this->lists_field

分页数据返回字段，默认为 `['update_time,create_time', true]`

> `$this->lists_field[0]` 为指定字段，`$this->lists_field[1]` 为是否排除

#### 分页参数

- `page` 分页参数
    - `limit` 分页大小
    - `index` 分页索引

#### 返回数据

- `error` 响应状态
- `data` 返回数据
    - `lists` 列表数据
    - `total` 总数
- `msg` 回馈代码