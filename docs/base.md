# 辅助控制器 - BitController

> 辅助控制器是使用通用处理的重要组成部分，则需要使用通用处理时需要继承辅助控制器

##### `model`

- 模型名称，模型名称需要对应数据表，命名规则与ThinkPHP一致

例如定义 `admin` 模块

```php
$this->model = 'admin';
```

##### `post`

- 请求数据，请求中包含的数据

在控制器中可直接使用

```php
$this->post['any']
```

##### `lists_origin_condition`

- 后端无分页列表数据制约条件
- 默认 `[]`

##### `lists_origin_orders`

- 无分页列表数据排序
- 默认 `create_time desc`

##### `lists_origin_field`

- 无分页列表数据返回字段

默认为

```php
['update_time,create_time', true]
```

> 设置时 `lists_origin_field[0]` 为字段名称，`lists_origin_field[1]` 为是否为排除

例如，分页列表排除字段 `create_time` 的返回结果

```php
$this->lists_origin_field = ['create_time', true];
```

##### `lists_condition`

- 后端列表数据制约条件
- 默认 `[]`

##### `lists_orders`

- 列表排序
- 默认 `create_time desc`

##### `lists_field`

- 列表数据返回字段

默认为

```php
['update_time,create_time', true]
```

> 设置时 `lists_orders[0]` 为字段名称，`lists_orders[1]` 为是否为排除

例如，分页列表排除字段 `create_time` 的返回结果

```php
$this->lists_orders = ['create_time', true];
```

##### `get_validate`

- 单条数据验证器

默认为

```php
['id' => 'require']
```

##### `get_condition`

- 单条数据制约条件
- 默认 `[]`

##### `get_field`

- 单条数据返回字段

默认为

```php
['update_time,create_time', true]
```

##### `add_before_result`

- 新增自定义前置返回

默认为

```php
[
    'error' => 1,
    'msg' => 'fail:before'
]
```

##### `$add_after_result`

- 新增自定义后置返回

默认为

```php
[
    'error' => 1,
    'msg' => 'fail:after'
]
```

##### `edit_validate`

- 修改数据验证器

默认为

```php
[
    'id' => 'require',
    'switch' => 'bool'
]
```

##### `edit_before_result`

- 修改自定义前置返回

默认为

```php
[
    'error' => 1,
    'msg' => 'fail:before'
]
```

##### `edit_after_result`

- 修改自定义后置返回

默认为

```php
[
    'error' => 1,
    'msg' => 'fail:after'
]
```

##### `edit_status_switch`

- 状态切换请求
- 默认 `false`

##### `delete_validate`

- 删除数据验证器

默认为

```php
[
    'id' => 'require'
]
```

##### `delete_before_result`

- 删除自定义前置返回

默认为

```php
[
    'error' => 1,
    'msg' => 'fail:before'
]
```

##### `delete_after_result`

- 删除自定义后置返回

默认为

```php
[
    'error' => 1,
    'msg' => 'fail:after'
]
```