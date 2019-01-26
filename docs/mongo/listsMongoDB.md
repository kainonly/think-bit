# ListsMongoDB

ListsMongoDB 是针对分页数据的通用请求处理，仅支持 MongoDB PHP Library

#### 周期流程

执行通用请求 -> 分页验证器 -> 条件合并 -> 通用处理 -> 返回处理请求

> 条件合并：`post['where']` 条件会与设定固定的条件属性 `lists_condition` 进行合并

- `post['where]` 需满足 MongoDB CRUD operation 即可
  
#### 引入特性

必须定义模型名称

```php
use think\bit\traits\ListsMongoDB;

class NoBodyClass extends Base {
    use ListsMongoDB;

    protected $model = 'nobody';
}
```

可定义固定条件属性 `$this->lists_condition`，默认为 `[]`，需满足 MongoDB CRUD operation

```php
use think\bit\traits\ListsMongoDB;

class NoBodyClass extends Base {
    use ListsMongoDB;

    protected $model = 'nobody';
    protected $lists_condition = [
        'status' => 1
    ];
}
```

#### 分页参数

- `page` 分页参数
    - `limit` 分页大小
    - `index` 分页索引

#### 返回数据

- `error` 响应状态
- `data` 返回数据
    - `lists` 列表数据
    - `total` 总数
- `msg` 回馈代码