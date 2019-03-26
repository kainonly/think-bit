## AddModel 新增数据

AddModel 是针对新增数据的通用请求处理，执行周期为：

```php
trait AddModel
{
    public function add()
    {
        if (!empty($this->add_default_validate)) {
            $validate = Validate::make($this->add_default_validate);
            if (!$validate->check($this->post)) return [
                'error' => 1,
                'msg' => $validate->getError()
            ];
        }

        $validate = validate($this->model);
        if (!$validate->scene('add')->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];

        $this->post['create_time'] = $this->post['update_time'] = time();

        if (method_exists($this, '__addBeforeHooks') &&
            !$this->__addBeforeHooks()) {
            return $this->add_before_result;
        }

        return !Db::transaction(function () {
            if (!method_exists($this, '__addAfterHooks')) {
                return Db::name($this->model)->insert($this->post);
            }

            $id = null;
            if (isset($this->post['id'])) {
                $id = $this->post['id'];
                $result = Db::name($this->model)->insert($this->post);
                if (!$result) return false;
            } else {
                $id = Db::name($this->model)->insertGetId($this->post);
            }

            if (empty($id) || !$this->__addAfterHooks($id)) {
                $this->add_fail_result = $this->add_after_result;
                Db::rollback();
                return false;
            }

            return true;
        }) ? $this->add_fail_result : [
            'error' => 0,
            'msg' => 'ok'
        ];
    }
}
```

#### 引入特性

需要定义必须的操作模型 **model**

```php
use think\bit\traits\AddModel;

class AdminClass extends Base {
    use AddModel;

    protected $model = 'admin';
}
```

#### 合并模型验证器下add场景

所以需要对应创建验证器场景 **validate/AdminClass**， 并加入场景 `add`

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

如自定义前置处理，则需要调用生命周期 **AddBeforeHooks**

```php
use think\bit\traits\AddModel;
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
use think\bit\traits\AddModel;
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

如自定义后置处理，则需要调用生命周期 **AddAfterHooks**

```php
use think\bit\traits\AddModel;
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
use think\bit\traits\AddModel;
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