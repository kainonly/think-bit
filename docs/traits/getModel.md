## GetModel 获取单个数据

GetModel 是针对获取单条数据的通用请求处理

```php
trait GetModel
{
    public function get()
    {
        // 自定义获取验证器
        $validate = Validate::make($this->get_validate);
        if (!$validate->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];

        // 判断是否有前置处理
        if (method_exists($this, '__getBeforeHooks')) {
            $before_result = $this->__getBeforeHooks();
            if (!$before_result) return $this->get_before_result;
        }

        try {
            $normal = [];
            // 判断是否存在id
            if (isset($this->post['id'])) {
                $normal['id'] = $this->post['id'];
            }

            // 判断是否存在条件
            $condition = $this->get_condition;
            if (isset($this->post['where'])) $condition = array_merge(
                $condition,
                $this->post['where']
            );

            // 执行查询
            $data = Db::name($this->model)
                ->where($normal)
                ->where($condition)
                ->field($this->get_field[0], $this->get_field[1])
                ->find();

            // 判断是否自定义返回
            if (method_exists($this, '__getCustomReturn')) {
                return $this->__getCustomReturn($data);
            } else {
                return [
                    'error' => 0,
                    'data' => $data
                ];
            }
        } catch (Exception $e) {
            return [
                'error' => 1,
                'msg' => (string)$e->getMessage()
            ];
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
use think\bit\traits\GetModel;

class AdminClass extends Base {
    use GetModel;

    protected $model = 'admin';
}
```

#### 自定义获取验证器

自定义删除验证器为 **get_validate**，默认为

```php
protected $get_validate = [
    'id' => 'require'
];
```

也可以在控制器中针对性修改

```php
use think\bit\traits\GetModel;

class AdminClass extends Base {
    use GetModel;

    protected $model = 'admin';
    protected $get_validate = [
        'id' => 'require',
        'name' => 'require'
    ];
}
```

#### 判断是否有前置处理

如自定义前置处理，则需要调用生命周期 **GetBeforeHooks**

```php
use think\bit\traits\GetModel;
use think\bit\lifecycle\GetBeforeHooks;

class AdminClass extends Base implements GetBeforeHooks {
    use GetModel;

    protected $model = 'admin';

    public function __getBeforeHooks()
    {
        return true;
    }
}
```

**__getBeforeHooks** 的返回值为 `false` 则在此结束执行，并返回 **get_before_result** 属性的值，默认为：

```php
protected $get_before_result = [
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

在生命周期函数中可以通过重写自定义前置返回

```php
use think\bit\traits\GetModel;
use think\bit\lifecycle\GetBeforeHooks;

class AdminClass extends Base implements GetBeforeHooks {
    use GetModel;

    protected $model = 'admin';

    public function __getBeforeHooks()
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
protected $get_condition = [];
```

例如加入企业主键限制

```php
use think\bit\traits\GetModel;

class AdminClass extends Base {
    use GetModel;

    protected $model = 'admin';
    protected $get_condition = [
        ['enterprise', '=', 1]
    ];
}
```

#### 限制返回字段

如需要给接口限制返回字段，只需要重写 **get_field**，默认为

```php
protected $get_field = ['update_time,create_time', true];
```

例如返回除 **update_time** 修改时间所有的字段

```php
use think\bit\traits\GetModel;

class AdminClass extends Base {
    use GetModel;

    protected $model = 'admin';
    protected $get_field = ['update_time', true];
}
```

#### 自定义返回结果

如自定义返回结果，则需要调用生命周期 **GetCustom**

```php
use think\bit\traits\GetModel;
use think\bit\lifecycle\GetCustom;

class AdminClass extends Base implements GetCustom {
    use GetModel;

    protected $model = 'admin';

    public function __getCustomReturn($data)
    {
        return [
            'error' => 0,
            'data' => $data
        ];
    }
}
```

**__getCustomReturn** 需要返回整体的响应结果

```php
return [
    'error' => 0,
    'data' => $data
];
```

- **data** `array` 原数据