## BitController 通用控制器

BitController 是辅助框架的主控制器，使用辅助处理则需要继承该控制器

```php
use think\bit\common\BitController;

class Base extends BitController
{
    // customize
}
```

##### - model

模型名称，命名规则与ThinkPHP一致，对应数据表即可

##### - post

请求包含的数据，在控制器中可直接使用 `$this->post['any']`

##### - lists_origin_condition

列表数据从后端设定制约条件，默认 `[]`

##### - lists_origin_orders

列表数据设定排序，默认 `create_time desc`

##### - lists_origin_field

列表数据指定返回字段，设置中 `[0]` 为字段名称，`[1]` 为是否为排除，默认为 `['update_time,create_time', true]`

##### - lists_condition

分页列表数据从后端设定制约条件，默认 `[]`

##### - lists_orders

分页列表数据排序，默认 `create_time desc`

##### - lists_field

分页列表数据指定返回字段，设置中 `[0]` 为字段名称，`[1]` 为是否为排除，默认为 `['update_time,create_time', true]`

##### - get_validate

单条数据验证器，遵循ThinkPHP `<\think\Validate>`独立验证，默认为 `['id' => 'require']`

##### - get_condition

单条数据制约条件，默认 `[]`

##### - get_field

单条数据返回字段，默认为 `['update_time,create_time', true]`

##### - add_before_result

新增自定义前置返回，默认为 `['error' => 1,'msg' => 'fail:before']`

##### - add_after_result

新增自定义后置返回，默认为 `['error' => 1,'msg' => 'fail:after']`

##### - edit_validate

修改数据验证器，遵循ThinkPHP `<\think\Validate>`独立验证，默认为 `['id' => 'require','switch' => 'bool']`

##### - edit_before_result

修改自定义前置返回，默认为 `['error' => 1,'msg' => 'fail:before']`

##### - edit_after_result

修改自定义后置返回，默认为 `['error' => 1,'msg' => 'fail:after']`

##### - edit_status_switch

是否为状态切换请求，在编辑处理中可获取状态 `true` 或 `false`

##### - delete_validate

删除数据验证器，遵循ThinkPHP `<\think\Validate>`独立验证，默认为 `['id' => 'require']`

##### - delete_before_result

删除自定义前置返回，默认为 `['error' => 1,'msg' => 'fail:before']`

##### - delete_prep_result

删除自定义含事务前置返回，默认为 `['error' => 1,'msg' => 'fail:prep']`

##### - delete_after_result

删除自定义后置返回，默认为 `['error' => 1,'msg' => 'fail:after']`

#### 门面与扩展

##### - Redis

`think\bit\facade\Redis` 对 phpredis 功能整合：通用函数、闭包事务与抽象模型

##### - MongoDB

`think\bit\facade\Mongo` 应 ThinkPHP 下对 MongoDB 处理有一定局限，因此对官方 MongoDB PHP Library 的定义门面

##### - RabbitMQ

`think\bit\facade\Rabbit` 对官方 php-amqplib 的门面定义，整合：闭包连接渠道

#### 请求特性

##### - GetModel

获取单条数据的通用请求处理

##### - OriginListsModel

列表数据的通用请求处理

##### - ListsModel

分页数据的通用请求处理

##### - AddModel

新增数据的通用请求处理

##### - EditModel

修改数据的通用请求处理

##### - DeleteModel

删除数据的通用请求处理

##### - GetMongoDB

获取单条数据的通用请求处理

##### - OriginListsMongoDB

列表数据的通用请求处理

##### - ListsMongoDB

分页数据的通用请求处理

##### - AddMongoDB

新增数据的通用请求处理

##### - EditMongoDB

删除数据的通用请求处理

##### - DeleteMongoDB

针对删除数据的通用请求处理

#### 生命周期

##### - GetCustom

获取单条数据的通用请求处理自定义返回周期

##### - OriginListsCustom

列表数据的通用请求处理自定义返回周期

##### - AddBeforeHooks

新增数据的通用请求处理前置自定义周期

##### - AddAfterHooks

新增数据的通用请求处理后置自定义周期

##### - EditBeforeHooks

编辑数据的通用请求处理前置自定义周期

##### - EditAfterHooks

编辑数据的通用请求处理后置自定义周期

##### - DeleteBeforeHooks

删除数据的通用请求处理前置自定义周期

##### - DeletePrepHooks

删除数据的通用请求处理含事务前置自定义周期

##### - DeleteAfterHooks

删除数据的通用请求处理后置自定义周期