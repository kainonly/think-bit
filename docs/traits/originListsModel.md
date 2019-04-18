## OriginListsModel 获取列表数据

OriginListsModel 是针对列表数据的通用请求处理

```php
trait OriginListsModel
{
    public function originLists()
    {
        $validate = Validate::make($this->origin_lists_default_validate);
        if (!$validate->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];

        if (method_exists($this, '__originListsBeforeHooks') &&
            !$this->__originListsBeforeHooks()) {
            return $this->origin_lists_before_result;
        }

        try {
            $condition = $this->origin_lists_condition;
            if (isset($this->post['where'])) $condition = array_merge(
                $condition,
                $this->post['where']
            );

            $lists = Db::name($this->model)
                ->where($condition)
                ->field($this->origin_lists_field[0], $this->origin_lists_field[1])
                ->order($this->origin_lists_orders)
                ->select();

            return method_exists($this, '__originListsCustomReturn') ? $this->__originListsCustomReturn($lists) : [
                'error' => 0,
                'data' => $lists
            ];
        } catch (Exception $e) {
            return [
                'error' => 1,
                'msg' => (string)$e->getMessage()
            ];
        }
    }
}
```

!> 条件合并: 请求中的 **where** 将于 **origin_lists_condition** 合并

- **where** `array` 必须使用数组方式来定义

```php
$this->post['where'] = [
    ['name', 'like', '%v%']
];
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

可定义固定条件属性 `$this->origin_lists_condition`，默认为 `[]`

```php
use think\bit\traits\OriginListsModel;

class NoBodyClass extends Base {
    use OriginListsModel;

    protected $model = 'nobody';
    protected $origin_lists_condition = [
        ['status', '=', 1]
    ];
}
```

如果接口的查询条件较为特殊，可以重写 **origin_lists_condition_query**

```php
use think\bit\traits\OriginListsModel;

class NoBodyClass extends Base {
    use OriginListsModel;

    protected $model = 'nobody';
    
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->origin_lists_condition_query = function (Query $query) {
            $query->whereOr([
                'type' => 1
            ]);
        };
    }
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

**__originListsBeforeHooks** 的返回值为 `false` 则在此结束执行，并返回 **origin_lists_before_result** 属性的值，默认为：

```php
protected $origin_lists_before_result = [
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
        $this->origin_lists_before_result = [
            'error'=> 1,
            'msg'=> 'error:only'
        ];
        return false;
    }
}
```

#### 固定条件

如需要给接口在后端就设定固定条件，只需要重写 **origin_lists_condition**，默认为

```php
protected $origin_lists_condition = [];
```

例如加入企业主键限制

```php
use think\bit\traits\OriginListsModel;

class AdminClass extends Base {
    use OriginListsModel;

    protected $model = 'admin';
    protected $origin_lists_condition = [
        ['enterprise', '=', 1]
    ];
}
```

#### 列表排序

如果需要列表按条件排序，只需要重写 **origin_lists_orders**，默认为

```php
protected $origin_lists_orders = 'create_time desc';
```

例如按年龄进行排序

```php
use think\bit\traits\OriginListsModel;

class AdminClass extends Base {
    use OriginListsModel;

    protected $model = 'admin';
    protected $origin_lists_orders = 'age desc';
}
```

#### 限制返回字段

如需要给接口限制返回字段，只需要重写 **origin_lists_field**，默认为

```php
protected $origin_lists_field = ['update_time,create_time', true];
```

例如返回除 **update_time** 修改时间所有的字段

```php
use think\bit\traits\OriginListsModel;

class AdminClass extends Base {
    use OriginListsModel;

    protected $model = 'admin';
    protected $origin_lists_field = ['update_time', true];
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