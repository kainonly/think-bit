# MongoDB

MongoDB 是一个基于分布式文件存储的数据库。由 C++ 语言编写。旨在为 WEB 应用提供可扩展的高性能数据存储解决方案。

MongoDB 是一个介于关系数据库和非关系数据库之间的产品，是非关系数据库当中功能最丰富，最像关系数据库的。

#### 配置

在ThinkPHP项目中下创建 `config/mongo.php`

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

> 调用后返回 `\MongoDB\Collection`，`Mongo` 是对官方 MongoDB PHP Library 的门面定义，操作可参考 https://docs.mongodb.com/php-library/current