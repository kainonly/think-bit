## CurdController 模型控制器

CurdController 辅助 CURD 模型库的主控制器属性都继承于此，CurdController 控制器已经包含了默认的 BaseController，开发中可以再渡继承处理，例如

```php
use think\bit\CurdController;

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

#### 公共属性

- **model** `string` 模型名称
- **post** `array` 请求body，默认 `[]`

#### 获取列表数据请求属性

- **origin_lists_default_validate** `array` 列表数据默认验证，默认

```php
[
    'where' => 'array'
];
```

- **origin_lists_before_result** `array` 默认前置返回结果，默认

```php
[
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

- **origin_lists_condition** `array` 列表查询条件，默认 `[]`
- **origin_lists_condition_query** `Closure|null` 列表查询闭包条件，默认 `null`
- **origin_lists_orders** `array` 列表数据排序，默认

```php
[
    'create_time' => 'desc'
];
```

- **origin_lists_field** `array` 列表数据指定返回字段，默认 `[]`
- **origin_lists_without_field** `array` 列表数据指定排除的返回字段，默认

```php
[
    'update_time', 
    'create_time'
];
```

#### 获取分页数据请求属性

- **lists_default_validate** `array` 分页数据默认验证器，默认

```php
[
    'page' => 'require',
    'page.limit' => 'require|number|between:1,50',
    'page.index' => 'require|number|min:1',
    'where' => 'array'
];
```

- **lists_before_result** `array` 分页数据前置返回结果，默认

```php
[
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

- **lists_condition** `array` 分页数据查询条件，默认 `[]`
- **lists_condition_query** `Closure|null` 分页数据查询闭包条件，默认 `null`
- **lists_orders** `array` 分页数据排序，默认

```php
[
    'create_time' => 'desc'
];
```

- **lists_field** `array` 分页数据限制字段，默认 `[]`
- **lists_without_field** `array` 分页数据指定排除的返回字段，默认

```php
[
    'update_time', 
    'create_time'
];
```

#### 获取单条数据请求属性

- **get_default_validate** `array` 单条数据默认验证器，默认

```php
[
    'id' => 'requireWithout:where|number',
    'where' => 'requireWithout:id|array'
];
```

- **get_before_result** `array` 单条数据前置返回结果，默认

```php
[
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

- **get_condition** `array` 单条数据查询条件，默认 `[]`
- **get_field** `array` 单条数据限制字段，默认 `[]`
- **get_without_field** `array` 单条数据指定排除的返回字段，默认

```php
[
    'update_time', 
    'create_time'
];
```

#### 新增数据请求属性

- **add_model** `string` 分离新增模型名称，默认 `null`
- **add_default_validate** `array` 新增数据默认验证器，默认 `[]`
- **add_auto_timestamp** `bool` 自动更新字段 `create_time` `update_time` 的时间戳，默认 `true`
- **add_before_result** `array` 新增数据前置返回结果，默认

```php
[
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

- **add_after_result** `array` 新增数据后置返回结果，默认

```php
[
    'error' => 1,
    'msg' => 'error:after_fail'
];
```

- **add_fail_result** `array` 新增数据失败返回结果，默认

```php
[
    'error' => 1,
    'msg' => 'error:insert_fail'
];
```

#### 修改数据请求属性

- **edit_model** `string` 分离编辑模型名称，默认 `null`
- **edit_default_validate** `array` 编辑默认验证器，默认

```php
[
    'id' => 'require|number',
    'switch' => 'require|bool'
];
```

- **edit_auto_timestamp** `bool` 自动更新字段 `update_time` 的时间戳，默认 `true`
- **edit_switch** `boolean` 是否仅为状态编辑，默认 `false`
- **edit_before_result** `array` 编辑前置返回结果，默认

```php
[
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

- **edit_condition** `array` 编辑查询条件，默认 `[]`
- **edit_fail_result** `array` 编辑失败返回结果，默认

```php
[
    'error' => 1,
    'msg' => 'error:fail'
];
```

- **edit_after_result** `array` 编辑后置返回结果，默认

```php
[
    'error' => 1,
    'msg' => 'error:after_fail'
];
```

#### 删除数据请求属性

- **delete_model** `string` 分离删除模型名称，默认 `null`
- **delete_default_validate** `array` 删除默认验证器，默认

```php
[
    'id' => 'require'
];
```

- **delete_before_result** `array` 删除前置返回结果，默认

```php
[
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

- **delete_condition** `array` 删除查询条件，默认 `[]`
- **delete_prep_result** `array` 事务开始之后数据写入之前返回结果，默认

```php
[
    'error' => 1,
    'msg' => 'error:prep_fail'
];
```

- **delete_fail_result** `array` 删除失败返回结果，默认

```php
[
    'error' => 1,
    'msg' => 'error:fail'
];
```

- **delete_after_result** `array` 删除后置返回结果，默认

```php
[
    'error' => 1,
    'msg' => 'error:after_fail'
];
```