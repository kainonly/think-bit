## ListsModel

ListsModel 是针对分页数据的通用请求处理

```php
trait ListsModel
{
    public function lists()
    {
        // 通用验证
        $validate = new validate\Lists;
        if (!$validate->scene('page')->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];

        if (method_exists($this, '__listsBeforeHooks')) {
            $before_result = $this->__listsBeforeHooks();
            if (!$before_result) return $this->lists_before_result;
        }

        try {
            // 判断是否存在条件
            $condition = $this->lists_condition;
            if (isset($this->post['where'])) $condition = array_merge(
                $condition,
                $this->post['where']
            );

            // 模糊搜索
            $like = function (Query $query) {
                if (isset($this->post['like'])) foreach ($this->post['like'] as $key => $like) {
                    if (empty($like['value'])) continue;
                    $query->where($like['field'], 'like', "%{$like['value']}%");
                }
            };

            // 分页计算
            $total = Db::name($this->model)->where($condition)->where($like)->count();
            $divided = $total % $this->post['page']['limit'] == 0;
            if ($divided) $max = $total / $this->post['page']['limit'];
            else $max = ceil($total / $this->post['page']['limit']);
            if ($max == 0) $max = $max + 1;

            // 页码超出最大分页数
            if ($this->post['page']['index'] > $max) return [
                'error' => 1,
                'msg' => 'fail:page_max'
            ];

            // 分页查询
            $lists = Db::name($this->model)
                ->where($condition)
                ->where($like)
                ->field($this->lists_field[0], $this->lists_field[1])
                ->order($this->lists_orders)
                ->limit($this->post['page']['limit'])
                ->page($this->post['page']['index'])
                ->select();

            if (method_exists($this, '__listsCustomReturn')) {
                return $this->__listsCustomReturn($lists, $total);
            } else {
                return [
                    'error' => 0,
                    'data' => [
                        'lists' => $lists,
                        'total' => $total,
                    ]
                ];
            }
        } catch (Exception $e) {
            return [
                'error' => 1,
                'msg' => $e->getMessage()
            ];
        }
    }
}
```

!> 条件选择：如果 **post** 请求中存在参数 **id**，那么 **where** 的存在将成为附加条件，如果 **id** 不存在，那么可以使用 **where** 为主要条件

- **id** `int|string` or `int[]|string[]`
- **where** `array`，必须使用数组方式来定义

```php
$this->post['where'] = [
    ['name', '=', 'van']
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

如需要给接口在后端就设定固定条件，只需要重写 **get_condition**，默认为

```php
protected $get_condition = [];
```

例如加入企业主键限制

```php
use think\bit\traits\ListsModel;

class AdminClass extends Base {
    use ListsModel;

    protected $model = 'admin';
    protected $get_condition = [
        ['enterprise', '=', 1]
    ];
}
```

#### 限制返回字段

如需要给接口限制返回字段，只需要重写 **get_field**，默认为

```php
protected $get_field = ['update_time,create_time', true];
```

例如返回除 **update_time** 修改时间所有的字段

```php
use think\bit\traits\ListsModel;

class AdminClass extends Base {
    use ListsModel;

    protected $model = 'admin';
    protected $get_field = ['update_time', true];
}
```

#### 自定义返回结果

如自定义返回结果，则需要调用生命周期 **GetCustom**

```php
use think\bit\traits\ListsModel;

class AdminClass extends Base implements GetCustom {
    use ListsModel;

    protected $model = 'admin';

    public function __getCustomReturn($data)
    {
        return [
            'error' => 0,
            'data' => $data
        ];
    }
}
```

**__getCustomReturn** 需要返回整体的响应结果

```php
return [
    'error' => 0,
    'data' => $data
];
```

- **data** `array` 原数据