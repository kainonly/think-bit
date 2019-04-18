## BitController 通用控制器

BitController 是辅助框架的主控制器，使用辅助处理则需要继承该控制器

```php
use think\bit\common\BitController;

class Base extends BitController
{
    // customize
}
```

#### 通用属性

- **model** `string`

模型名称

```php
protected $model;
```


- **post** `array`
 
请求包含的数据

```php
protected $post = [];
```

#### 获取列表数据请求属性

- **origin_lists_default_validate** `array`

默认列表数据验证

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

- **origin_lists_orders** `string`

列表数据排序

```php
protected $origin_lists_orders = 'create_time desc';
```

- **origin_lists_field** `array`

列表数据限制字段

```php
protected $origin_lists_field = ['update_time,create_time', true];
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

分页数据条件查询

```php
protected $lists_condition = [];
```

- **lists_condition_query** `Closure|null`

分页数据查询闭包条件

```php
protected $lists_condition_query = null;
```

- **lists_orders** `string`

分页数据排序

```php
protected $lists_orders = 'create_time desc';
```

- **lists_field** `array`

分页数据限制字段

```php
protected $lists_field = ['update_time,create_time', true];
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

单条数据限制字段

```php
    protected $get_field = ['update_time,create_time', true];
```

#### 新增数据请求属性

- **add_default_validate** `array`

新增数据默认验证器

```php
protected $add_default_validate = [];
```

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

- **edit_default_validate** `array`

编辑默认验证器

```php
protected $edit_default_validate = [
    'id' => 'require|number',
    'switch' => 'require|bool'
];
```

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