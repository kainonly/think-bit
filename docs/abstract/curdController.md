## CurdController 模型控制器

CurdController 是辅助 CURD 模型库的主控制器，库用所有 Trait 特性类属性都继承于此，CurdController 控制器已经包含了 ThinkPHP6 内 BaseController 的属性，因此无需再次定义，也可以多定义个 Base 控制器做过渡继承处理，例如：

```php
abstract class Base extends CurdController
{
    protected $middleware = ['cors', 'json', 'post', 'auth'];

    protected function initialize()
    {
        if ($this->request->isPost()) {
            $this->post = $this->request->post();
        }
    }
}
```

#### 模型属性

- **model** `string`

模型名称

```php
protected $model;
```


- **post** `array`
 
请求body

```php
protected $post = [];
```

#### 获取列表数据请求属性

- **origin_lists_default_validate** `array`

列表数据默认验证

```php
protected $origin_lists_default_validate = [
    'where' => 'array'
];
```

- **origin_lists_before_result** `array`

默认前置返回结果

```php
protected $origin_lists_before_result = [
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

- **origin_lists_condition** `array`

列表查询条件

```php
protected $origin_lists_condition = [];
```

- **origin_lists_condition_query** `Closure|null`

列表查询闭包条件

```php
protected $origin_lists_condition_query = null;
```

- **origin_lists_orders** `array`

列表数据排序

```php
protected $origin_lists_orders = ['create_time' => 'desc'];
```

- **origin_lists_field** `array`

列表数据指定返回字段

```php
protected $origin_lists_field = [];
```

- **origin_lists_without_field** `array`

列表数据指定排除的返回字段

```php
protected $origin_lists_without_field = ['update_time', 'create_time'];
```

#### 获取分页数据请求属性

- **lists_default_validate** `array`

分页数据默认验证器

```php
protected $lists_default_validate = [
    'page' => 'require',
    'page.limit' => 'require|number|between:1,50',
    'page.index' => 'require|number|min:1',
    'where' => 'array'
];
```

- **lists_before_result** `array`

分页数据前置返回结果

```php
protected $lists_before_result = [
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

- **lists_condition** `array`

分页数据查询条件

```php
protected $lists_condition = [];
```

- **lists_condition_query** `Closure|null`

分页数据查询闭包条件

```php
protected $lists_condition_query = null;
```

- **lists_orders** `array`

分页数据排序

```php
protected $lists_orders = ['create_time' => 'desc'];
```

- **lists_field** `array`

分页数据限制字段

```php
protected $lists_field = [];
```

- **lists_without_field** `array`

分页数据指定排除的返回字段

```php
protected $lists_without_field = ['update_time', 'create_time'];
```

#### 获取单条数据请求属性

- **get_default_validate** `array`

单条数据默认验证器

```php
protected $get_default_validate = [
    'id' => 'requireWithout:where|number',
    'where' => 'requireWithout:id|array'
];
```

- **get_before_result** `array`

单条数据前置返回结果

```php
protected $get_before_result = [
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

- **get_condition** `array`

单条数据查询条件

```php
protected $get_condition = [];
```

- **get_field** `array`

单条数据指定排除的返回字段

```php
protected $get_field = [];
```

- **get_without_field** `array`

```php
protected $get_without_field = ['update_time', 'create_time'];
```

#### 新增数据请求属性

- **add_model** `string`

分离新增模型名称

- **add_default_validate** `array`

新增数据默认验证器

```php
protected $add_default_validate = [];
```

- **add_auto_timestamp** `bool`

自动更新字段 `create_time` `update_time` 的时间戳

- **add_before_result** `array`

新增数据前置返回结果

```php
protected $add_before_result = [
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

- **add_after_result** `array`

新增数据后置返回结果

```php
protected $add_after_result = [
    'error' => 1,
    'msg' => 'error:after_fail'
];
```

- **add_fail_result** `array`

新增数据失败返回结果

```php
protected $add_fail_result = [
    'error' => 1,
    'msg' => 'error:insert_fail'
];
```

#### 修改数据请求属性

- **edit_model** `string`

分离编辑模型名称

- **edit_default_validate** `array`

编辑默认验证器

```php
protected $edit_default_validate = [
    'id' => 'require|number',
    'switch' => 'require|bool'
];
```

- **edit_auto_timestamp** `bool`

自动更新字段 `update_time` 的时间戳

- **edit_switch** `boolean`

是否仅为状态编辑

```php
protected $edit_switch = false;
```

- **edit_before_result** `array`

编辑前置返回结果

```php
protected $edit_before_result = [
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

- **edit_condition** `array`

编辑查询条件

```php
protected $edit_condition = [];
```

- **edit_fail_result** `array`

编辑失败返回结果

```php
protected $edit_fail_result = [
    'error' => 1,
    'msg' => 'error:fail'
];
```

- **edit_after_result** `array`

编辑后置返回结果

```php
protected $edit_after_result = [
    'error' => 1,
    'msg' => 'error:after_fail'
];
```

#### 删除数据请求属性

- **delete_model** `string`

分离删除模型名称

- **delete_default_validate** `array`

删除默认验证器

```php
protected $delete_default_validate = [
    'id' => 'require'
];
```

- **delete_before_result** `array`

删除前置返回结果

```php
protected $delete_before_result = [
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

- **delete_condition** `array`

删除查询条件

```php
protected $delete_condition = [];
```

- **delete_prep_result** `array`

事务开始之后数据写入之前返回结果

```php
protected $delete_prep_result = [
    'error' => 1,
    'msg' => 'error:prep_fail'
];
```

- **delete_fail_result** `array`

删除失败返回结果

```php
protected $delete_fail_result = [
    'error' => 1,
    'msg' => 'error:fail'
];
```

- **delete_after_result** `array`

删除后置返回结果

```php
protected $delete_after_result = [
    'error' => 1,
    'msg' => 'error:after_fail'
];
```