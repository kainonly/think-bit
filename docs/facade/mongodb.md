# MongoDB

在ThinkPHP项目中下创建 `config/mongo.php`，设置配置

```php
return [
    'host' => 'localhost:27017',
    'username' => 'any',
    'password' => '123',
    'database' => 'any',
    'replicaSet' => ''
];
```

- `host` 服务器地址
- `username` 数据库用户名
- `password` 数据库密码
- `database` 数据库名称
- `replicaSet` 副本集

#### collection($collection_name)

定义 MongoDB 查询集合

- `collection_name` 集合名称
- 返回 `<\MongoDB\Collection>`

例子.写入一条数据

```php
use think\bit\facade\Mongo;
use MongoDB\BSON\UTCDateTime;

Mongo::collection($this->collection)->insertOne([
    'name' => 'kain',
    'status' => 1,
    'create_time' => new UTCDateTime(time() * 1000),
    'update_time' => new UTCDateTime(time() * 1000)
])->isAcknowledged();
```

例子.查询一条数据

```php
use think\bit\facade\Mongo;
use MongoDB\BSON\ObjectId;

Mongo::collection($this->collection)->findOne([
    '_id' => new ObjectId('5bc98beef56c0b052a324184')
]);
```

> MongoDB PHP Library 更多操作可参考 https://docs.mongodb.com/php-library/current