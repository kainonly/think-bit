## EditModel 编辑数据

EditModel 是针对修改数据的通用请求处理

```php
trait EditModel
{
    public function edit()
    {
        $validate = Validate::make($this->edit_default_validate);
        if (!$validate->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];

        $this->edit_switch = $this->post['switch'];
        if (!$this->edit_switch) {
            $validate = validate($this->model);
            if (!$validate->scene('edit')->check($this->post)) return [
                'error' => 1,
                'msg' => $validate->getError()
            ];
        }

        unset($this->post['switch']);
        $this->post['update_time'] = time();

        if (method_exists($this, '__editBeforeHooks') &&
            !$this->__editBeforeHooks()) {
            return $this->edit_before_result;
        }

        return !Db::transaction(function () {
            $condition = $this->edit_condition;

            if (isset($this->post['id'])) array_push(
                $condition,
                ['id', '=', $this->post['id']]
            ); else $condition = array_merge(
                $condition,
                $this->post['where']
            );

            unset($this->post['where']);
            $result = Db::name($this->model)->where($condition)->update($this->post);

            if (!$result) return false;
            if (method_exists($this, '__editAfterHooks') &&
                !$this->__editAfterHooks()) {
                $this->edit_fail_result = $this->edit_after_result;
                Db::rollBack();
                return false;
            }

            return true;
        }) ? $this->edit_fail_result : [
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
use think\bit\traits\EditModel;

class AdminClass extends Base {
    use EditModel;

    protected $model = 'admin';
}
```

#### 自定义修改验证器

自定义删除验证器为 **edit_validate**，默认为

```php
protected $edit_validate = [
    'id' => 'require',
    'switch' => 'bool'
];
```

也可以在控制器中针对性修改

```php
use think\bit\traits\EditModel;

class AdminClass extends Base {
    use EditModel;

    protected $model = 'admin';
    protected $edit_validate = [
        'id' => 'require'
        'switch' => 'bool',
        'status' => 'require',
    ];
}
```

#### 合并模型验证器下edit场景

所以需要对应创建验证器场景 **validate/AdminClass**，**edit_switch** 为 `false` 下有效， 并加入场景 `edit`

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

如自定义前置处理，则需要调用生命周期 **EditBeforeHooks**

```php
use think\bit\traits\EditModel;
use think\bit\lifecycle\EditBeforeHooks;

class AdminClass extends Base implements EditBeforeHooks {
    use EditModel;

    protected $model = 'admin';

    public function __editBeforeHooks()
    {
        return true;
    }
}
```

**__editBeforeHooks** 的返回值为 `false` 则在此结束执行，并返回 **edit_before_result** 属性的值，默认为：

```php
protected $edit_before_result = [
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

在生命周期函数中可以通过重写自定义前置返回

```php
use think\bit\traits\EditModel;
use think\bit\lifecycle\EditBeforeHooks;

class AdminClass extends Base implements EditBeforeHooks {
    use EditModel;

    protected $model = 'admin';

    public function __editBeforeHooks()
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

如自定义后置处理，则需要调用生命周期 **EditAfterHooks**

```php
use think\bit\traits\EditModel;
use think\bit\lifecycle\EditAfterHooks;

class AdminClass extends Base implements EditAfterHooks {
    use EditModel;

    protected $model = 'admin';

    public function __editAfterHooks()
    {
        return true;
    }
}
```

**__editAfterHooks** 的返回值为 `false` 则在此结束执行进行事务回滚，并返回 **edit_after_result** 属性的值，默认为：

```php
 protected $edit_after_result = [
    'error' => 1,
    'msg' => 'error:after_fail'
];
```

在生命周期函数中可以通过重写自定义后置返回

```php
use think\bit\traits\EditModel;
use think\bit\lifecycle\EditAfterHooks;

class AdminClass extends Base implements EditAfterHooks {
    use EditModel;

    protected $model = 'admin';

    public function __editAfterHooks()
    {
        $this->edit_after_result = [
            'error'=> 1,
            'msg'=> 'error:redis'
        ];
        return false;
    }
}
```