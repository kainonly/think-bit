## DeleteModel 删除数据

DeleteModel 是针对删除数据的通用请求处理，执行周期为：

```php
trait DeleteModel
{
    public function delete()
    {
        $validate = Validate::make($this->delete_default_validate);
        if (!$validate->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];

        if (method_exists($this, '__deleteBeforeHooks') &&
            !$this->__deleteBeforeHooks()) {
            return $this->delete_before_result;
        }

        return !Db::transaction(function () {
            if (method_exists($this, '__deletePrepHooks') &&
                !$this->__deletePrepHooks()) {
                $this->delete_fail_result = $this->delete_prep_result;
                return false;
            }

            $condition = $this->delete_condition;
            if (isset($this->post['id'])) $result = Db::name($this->model)
                ->whereIn('id', $this->post['id'])
                ->where($condition)
                ->delete();
            else $result = Db::name($this->model)
                ->where($this->post['where'])
                ->where($condition)
                ->delete();

            if (!$result) {
                Db::rollBack();
                return false;
            }

            if (method_exists($this, '__deleteAfterHooks') &&
                !$this->__deleteAfterHooks()) {
                $this->delete_fail_result = $this->delete_after_result;
                Db::rollBack();
                return false;
            }

            return true;
        }) ? $this->delete_fail_result : [
            'error' => 0,
            'msg' => 'ok'
        ];
    }
}
```

!> 条件查询：请求可使用 **id** 或 **where** 字段进行查询，二者选一即可

- **id** `int|string`
- **where** `array`，必须使用数组方式来定义

```php
$this->post['where'] = [
    ['name', '=', 'van']
];
```

#### 引入特性

需要定义必须的操作模型 **model**

```php
use think\bit\traits\DeleteModel;

class AdminClass extends Base {
    use DeleteModel;

    protected $model = 'admin';
}
```

#### 自定义删除验证器

自定义删除验证器为 **delete_validate**，默认为

```php
protected $delete_validate = [
    'id' => 'require'
];
```

也可以在控制器中针对性修改

```php
use think\bit\traits\DeleteModel;

class AdminClass extends Base {
    use DeleteModel;

    protected $model = 'admin';
    protected $delete_validate = [
        'id' => 'require',
        'name' => 'require'
    ];
}
```

#### 判断是否有前置处理

如自定义前置处理，则需要调用生命周期 **DeleteBeforeHooks**

```php
use think\bit\traits\DeleteModel;
use think\bit\lifecycle\DeleteBeforeHooks;

class AdminClass extends Base implements DeleteBeforeHooks {
    use DeleteModel;

    protected $model = 'admin';

    public function __deleteBeforeHooks()
    {
        return true;
    }
}
```

**__deleteBeforeHooks** 的返回值为 `false` 则在此结束执行，并返回 **delete_before_result** 属性的值，默认为：

```php
protected $delete_before_result = [
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

在生命周期函数中可以通过重写自定义前置返回

```php
use think\bit\traits\DeleteModel;
use think\bit\lifecycle\DeleteBeforeHooks;

class AdminClass extends Base implements DeleteBeforeHooks {
    use DeleteModel;

    protected $model = 'admin';

    public function __deleteBeforeHooks()
    {
        $this->delete_before_result = [
            'error'=> 1,
            'msg'=> 'error:only'
        ];
        return false;
    }
}
```

#### 判断是否有存在事务之后模型写入之前的处理

如该周期处理，则需要调用生命周期 **DeletePrepHooks**

```php
use think\bit\traits\DeleteModel;
use think\bit\lifecycle\DeletePrepHooks;

class AdminClass extends Base implements DeletePrepHooks {
    use DeleteModel;

    protected $model = 'admin';

    public function __deletePrepHooks()
    {
        return true;
    }
}
```

**__deletePrepHooks** 的返回值为 `false` 则在此结束执行进行事务回滚，并返回 **delete_prep_result** 属性的值，默认为：

```php
protected $delete_prep_result = [
    'error' => 1,
    'msg' => 'error:prep_fail'
];
```

在生命周期函数中可以通过重写自定义返回

```php
use think\bit\traits\DeleteModel;
use think\bit\lifecycle\DeletePrepHooks;

class AdminClass extends Base implements DeletePrepHooks {
    use DeleteModel;

    protected $model = 'admin';

    public function __deletePrepHooks()
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

如自定义后置处理，则需要调用生命周期 **DeleteAfterHooks**

```php
use think\bit\traits\DeleteModel;
use think\bit\lifecycle\DeleteAfterHooks;

class AdminClass extends Base implements DeleteAfterHooks {
    use DeleteModel;

    protected $model = 'admin';

    public function __deleteAfterHooks()
    {
        return true;
    }
}
```

**__deleteAfterHooks** 的返回值为 `false` 则在此结束执行进行事务回滚，并返回 **delete_after_result** 属性的值，默认为：

```php
protected $delete_after_result = [
    'error' => 1,
    'msg' => 'error:after_fail'
];
```

在生命周期函数中可以通过重写自定义后置返回

```php
use think\bit\traits\DeleteModel;
use think\bit\lifecycle\DeleteAfterHooks;

class AdminClass extends Base implements DeleteAfterHooks {
    use DeleteModel;

    protected $model = 'admin';

    public function __deleteAfterHooks()
    {
        $this->delete_after_result = [
            'error'=> 1,
            'msg'=> 'error:redis'
        ];
        return false;
    }
}
```