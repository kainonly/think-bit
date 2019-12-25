## ElasticSearch 全文搜索

ElasticSearch 可对数据进行全文搜索或针对数据分析查询，首先使用 `composer` 安装操作服务

```shell
composer require kain/think-elastic
```

安装后服务将自动注册，然后需要更新配置 `config/database.php`

```php
return [

    'elasticsearch' => [
        'default' => [
            // 集群连接
            'hosts' => explode(',', Env::get('elasticsearch.hosts', 'localhost:9200')),
            // 重试次数
            'retries' => 0,
            // 公共CA证书
            'SSLVerification' => null,
            // 开启日志
            'logger' => null,
            // 配置 HTTP Handler
            'handler' => null,
            // 设置连接池
            'connectionPool' => Elasticsearch\ConnectionPool\StaticNoPingConnectionPool::class,
            // 设置选择器
            'selector' => Elasticsearch\ConnectionPool\Selectors\RoundRobinSelector::class,
            // 设置序列化器
            'serializer' => Elasticsearch\Serializers\SmartSerializer::class
        ]
    ]

];
```

- **hosts** `array` 集群连接
- **retries** `int` 重试次数
- **SSLVerification** `string` 公共CA证书
- **logger** `LoggerInterface` 开启日志
- **handler** `mixed` 配置 HTTP Handler
- **connectionPool** `AbstractConnectionPool|string` 设置连接池
- **selector** `SelectorInterface|string` 设置选择器
- **serializer** `SerializerInterface|string` 设置序列化器

#### client(string $label = 'default')

- **label** `string` 配置label
- **Return** `Elasticsearch\Client`

写入文档

```php
use think\support\facade\Elastic;

$response = Elastic::client()->index([
    'index' => 'test',
    'id' => 'test',
    'body' => [
        'value' => 1
    ]
]);

// ^ array:8 [▼
//   "_index" => "test"
//   "_type" => "_doc"
//   "_id" => "test"
//   "_version" => 1
//   "result" => "created"
//   "_shards" => array:3 [▼
//     "total" => 2
//     "successful" => 1
//     "failed" => 0
//   ]
//   "_seq_no" => 0
//   "_primary_term" => 1
// ]
```

获取文档

```php
use think\support\facade\Elastic;

$response = Elastic::client()->get([
    'index' => 'test',
    'id' => 'test'
]);

// ^ array:8 [▼
//   "_index" => "test"
//   "_type" => "_doc"
//   "_id" => "test"
//   "_version" => 1
//   "_seq_no" => 0
//   "_primary_term" => 1
//   "found" => true
//   "_source" => array:1 [▼
//     "value" => 1
//   ]
// ]
```

搜索文档

```php
use think\support\facade\Elastic;

$response = Elastic::client()->search([
    'index' => 'test',
    'body' => [
        'query' => [
            'match' => [
                'value' => 1
            ]
        ]
    ]
]);

// ^ array:4 [▼
//   "took" => 4
//   "timed_out" => false
//   "_shards" => array:4 [▼
//     "total" => 1
//     "successful" => 1
//     "skipped" => 0
//     "failed" => 0
//   ]
//   "hits" => array:3 [▼
//     "total" => array:2 [▼
//       "value" => 1
//       "relation" => "eq"
//     ]
//     "max_score" => 1.0
//     "hits" => array:1 [▼
//       0 => array:5 [▼
//         "_index" => "test"
//         "_type" => "_doc"
//         "_id" => "test"
//         "_score" => 1.0
//         "_source" => array:1 [▼
//           "value" => 1
//         ]
//       ]
//     ]
//   ]
// ]
```

删除文档

```php
use think\support\facade\Elastic;

$response = Elastic::client()->delete([
    'index' => 'test',
    'id' => 'test'
]);

// ^ array:8 [▼
//   "_index" => "test"
//   "_type" => "_doc"
//   "_id" => "test"
//   "_version" => 2
//   "result" => "deleted"
//   "_shards" => array:3 [▼
//     "total" => 2
//     "successful" => 1
//     "failed" => 0
//   ]
//   "_seq_no" => 1
//   "_primary_term" => 1
// ]
```

删除索引

```php
use think\support\facade\Elastic;

$response = Elastic::client()->indices()->delete([
    'index' => 'test',
]);

// ^ array:1 [▼
//   "acknowledged" => true
// ]
```

创建索引

```php
use think\support\facade\Elastic;

$response = Elastic::client()->indices()->create([
    'index' => 'test'
]);

// ^ array:3 [▼
//   "acknowledged" => true
//   "shards_acknowledged" => true
//   "index" => "test"
// ]
```

> `think-elastic` 使用了 [elasticsearch/elasticsearch](https://packagist.org/packages/elasticsearch/elasticsearch) ，更多方法可查看 [Elasticsearch-PHP](https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/index.html) 完整文档