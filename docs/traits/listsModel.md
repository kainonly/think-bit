## ListsModel 获取分页数据

ListsModel 是针对分页数据的通用请求处理

```php
trait ListsModel
{
    public function lists()
    {
        $validate = validate($this->lists_default_validate);
        if (!$validate->check($this->post)) {
            return [
                'error' => 1,
                'msg' => $validate->getError()
            ];
        }

        if (method_exists($this, '__listsBeforeHooks') &&
            !$this->__listsBeforeHooks()) {
            return $this->lists_before_result;
        }

        try {
            $condition = $this->lists_condition;
            if (isset($this->post['where'])) {
                $condition = array_merge(
                    $condition,
                    $this->post['where']
                );
            }

            $orders = $this->lists_orders;
            if (isset($this->post['order'])) {
                $condition = array_merge(
                    $orders,
                    $this->post['order']
                );
            }

            $totalQuery = Db::name($this->model)
                ->where($condition);

            $total = empty($this->lists_condition_query) ?
                $totalQuery->count() :
                $totalQuery->where($this->lists_condition_query)->count();

            $listsQuery = Db::name($this->model)
                ->where($condition)
                ->field($this->lists_field)
                ->withoutField($this->lists_without_field)
                ->order($orders)
                ->limit($this->post['page']['limit'])
                ->page($this->post['page']['index']);

            if (empty($this->lists_condition_query)) {
                $lists = $listsQuery
                    ->select();
            } else {
                $lists = $listsQuery
                    ->where($this->lists_condition_query)
                    ->select();
            }

            if (method_exists($this, '__listsCustomReturn')) {
                return $this->__listsCustomReturn($lists, $total);
            } else {
                return [
                    'error' => 0,
                    'data' => [
                        'lists' => $lists->toArray(),
                        'total' => $total
                    ]
                ];
            }
        } catch (\Exception $e) {
            return [
                'error' => 1,
                'msg' => $e->getMessage()
            ];
        }
    }
}
```

- **where** `array` 必须使用数组方式来定义

!> 条件合并: 请求中的 **where** 将于 **lists_condition** 合并

```php
// 正常情况
$this->post['where'] = [
    ['name', '=', 'kain']
];

// 模糊搜索
$this->post['where'] = [
    ['name', 'like', '%v%']
];

// JSON 查询
$this->post['where'] = [
    ['extra->sex', '=', 0]
];
```

#### 引入特性

需要定义必须的操作模型 **model**

```php
use think\bit\traits\ListsModel;

class AdminClass extends Base {
    use ListsModel;

    protected $model = 'admin';
}
```

#### 判断是否有前置处理

如自定义前置处理，则需要调用生命周期 **ListsBeforeHooks**

```php
use think\bit\traits\ListsModel;
use think\bit\lifecycle\ListsBeforeHooks;

class AdminClass extends Base implements ListsBeforeHooks {
    use ListsModel;

    protected $model = 'admin';

    public function __listsBeforeHooks()
    {
        return true;
    }
}
```

**__listsBeforeHooks** 的返回值为 `false` 则在此结束执行，并返回 **lists_before_result** 属性的值，默认为：

```php
protected $lists_before_result = [
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

在生命周期函数中可以通过重写自定义前置返回

```php
use think\bit\traits\ListsModel;
use think\bit\lifecycle\ListsBeforeHooks;

class AdminClass extends Base implements ListsBeforeHooks {
    use ListsModel;

    protected $model = 'admin';

    public function __listsBeforeHooks()
    {
        $this->lists_before_result = [
            'error'=> 1,
            'msg'=> 'error:only'
        ];
        return false;
    }
}
```

#### 固定条件

如需要给接口在后端就设定固定条件，只需要重写 **lists_condition**，默认为

```php
protected $lists_condition = [];
```

例如加入企业主键限制

```php
use think\bit\traits\ListsModel;

class AdminClass extends Base {
    use ListsModel;

    protected $model = 'admin';
    protected $lists_condition = [
        ['enterprise', '=', 1]
    ];
}
```

如果接口的查询条件较为特殊，可以重写 **lists_condition_query**

```php
use think\bit\traits\ListsModel;

class AdminClass extends Base {
    use ListsModel;

    protected $model = 'admin';
    
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->lists_condition_query = function (Query $query) {
            $query->whereOr([
                'type' => 1
            ]);
        };
    }
}
```

#### 列表排序

如果需要列表按条件排序，只需要重写 **lists_orders**，默认为

```php
protected $lists_orders = ['create_time' => 'desc'];
```

多属性排序

```php
use think\bit\traits\ListsModel;

class AdminClass extends Base {
    use ListsModel;

    protected $model = 'admin';
    protected $lists_orders = ['age', 'create_time' => 'desc'];
}
```

#### 指定返回字段

如需要给接口限制返回字段，只需要重写 **lists_field** 或 **lists_without_field**，默认为

```php
protected $lists_field = [];
protected $lists_without_field = ['update_time', 'create_time'];
```

例如返回除 **update_time** 修改时间所有的字段

```php
use think\bit\traits\ListsModel;

class AdminClass extends Base {
    use ListsModel;

    protected $model = 'admin';
    protected $lists_without_field = ['update_time'];
}
```

#### 自定义返回结果

如自定义返回结果，则需要调用生命周期 **ListsCustom**

```php
use think\bit\traits\ListsModel;
use think\bit\lifecycle\ListsCustom;

class AdminClass extends Base implements ListsCustom {
    use ListsModel;

    protected $model = 'admin';

    public function __listsCustomReturn(Array $lists, int $total)
    {
        return json([
            'error' => 0,
            'data' => [
                'lists' => $lists,
                'total' => $total,
            ]
        ]);
    }
}
```

**__listsCustomReturn** 需要返回整体的响应结果

```php
return json([
    'error' => 0,
    'data' => [
        'lists' => $lists,
        'total' => $total,
    ]
]);
```

- **data** `array` 原数据