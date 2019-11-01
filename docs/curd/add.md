## AddModel 新增数据

AddModel 是针对新增数据的通用请求处理

#### 初始化

将 **think\bit\common\AddModel** 引入，然后定义模型 **model** 的名称（即表名称）

```php
use think\bit\common\AddModel;

class AdminClass extends Base {
    use AddModel;

    protected $model = 'admin';
}
```

#### 验证器下 add 场景

创建验证器场景 **validate/AdminClass**， 并加入场景 `add`

```php
use think\Validate;

class AdminClass extends Validate
{
    protected $rule = [
        'name' => 'require',
    ];

    protected $scene = [
        'add' => ['name'],
    ];
}
```

#### 判断是否有前置处理

如自定义前置处理（发生在验证之后与数据写入之前），则需要继承生命周期 **think\bit\lifecycle\AddBeforeHooks**

```php
use think\bit\common\AddModel;
use think\bit\lifecycle\AddBeforeHooks;

class AdminClass extends Base implements AddBeforeHooks {
    use AddModel;

    protected $model = 'admin';

    public function __addBeforeHooks()
    {
        return true;
    }
}
```

**__addBeforeHooks** 的返回值为 `false` 则在此结束执行，并返回 **add_before_result** 属性的值，默认为：

```php
protected $add_before_result = [
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

在生命周期函数中可以通过重写自定义前置返回

```php
use think\bit\common\AddModel;
use think\bit\lifecycle\AddBeforeHooks;

class AdminClass extends Base implements AddBeforeHooks {
    use AddModel;

    protected $model = 'admin';

    public function __addBeforeHooks()
    {
        $this->add_before_result = [
            'error'=> 1,
            'msg'=> 'error:only'
        ];
        return false;
    }
}
```

#### 判断是否有后置处理

如自定义后置处理（发生在写入成功之后与提交事务之前），则需要调用生命周期 **think\bit\lifecycle\AddAfterHooks**

```php
use think\bit\common\AddModel;
use think\bit\lifecycle\AddAfterHooks;

class AdminClass extends Base implements AddAfterHooks {
    use AddModel;

    protected $model = 'admin';

    public function __addAfterHooks($pk)
    {
        return true;
    }
}
```

**pk** 为模型写入后返回的主键，**__addAfterHooks** 的返回值为 `false` 则在此结束执行进行事务回滚，并返回 **add_after_result** 属性的值，默认为：

```php
protected $add_after_result = [
    'error' => 1,
    'msg' => 'error:after_fail'
];
```

在生命周期函数中可以通过重写自定义后置返回

```php
use think\bit\common\AddModel;
use think\bit\lifecycle\AddAfterHooks;

class AdminClass extends Base implements AddAfterHooks {
    use AddModel;

    protected $model = 'admin';

    public function __addAfterHooks($pk)
    {
        $this->add_after_result = [
            'error'=> 1,
            'msg'=> 'error:redis'
        ];
        return false;
    }
}
```