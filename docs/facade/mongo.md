# Mongo 数据库

MongoDB 数据库的操作类，使用前请确实是否已安装 [MongoDB](http://pecl.php.net/package/mongodb) 扩展，另外使用需要手动安装 `mongodb/mongodb`

```shell
composer require mongodb/mongodb
```

你需要在主配置或对应的模块下创建配置 `config/mongo.php`，例如：

```php
return [
    'host' => 'localhost:27017',
    'username' => 'admin',
    'password' => '123456',
    'database' => 'admin',
    'replicaSet' => ''
];
```

- **host** `string` 服务器地址
- **username** `string` 数据库用户名
- **password** `string` 数据库密码
- **database** `string` 数据库名称
- **replicaSet** `string` 副本集

#### collection($collection_name)

定义 MongoDB 查询集合

- **collection_name** `string` 集合名称
- **Return** `Collection`

写入一条数据

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

查询一条数据

```php
use think\bit\facade\Mongo;
use MongoDB\BSON\ObjectId;

Mongo::collection($this->collection)->findOne([
    '_id' => new ObjectId('5bc98beef56c0b052a324184')
]);
```