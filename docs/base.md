# BitController

BitController 是辅助框架的主控制器，使用辅助处理则需要继承该控制器

#### model

模型名称，命名规则与ThinkPHP一致，对应数据表即可

#### post

请求包含的数据，在控制器中可直接使用 `$this->post['any']`

#### lists_origin_condition

列表数据从后端设定制约条件，默认 `[]`

#### lists_origin_orders

列表数据设定排序，默认 `create_time desc`

#### lists_origin_field

列表数据指定返回字段，设置中 `[0]` 为字段名称，`[1]` 为是否为排除，默认为 `['update_time,create_time', true]`

#### lists_condition

分页列表数据从后端设定制约条件，默认 `[]`

#### lists_orders

分页列表数据排序，默认 `create_time desc`

#### lists_field

分页列表数据指定返回字段，设置中 `[0]` 为字段名称，`[1]` 为是否为排除，默认为 `['update_time,create_time', true]`


#### get_validate

单条数据验证器，遵循ThinkPHP `<\think\Validate>`独立验证，默认为 `['id' => 'require']`

#### get_condition

单条数据制约条件，默认 `[]`

#### get_field

单条数据返回字段，默认为 `['update_time,create_time', true]`

#### add_before_result

新增自定义前置返回，默认为 `['error' => 1,'msg' => 'fail:before']`

#### add_after_result

新增自定义后置返回，默认为 `['error' => 1,'msg' => 'fail:after']`

#### edit_validate

修改数据验证器，遵循ThinkPHP `<\think\Validate>`独立验证，默认为 `['id' => 'require','switch' => 'bool']`

#### edit_before_result

修改自定义前置返回，默认为 `['error' => 1,'msg' => 'fail:before']`

#### edit_after_result

修改自定义后置返回，默认为 `['error' => 1,'msg' => 'fail:after']`

#### edit_status_switch

是否为状态切换请求，在编辑处理中可获取状态 `true` 或 `false`

#### delete_validate

删除数据验证器，遵循ThinkPHP `<\think\Validate>`独立验证，默认为 `['id' => 'require']`

#### delete_before_result

删除自定义前置返回，默认为 `['error' => 1,'msg' => 'fail:before']`

#### delete_after_result

删除自定义后置返回，默认为 `['error' => 1,'msg' => 'fail:after']`