## EditModel 编辑数据

EditModel 是针对修改数据的通用请求处理

```php
trait EditModel
{
    public function edit()
    {
         // 自定义修改验证器
        $validate = Validate::make($this->edit_validate);
        if (!$validate->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];

        // 判断是否为状态修改请求
        if (isset($this->post['switch']) && !empty($this->post['switch'])) {
            $this->edit_status_switch = true;
        } else {
            // 合并模型验证器下edit场景
            $validate = validate($this->model);
            if (!$validate->scene('edit')->check($this->post)) return [
                'error' => 1,
                'msg' => $validate->getError()
            ];
        }

        unset($this->post['switch']);
        $this->post['update_time'] = time();
        // 判断是否有前置处理
        if (method_exists($this, '__editBeforeHooks')) {
            $before_result = $this->__editBeforeHooks();
            if (!$before_result) {
                return $this->edit_before_result;
            }
        }

        $transaction = Db::transaction(function () {
            if (isset($this->post['id']) && !empty($this->post['id'])) {
                unset($this->post['where']);
                Db::name($this->model)->update($this->post);
            } elseif (isset($this->post['where']) &&
                !empty($this->post['where']) &&
                is_array($this->post['where'])) {
                $condition = $this->post['where'];
                unset($this->post['where']);
                Db::name($this->model)->where($condition)->update($this->post);
            } else {
                return false;
            }

            // 判断是否有后置处理
            if (method_exists($this, '__editAfterHooks')) {
                $after_result = $this->__editAfterHooks();
                if (!$after_result) {
                    $this->edit_fail_result = $this->edit_after_result;
                    Db::rollback();
                    return false;
                }
            }

            return true;
        });
        if ($transaction) return [
            'error' => 0,
            'msg' => 'ok'
        ]; else {
            return $this->edit_fail_result;
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

所以需要对应创建验证器场景 **validate/AdminClass**，**edit_status_switch** 为 `false` 下有效， 并加入场景 `edit`

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