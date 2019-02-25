## Mongo 数据库

MongoDB 数据库的操作类，使用前请确实是否已安装 [MongoDB](http://pecl.php.net/package/mongodb) 扩展，你需要在主配置或对应的模块下创建配置 `config/mongo.php`，例如：

```php
return [
    'uri' => 'mongodb://127.0.0.1:27017',
    'uriOptions' => [],
    'driverOptions' => [],
    'database' => 'test'
];
```

- **uri** `string` 连接地址

```
mongodb://[username:password@]host1[:port1][,...hostN[:portN]]][/[database][?options]]
```

- **uriOptions** `array` 等于 `[?options]`
- **driverOptions** `array` 驱动参数
- **database** `string` 默认数据库

#### Db($database = '')

指向数据库

- **database** `string` 数据库名称，默认值为配置默认数据库
- **Return** `\MongoDB\Database`

查询数据

```php
$result = Mgo::Db()
    ->selectCollection('api')
    ->find();
return $result->toArray();
```

写入数据

```php
$result = Mgo::Db('center')->selectCollection('admin')->insertOne([
    'name' => 'kain',
    'status' => 1,
    'create_time' => new \MongoDB\BSON\UTCDateTime(time() * 1000),
    'update_time' => new \MongoDB\BSON\UTCDateTime(time() * 1000)
])->isAcknowledged();
return $result;
```

!> 更多操作可参考 [MongoDB PHP Library](https://docs.mongodb.com/php-library/current/reference/) Reference.