## GetModel 获取单个数据

GetModel 获取单条数据的通用请求处理，请求 `body` 可使用 **id** 或 **where** 字段进行查询，二者选一

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

将 **think\bit\common\GetModel** 引入，然后定义模型 **model** 的名称（即表名称）

```php
use app\system\controller\BaseController;
use think\bit\common\GetModel;

class AdminClass extends BaseController {
    use GetModel;

    protected $model = 'admin';
}
```

#### 自定义获取验证器

自定义验证器为 **get_default_validate** ，验证器与ThinkPHP验证器使用一致，默认为

```php
[
    'id' => 'require'
];
```

也可以在控制器中针对性修改

```php
use app\system\controller\BaseController;
use think\bit\common\GetModel;

class AdminClass extends BaseController {
    use GetModel;

    protected $model = 'admin';
    protected $get_default_validate = [
        'id' => 'require',
        'name' => 'require'
    ];
}
```

#### 判断是否有前置处理

如自定义前置处理，则需要继承生命周期 **think\bit\lifecycle\GetBeforeHooks**

```php
use app\system\controller\BaseController;
use think\bit\lifecycle\GetBeforeHooks;
use think\bit\common\GetModel;

class AdminClass extends BaseController implements GetBeforeHooks {
    use GetModel;

    protected $model = 'admin';

    public function getBeforeHooks(): bool
    {
        return true;
    }
}
```

**getBeforeHooks** 的返回值为 `false` 则在此结束执行，并返回 **get_before_result** 属性的值，默认为：

```php
protected $get_before_result = [
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

在生命周期函数中可以通过重写自定义前置返回

```php
use app\system\controller\BaseController;
use think\bit\lifecycle\GetBeforeHooks;
use think\bit\common\GetModel;

class AdminClass extends BaseController implements GetBeforeHooks {
    use GetModel;

    protected $model = 'admin';

    public function getBeforeHooks(): bool
    {
        $this->get_before_result = [
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
[];
```

例如加入企业主键限制

```php
use app\system\controller\BaseController;
use think\bit\common\GetModel;

class AdminClass extends BaseController {
    use GetModel;

    protected $model = 'admin';
    protected $get_condition = [
        ['enterprise', '=', 1]
    ];
}
```

#### 指定返回字段

如需要给接口指定返回字段，只需要重写 **get_field** 或 **get_without_field**，默认为

```php
$get_field = [];
$get_without_field = ['update_time', 'create_time'];
```

!> **get_field** 即指定显示字段，**get_without_field** 为排除的显示字段，二者无法共用

例如返回除 **update_time** 修改时间所有的字段

```php
use app\system\controller\BaseController;
use think\bit\common\GetModel;

class AdminClass extends BaseController {
    use GetModel;

    protected $model = 'admin';
    protected $get_without_field = ['update_time'];
}
```

#### 自定义返回结果

如自定义返回结果，则需要继承生命周期 **think\bit\lifecycle\GetCustom**

```php
use app\system\controller\BaseController;
use think\bit\lifecycle\GetCustom;
use think\bit\common\GetModel;

class AdminClass extends BaseController implements GetCustom {
    use GetModel;

    protected $model = 'admin';

    public function getCustomReturn(array $data): array
    {
        return [
            'error' => 0,
            'data' => $data
        ];
    }
}
```

**getCustomReturn** 需要返回整体的响应结果

```php
[
    'error' => 0,
    'data' => []
];
```

- **data** `array` 原数据