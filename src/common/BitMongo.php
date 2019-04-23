<?php

namespace think\bit\common;

use \MongoDB\Client;
use think\facade\Config;

final class BitMongo
{
    private $client;
    private $database;

    public function __construct()
    {
        $config = Config::get('database.mongodb');
        if (isset($config['database']) && !empty($config['database'])) {
            $this->database = $config['database'];
        }
        $this->client = new Client($config['uri'], $config['uriOptions'], $config['driverOptions']);
    }

    /**
     * 指向数据库
     * @param string $database 数据库名称
     * @return \MongoDB\Database
     */
    public function Db($database = '')
    {
        return (!empty($database)) ?
            $this->client->selectDatabase($database) :
            $this->client->selectDatabase($this->database);
    }

    /**
     * 分页生成
     * @param string $database 数据库名称
     * @param string $collection 集合名称
     * @param array $filter 条件
     * @param int $page 页码
     * @param int $limit 分页数量
     * @param array $sort 排序条件
     * @return array
     */
    public function Page($database, $collection, $filter = [], $page = 1, $limit = 20, $sort = ['create_time' => -1])
    {
        $total = $this->Db($database)->selectCollection($collection)->countDocuments();
        $lists = $this->Db($database)->selectCollection($collection)->find(
            $filter, [
            'skip' => $page - 1,
            'limit' => $limit,
            'sort' => $sort,
        ])->toArray();

        return [
            'lists' => $lists,
            'total' => $total
        ];
    }
}