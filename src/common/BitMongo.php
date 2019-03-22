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
}