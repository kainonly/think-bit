## DeleteModel 删除数据

DeleteModel 删除数据的通用请求处理，请求 `body` 可使用 **id** 或 **where** 字段进行查询，二者选一

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

将 **think\bit\common\DeleteModel** 引入，然后定义模型 **model** 的名称（即表名称）

```php
use app\system\controller\BaseController;
use think\bit\common\DeleteModel;

class AdminClass extends BaseController {
    use DeleteModel;

    protected $model = 'admin';
}
```

#### 自定义删除验证器

自定义删除验证器为 **delete_validate**，默认为

```php
[
    'id' => 'require'
];
```

也可以在控制器中针对性修改

```php
use app\system\controller\BaseController;
use think\bit\common\DeleteModel;

class AdminClass extends BaseController {
    use DeleteModel;

    protected $model = 'admin';
    protected $delete_validate = [
        'id' => 'require',
        'name' => 'require'
    ];
}
```

#### 判断是否有前置处理

如自定义前置处理（发生在验证之后与数据删除之前），则需要继承生命周期 **think\bit\lifecycle\DeleteBeforeHooks**

```php
use app\system\controller\BaseController;
use think\bit\lifecycle\DeleteBeforeHooks;
use think\bit\common\DeleteModel;

class AdminClass extends BaseController implements DeleteBeforeHooks {
    use DeleteModel;

    protected $model = 'admin';

    public function deleteBeforeHooks(): bool
    {
        return true;
    }
}
```

**deleteBeforeHooks** 的返回值为 `false` 则在此结束执行，并返回 **delete_before_result** 属性的值，默认为：

```php
[
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

在生命周期函数中可以通过重写自定义前置返回

```php
use app\system\controller\BaseController;
use think\bit\lifecycle\DeleteBeforeHooks;
use think\bit\common\DeleteModel;

class AdminClass extends BaseController implements DeleteBeforeHooks {
    use DeleteModel;

    protected $model = 'admin';

    public function deleteBeforeHooks(): bool
    {
        $this->delete_before_result = [
            'error'=> 1,
            'msg'=> 'error:only'
        ];
        return false;
    }
}
```

#### 判断是否有存在事务开始之后与数据删除之前的处理

如该周期处理，则需要继承生命周期 **think\bit\lifecycle\DeletePrepHooks**

```php
use app\system\controller\BaseController;
use think\bit\lifecycle\DeletePrepHooks;
use think\bit\common\DeleteModel;

class AdminClass extends BaseController implements DeletePrepHooks {
    use DeleteModel;

    protected $model = 'admin';

    public function deletePrepHooks(): bool
    {
        return true;
    }
}
```

**deletePrepHooks** 的返回值为 `false` 则在此结束执行进行事务回滚，并返回 **delete_prep_result** 属性的值，默认为：

```php
[
    'error' => 1,
    'msg' => 'error:prep_fail'
];
```

在生命周期函数中可以通过重写自定义返回

```php
use app\system\controller\BaseController;
use think\bit\lifecycle\DeletePrepHooks;
use think\bit\common\DeleteModel;

class AdminClass extends BaseController implements DeletePrepHooks {
    use DeleteModel;

    protected $model = 'admin';

    public function deletePrepHooks(): bool
    {
        $this->delete_prep_result = [
            'error'=> 1,
            'msg'=> 'error:insert'
        ];
        return false;
    }
}
```

#### 判断是否有后置处理

如自定义后置处理（发生在数据删除成功之后与提交事务之前），则需要继承生命周期 **think\bit\lifecycle\DeleteAfterHooks**

```php
use app\system\controller\BaseController;
use think\bit\lifecycle\DeleteAfterHooks;
use think\bit\common\DeleteModel;

class AdminClass extends BaseController implements DeleteAfterHooks {
    use DeleteModel;

    protected $model = 'admin';

    public function deleteAfterHooks(): bool
    {
        return true;
    }
}
```

**deleteAfterHooks** 的返回值为 `false` 则在此结束执行进行事务回滚，并返回 **delete_after_result** 属性的值，默认为：

```php
[
    'error' => 1,
    'msg' => 'error:after_fail'
];
```

在生命周期函数中可以通过重写自定义后置返回

```php
use app\system\controller\BaseController;
use think\bit\lifecycle\DeleteAfterHooks;
use think\bit\common\DeleteModel;

class AdminClass extends BaseController implements DeleteAfterHooks {
    use DeleteModel;

    protected $model = 'admin';

    public function deleteAfterHooks(): bool
    {
        $this->delete_after_result = [
            'error'=> 1,
            'msg'=> 'error:redis'
        ];
        return false;
    }
}
```