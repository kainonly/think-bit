## Elastic 搜索分析

Elastic 可对数据进行全文搜索或针对数据分析查询，例如：系统运行情况、用户操作行为或喜好等等，首先使用 `composer` 安装操作服务

```shell
composer require kain/think-elastic
```

安装后服务将自动注册，然后需要更新配置 `config/elastic.php`

```php
return [

    'default' => [
        'hosts' => [
            'localhost:9200'
        ],
        'retries' => 0,
        'SSLVerification' => null,
        'logger' => null,
        'handler' => null,
        'connectionPool' => Elasticsearch\ConnectionPool\StaticNoPingConnectionPool::class,
        'selector' => Elasticsearch\ConnectionPool\Selectors\RoundRobinSelector::class,
        'serializer' => Elasticsearch\Serializers\SmartSerializer::class
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

#### client()

- **Return** `Elasticsearch\Client`

使用 Elastic 客户端

```php
use think\support\facade\Elastic;

$data = Elastic::client()
    ->search();
```

#### create(string $label)

- **label** `string` 配置label
- **Return** `Elasticsearch\Client`

创建 Elastic 客户端

```php
use think\support\facade\Elastic;

$client = Elastic::create('test');
$data = $client->search();
```