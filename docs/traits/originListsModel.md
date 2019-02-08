## OriginListsModel 获取列表数据

OriginListsModel 是针对列表数据的通用请求处理

```php
trait OriginListsModel
{
    public function originLists()
    {
        // 通用验证
        $validate = new validate\Lists;
        if (!$validate->scene('origin')->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];

        if (method_exists($this, '__originListsBeforeHooks')) {
            $before_result = $this->__originListsBeforeHooks();
            if (!$before_result) return $this->lists_origin_before_result;
        }

        try {
            // 是否存在条件
            $condition = $this->lists_origin_condition;
            if (isset($this->post['where'])) $condition = array_merge(
                $condition, $this->post['where']
            );

            // 模糊搜索
            $like = function (Query $query) {
                if (isset($this->post['like'])) foreach ($this->post['like'] as $key => $like) {
                    if (empty($like['value'])) continue;
                    $query->where($like['field'], 'like', "%{$like['value']}%");
                }
            };

            // 执行查询
            $lists = Db::name($this->model)
                ->where($condition)
                ->where($like)
                ->field($this->lists_origin_field[0], $this->lists_origin_field[1])
                ->order($this->lists_origin_orders)
                ->select();

            // 是否自定义返回
            if (method_exists($this, '__originListsCustomReturn')) {
                return $this->__originListsCustomReturn($lists);
            } else {
                return [
                    'error' => 0,
                    'data' => $lists
                ];
            }
        } catch (Exception $e) {
            return [
                'error' => 1,
                'msg' => (string)$e->getMessage()
            ];
        }
    }
}
```

!> 条件合并: 如果 **post** 请求中存在参数 **where**，那么它将于 **lists_origin_condition** 固定条件合并

- **where** `array` 必须使用数组方式来定义

```php
$this->post['where'] = [
    ['name', '=', 'van']
];
```

!> 模糊查询：在 **post** 请求中加入参数 **like**，他将于以上条件共同合并

- **like** `array` 模糊搜索条件
  - **field** 模糊搜索字段名
  - **value** 模糊搜索字段值

```json
[
    {"field": "name", "value": "a"}
]
```

#### 引入特性

需要定义必须的操作模型 **model**

```php
use think\bit\traits\OriginListsModel;

class AdminClass extends Base {
    use OriginListsModel;

    protected $model = 'admin';
}
```

#### 合并模型验证器下origin场景

所以需要对应创建验证器场景 **validate/AdminClass**， 并加入场景 `origin`

```php
use think\Validate;

class AdminClass extends Validate
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

#### 判断是否有前置处理

如自定义前置处理，则需要调用生命周期 **OriginListsBeforeHooks**

```php
use think\bit\traits\OriginListsModel;
use think\bit\lifecycle\OriginListsBeforeHooks;

class AdminClass extends Base implements OriginListsBeforeHooks {
    use OriginListsModel;

    protected $model = 'admin';

    public function __originListsBeforeHooks()
    {
        return true;
    }
}
```

**__originListsBeforeHooks** 的返回值为 `false` 则在此结束执行，并返回 **lists_origin_before_result** 属性的值，默认为：

```php
protected $lists_origin_before_result = [
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

在生命周期函数中可以通过重写自定义前置返回

```php
use think\bit\traits\OriginListsModel;
use think\bit\lifecycle\OriginListsBeforeHooks;

class AdminClass extends Base implements OriginListsBeforeHooks {
    use OriginListsModel;

    protected $model = 'admin';

    public function __originListsBeforeHooks()
    {
        $this->lists_origin_before_result = [
            'error'=> 1,
            'msg'=> 'error:only'
        ];
        return false;
    }
}
```

#### 固定条件

如需要给接口在后端就设定固定条件，只需要重写 **lists_origin_condition**，默认为

```php
protected $lists_origin_condition = [];
```

例如加入企业主键限制

```php
use think\bit\traits\OriginListsModel;

class AdminClass extends Base {
    use OriginListsModel;

    protected $model = 'admin';
    protected $lists_origin_condition = [
        ['enterprise', '=', 1]
    ];
}
```

#### 列表排序

如果需要列表按条件排序，只需要重写 **lists_origin_orders**，默认为

```php
protected $lists_origin_orders = 'create_time desc';
```

例如按年龄进行排序

```php
use think\bit\traits\OriginListsModel;

class AdminClass extends Base {
    use OriginListsModel;

    protected $model = 'admin';
    protected $lists_origin_orders = 'age desc';
}
```

#### 限制返回字段

如需要给接口限制返回字段，只需要重写 **lists_origin_field**，默认为

```php
protected $lists_origin_field = ['update_time,create_time', true];
```

例如返回除 **update_time** 修改时间所有的字段

```php
use think\bit\traits\OriginListsModel;

class AdminClass extends Base {
    use OriginListsModel;

    protected $model = 'admin';
    protected $lists_origin_field = ['update_time', true];
}
```

#### 自定义返回结果

如自定义返回结果，则需要调用生命周期 **OriginListsCustom**

```php
use think\bit\traits\OriginListsModel;
use think\bit\lifecycle\OriginListsCustom;

class AdminClass extends Base implements OriginListsCustom {
    use OriginListsModel;

    protected $model = 'admin';

    public function __originListsCustomReturn(Array $lists)
    {
        return [
            'error' => 0,
            'data' => $lists
        ];
    }
}
```

**__originListsCustomReturn** 需要返回整体的响应结果

```php
return [
    'error' => 0,
    'data' => $data
];
```

- **data** `array` 原数据