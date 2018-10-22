# MongoDB

#### 配置

在config文件中创建 `mongo.php`

```php
<?php
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

#### 定义查询集合

##### `Mongo::collection($collection_name)`

- `collection_name` 集合名称

> 调用后返回\MongoDB\Collection，Mongo 是对官方MongoDB PHP Library的门面定义，操作可参考 https://docs.mongodb.com/php-library/current

例如1.写入一条数据

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

例如2.查询一条数据

```php
use think\bit\facade\Mongo;
use MongoDB\BSON\ObjectId;

Mongo::collection($this->collection)->findOne([
    '_id' => new ObjectId('5bc98beef56c0b052a324184')
]);
```