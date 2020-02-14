## ListsModel 获取分页数据

ListsModel 分页数据的通用请求处理，请求 `body` 使用数组查询方式来定义

- **where** `array` 查询条件

!> 请求中的 **where** 还会与 **lists_condition** 合并条件

**where** 必须使用数组查询方式来定义，例如

```json
{
    "where":[
        ["name", "=", "kain"]
    ]
}
```

如果条件中包含模糊查询

```json
{
    "where":[
        ["name", "like", "%v%"]
    ]
}
```

如果查询条件为 JSON 

```json
{
    "where":[
        ["extra->nickname", "=", "kain"]
    ]
}
```

#### 初始化

将 **think\bit\common\ListsModel** 引入，然后定义模型 **model** 的名称（即表名称）

```php
use app\system\controller\BaseController;
use think\bit\common\ListsModel;

class AdminClass extends BaseController {
    use ListsModel;

    protected $model = 'admin';
}
```

#### 判断是否有前置处理

如自定义前置处理，则需要调用生命周期 **think\bit\lifecycle\ListsBeforeHooks**

```php
use app\system\controller\BaseController;use think\bit\common\ListsModel;
use think\bit\lifecycle\ListsBeforeHooks;

class AdminClass extends BaseController implements ListsBeforeHooks {
    use ListsModel;

    protected $model = 'admin';

    public function listsBeforeHooks(): bool
    {
        return true;
    }
}
```

**listsBeforeHooks** 的返回值为 `false` 则在此结束执行，并返回 **lists_before_result** 属性的值，默认为：

```php
$lists_before_result = [
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

在生命周期函数中可以通过重写自定义前置返回

```php
use app\system\controller\BaseController;
use think\bit\lifecycle\ListsBeforeHooks;
use think\bit\common\ListsModel;

class AdminClass extends BaseController implements ListsBeforeHooks {
    use ListsModel;

    protected $model = 'admin';

    public function listsBeforeHooks(): bool
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
$lists_condition = [];
```

例如加入企业主键限制

```php
use app\system\controller\BaseController;
use think\bit\common\ListsModel;

class AdminClass extends BaseController {
    use ListsModel;

    protected $model = 'admin';
    protected $lists_condition = [
        ['enterprise', '=', 1]
    ];
}
```

如果接口的查询条件较为特殊，可以重写 **lists_condition_query**

```php
use app\system\controller\BaseController;
use think\bit\common\ListsModel;
use think\App;
use think\db\Query;

class AdminClass extends BaseController {
    use ListsModel;

    protected $model = 'admin';
    
    public function construct(App $app = null)
    {
        parent::construct($app);
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
$lists_orders = ['create_time' => 'desc'];
```

多属性排序

```php
use app\system\controller\BaseController;
use think\bit\common\ListsModel;

class AdminClass extends BaseController {
    use ListsModel;

    protected $model = 'admin';
    protected $lists_orders = ['age', 'create_time' => 'desc'];
}
```

#### 指定返回字段

如需要给接口限制返回字段，只需要重写 **lists_field** 或 **lists_without_field**，默认为

```php
$lists_field = [];
$lists_without_field = ['update_time', 'create_time'];
```

例如返回除 **update_time** 修改时间所有的字段

```php
use app\system\controller\BaseController;
use think\bit\common\ListsModel;

class AdminClass extends BaseController {
    use ListsModel;

    protected $model = 'admin';
    protected $lists_without_field = ['update_time'];
}
```

#### 自定义返回结果

如自定义返回结果，则需要继承生命周期 **think\bit\lifecycle\ListsCustom**

```php
use app\system\controller\BaseController;
use think\bit\lifecycle\ListsCustom;
use think\bit\common\ListsModel;

class AdminClass extends BaseController implements ListsCustom {
    use ListsModel;

    protected $model = 'admin';

    public function listsCustomReturn(Array $lists, int $total): array 
    {
        return [
            'error' => 0,
            'data' => [
                'lists' => $lists,
                'total' => $total,
            ]
        ];
    }
}
```

**listsCustomReturn** 需要返回整体的响应结果

```php
return [
    'error' => 0,
    'data' => [
        'lists' => [],
        'total' => [],
    ]
];
```

- **data** `array` 原数据