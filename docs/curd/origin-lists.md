## OriginListsModel 获取列表数据

OriginListsModel 列表数据的通用请求处理，请求 `body` 使用数组查询方式来定义

- **where** `array` 查询条件

!> 请求中的 **where** 还会与 **origin_lists_condition** 合并条件

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

将 **think\bit\common\OriginListsModel** 引入，然后定义模型 **model** 的名称（即表名称）

```php
use app\system\controller\BaseController;
use think\bit\common\OriginListsModel;

class AdminClass extends BaseController {
    use OriginListsModel;

    protected $model = 'admin';
}
```

#### 验证器下 origin 场景

创建验证器场景 **validate/AdminClass**， 并加入场景 `origin`

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

可定义固定条件属性 **origin_lists_condition**，默认为 `[]`

```php
use app\system\controller\BaseController;
use think\bit\common\OriginListsModel;

class NoBodyClass extends BaseController {
    use OriginListsModel;

    protected $model = 'nobody';
    protected $origin_lists_condition = [
        ['status', '=', 1]
    ];
}
```

如果接口的查询条件较为特殊，可以重写 **origin_lists_condition_query**

```php
use app\system\controller\BaseController;
use think\bit\common\OriginListsModel;
use think\App;
use think\db\Query;

class NoBodyClass extends BaseController {
    use OriginListsModel;

    protected $model = 'nobody';
    
    public function construct(App $app = null)
    {
        parent::construct($app);
        $this->origin_lists_condition_query = function (Query $query) {
            $query->whereOr([
                'type' => 1
            ]);
        };
    }
}
```

#### 判断是否有前置处理

如自定义前置处理，则需要继承生命周期 **think\bit\lifecycle\OriginListsBeforeHooks**

```php
use app\system\controller\BaseController;
use think\bit\lifecycle\OriginListsBeforeHooks;
use think\bit\common\OriginListsModel;

class AdminClass extends BaseController implements OriginListsBeforeHooks {
    use OriginListsModel;

    protected $model = 'admin';

    public function originListsBeforeHooks(): bool
    {
        return true;
    }
}
```

**originListsBeforeHooks** 的返回值为 `false` 则在此结束执行，并返回 **origin_lists_before_result** 属性的值，默认为：

```php
protected $origin_lists_before_result = [
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

在生命周期函数中可以通过重写自定义前置返回

```php
use app\system\controller\BaseController;
use think\bit\lifecycle\OriginListsBeforeHooks;
use think\bit\common\OriginListsModel;

class AdminClass extends BaseController implements OriginListsBeforeHooks {
    use OriginListsModel;

    protected $model = 'admin';

    public function originListsBeforeHooks(): bool
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
$origin_lists_condition = [];
```

例如加入企业主键限制

```php
use app\system\controller\BaseController;
use think\bit\common\OriginListsModel;

class AdminClass extends BaseController {
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
protected $origin_lists_orders = ['create_time' => 'desc'];
```

多属性排序

```php
use app\system\controller\BaseController;
use think\bit\common\OriginListsModel;

class AdminClass extends BaseController {
    use OriginListsModel;

    protected $model = 'admin';
    protected $origin_lists_orders =  ['age', 'create_time' => 'desc'];
}
```

#### 指定返回字段

如需要给接口限制返回字段，只需要重写 **origin_lists_field**，默认为

```php
protected $origin_lists_field = [];
protected $origin_lists_without_field = ['update_time', 'create_time'];
```

例如返回除 **update_time** 修改时间所有的字段

```php
use app\system\controller\BaseController;
use think\bit\common\OriginListsModel;

class AdminClass extends BaseController {
    use OriginListsModel;

    protected $model = 'admin';
    protected $origin_lists_without_field = ['update_time'];
}
```

#### 自定义返回结果

如自定义返回结果，则需要继承生命周期 **think\bit\lifecycle\OriginListsCustom**

```php
use app\system\controller\BaseController;
use think\bit\lifecycle\OriginListsCustom;
use think\bit\common\OriginListsModel;

class AdminClass extends BaseController implements OriginListsCustom {
    use OriginListsModel;

    protected $model = 'admin';

    public function originListsCustomReturn(Array $lists): array
    {
        return [
            'error' => 0,
            'data' => $lists
        ];
    }
}
```

**originListsCustomReturn** 需要返回整体的响应结果

```php
return json([
    'error' => 0,
    'data' => []
]);
```

- **data** `array` 原数据