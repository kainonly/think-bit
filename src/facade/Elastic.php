<?php

namespace think\bit\facade;

use Elasticsearch\Client;
use think\Facade;

/**
 * Class Elastic
 * @method static Client client(string $label = 'default') ElasticSearch 客户端
 * @package think\bit\facade
 */
final class Elastic extends Facade
{
    protected static function getFacadeClass()
    {
        return 'elastic';
    }
}