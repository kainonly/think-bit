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

| 属性名称 | 类型   | 默认值 | 说明           |
| -------- | ------ | ------ | -------------- |
| model    | string | null   | 模型名称       |
| post     | array  | []     | 请求包含的数据 |

#### 获取列表数据请求属性

| 属性名称               | 类型   | 默认值                            | 说明                       |
| ---------------------- | ------ | --------------------------------- | -------------------------- |
| lists_origin_condition | array  | []                                | 列表数据从后端设定制约条件 |
| lists_origin_orders    | string | create_time desc                  | 列表数据设定排序           |
| lists_origin_field     | array  | ['update_time,create_time', true] | 列表数据指定返回字段       |

#### 获取分页数据请求属性

| 属性名称        | 类型   | 默认值                            | 说明                           |
| --------------- | ------ | --------------------------------- | ------------------------------ |
| lists_condition | array  | []                                | 分页列表数据从后端设定制约条件 |
| lists_orders    | string | create_time desc                  | 分页列表数据排序               |
| lists_field     | array  | ['update_time,create_time', true] | 分页列表数据指定返回字段       |

#### 获取单条数据请求属性

| 属性名称      | 类型  | 默认值                            | 说明             |
| ------------- | ----- | --------------------------------- | ---------------- |
| get_validate  | array | ['id' => 'require']               | 单条数据验证器   |
| get_condition | array | []                                | 单条数据制约条件 |
| get_field     | array | ['update_time,create_time', true] | 单条数据返回字段 |

#### 新增数据请求属性

| 属性名称          | 类型  | 默认值                                | 说明               |
| ----------------- | ----- | ------------------------------------- | ------------------ |
| add_before_result | array | ['error' => 1,'msg' => 'fail:before'] | 新增自定义前置返回 |
| add_after_result  | array | ['error' => 1,'msg' => 'fail:after']  | 新增自定义后置返回 |

#### 修改数据请求属性

| 属性名称           | 类型    | 默认值                                 | 说明               |
| ------------------ | ------- | -------------------------------------- | ------------------ |
| edit_validate      | array   | ['id' => 'require','switch' => 'bool'] | 修改数据验证器     |
| edit_before_result | array   | ['error' => 1,'msg' => 'fail:before']  | 修改自定义前置返回 |
| edit_after_result  | array   | ['error' => 1,'msg' => 'fail:after']   | 修改自定义后置返回 |
| edit_status_switch | boolean | false                                  | 是否为状态切换请求 |

#### 删除数据请求属性

| 属性名称             | 类型  | 默认值                                | 说明                     |
| -------------------- | ----- | ------------------------------------- | ------------------------ |
| delete_validate      | array | ['id' => 'require']                   | 删除数据验证器           |
| delete_before_result | array | ['error' => 1,'msg' => 'fail:before'] | 删除自定义前置返回       |
| delete_prep_result   | array | ['error' => 1,'msg' => 'fail:prep']   | 删除自定义含事务前置返回 |
| delete_after_result  | array | ['error' => 1,'msg' => 'fail:after']  | 删除自定义后置返回       |