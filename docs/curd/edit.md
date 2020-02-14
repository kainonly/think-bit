## EditModel 编辑数据

EditModel 修改数据的通用请求处理，请求 `body` 可使用 **id** 或 **where** 字段进行查询，二者选一

- **id** `int|string` 主键
- **where** `array` 查询条件

**where** 必须使用数组查询方式来定义，例如

```json
{
    "where":[
        ["name", "=", "van"]
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

将 **think\bit\common\EditModel** 引入，然后定义模型 **model** 的名称（即表名称）

```php
use app\system\controller\BaseController;
use think\bit\common\EditModel;

class AdminClass extends BaseController {
    use EditModel;

    protected $model = 'admin';
}
```

#### 自定义修改验证器

自定义删除验证器为 **edit_default_validate**，默认为

```php
[
    'id' => 'require',
    'switch' => 'bool'
];
```

也可以在控制器中针对性修改

```php
use app\system\controller\BaseController;
use think\bit\common\EditModel;

class AdminClass extends BaseController {
    use EditModel;

    protected $model = 'admin';
    protected $edit_default_validate = [
        'id' => 'require',
        'switch' => 'bool',
        'status' => 'require',
    ];
}
```

#### 验证器下 edit 场景

应创建验证器场景 **validate/AdminClass**，**edit_switch** 为 `false` 下有效， 并加入场景 `edit`

```php
use think\Validate;

class AdminClass extends Validate
{
    protected $rule = [
        'name' => 'require',
    ];

    protected $scene = [
        'edit' => ['name'],
    ];
}
```

#### 判断是否有前置处理

如自定义前置处理（发生在验证之后与数据写入之前），则需要继承生命周期 **think\bit\lifecycle\EditBeforeHooks**

```php
use app\system\controller\BaseController;
use think\bit\lifecycle\EditBeforeHooks;
use think\bit\common\EditModel;

class AdminClass extends BaseController implements EditBeforeHooks {
    use EditModel;

    protected $model = 'admin';

    public function editBeforeHooks() :bool 
    {
        return true;
    }
}
```

**editBeforeHooks** 的返回值为 `false` 则在此结束执行，并返回 **edit_before_result** 属性的值，默认为：

```php
[
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

在生命周期函数中可以通过重写自定义前置返回

```php
use app\system\controller\BaseController;
use think\bit\lifecycle\EditBeforeHooks;
use think\bit\common\EditModel;

class AdminClass extends BaseController implements EditBeforeHooks {
    use EditModel;

    protected $model = 'admin';

    public function editBeforeHooks(): bool
    {
        $this->edit_before_result = [
            'error'=> 1,
            'msg'=> 'error:only'
        ];
        return false;
    }
}
```

#### 判断是否有后置处理

如自定义后置处理（发生在写入成功之后与提交事务之前），则需要继承生命周期 **think\bit\lifecycle\EditAfterHooks**

```php
use app\system\controller\BaseController;
use think\bit\lifecycle\EditAfterHooks;
use think\bit\common\EditModel;

class AdminClass extends BaseController implements EditAfterHooks {
    use EditModel;

    protected $model = 'admin';

    public function editAfterHooks(): bool
    {
        return true;
    }
}
```

**editAfterHooks** 的返回值为 `false` 则在此结束执行进行事务回滚，并返回 **edit_after_result** 属性的值，默认为：

```php
[
    'error' => 1,
    'msg' => 'error:after_fail'
];
```

在生命周期函数中可以通过重写自定义后置返回

```php
use app\system\controller\BaseController;
use think\bit\lifecycle\EditAfterHooks;
use think\bit\common\EditModel;

class AdminClass extends BaseController implements EditAfterHooks {
    use EditModel;

    protected $model = 'admin';

    public function editAfterHooks(): bool
    {
        $this->edit_after_result = [
            'error'=> 1,
            'msg'=> 'error:redis'
        ];
        return false;
    }
}
```