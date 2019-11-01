## MongoDB 数据库

MongoDB 数据库的操作类使用 [MongoDB](http://pecl.php.net/package/mongodb) 扩展作为支持，首先使用 `composer` 安装操作服务

```shell
composer require kain/think-mgo
```

安装后服务将自动注册，然后需要更新配置 `config/database.php`，例如：

```php
return [

    'mongodb' => [
        'uri' => env('mongodb.uri', 'mongodb://127.0.0.1:27017'),
        'database' => env('mongodb.database', null),
        'uriOptions' => [],
        'driverOptions' => []
    ]
    
];
```

- **uri** `string` 连接地址

```
mongodb://[username:password@]host1[:port1][,...hostN[:portN]]][/[database][?options]]
```

- **uriOptions** `array` 等于 `[?options]`
- **driverOptions** `array` 驱动参数
- **database** `string` 默认数据库

#### name($collection)

指向集合

- **collection** `string` 集合名称
- **Return** `\MongoDB\Collection`

查询数据

```php
use think\support\facade\Mongo;

$result = Mongo::name('api')->find();
return $result->toArray();
```

写入数据

```php
use think\support\facade\Mongo;

$result = Mongo::name('admin')->insertOne([
    'name' => 'kain',
    'status' => 1,
    'create_time' => new \MongoDB\BSON\UTCDateTime(time() * 1000),
    'update_time' => new \MongoDB\BSON\UTCDateTime(time() * 1000)
])->isAcknowledged();
return $result;
```

#### page($collection, $filter = [], $page = 1, $limit = 20, $sort = [])

生成分页

- **collection** `string` 集合名称
- **filter** `array` 搜索条件
- **page** 页码，默认 `1`
- **limit** 分页数量，默认 `20`
- **sort** 排序条件

```php
use think\support\facade\Mongo;

$data = Mongo::page('log', [
    'status' => true
], 1, 20, [
    'create_time' => -1
]);
```

!> 更多操作可参考 [MongoDB PHP Library](https://docs.mongodb.com/php-library/current/reference/) Reference.