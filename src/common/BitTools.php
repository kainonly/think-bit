<?php

namespace think\bit\common;

use Ramsey\Uuid\Uuid;

class BitTools
{
    /**
     * 把返回的数据集转换成Tree
     * @param array $list 装换数据集
     * @param string $pk 主鍵
     * @param string $pid 父节点
     * @param string $child 子节点字段名
     * @param int $root 顶层节点
     * @return array
     */
    public function listToTree($list = [], $pk = 'id', $pid = 'parent', $child = 'children', $root = 0)
    {
        if (empty($list)) return [];
        $refer = [];
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] = &$list[$key];
        }
        $tree = [];
        foreach ($list as $key => $data) {
            $parentId = $data[$pid];
            if ($root == $parentId) {
                $tree[] = &$list[$key];
            } else {
                if (isset($refer[$parentId])) {
                    $parent = &$refer[$parentId];
                    $parent[$child][] = &$list[$key];
                }
            }
        }
        return $tree;
    }

    /**
     * 生成uuid
     * @param string $version
     * @return string|null
     */
    public function uuid($version = 'v4', $namespace = null, $name = null)
    {
        try {
            switch ($version) {
                case 'v1':
                    return Uuid::uuid1()->toString();
                case 'v3':
                    if (empty($namespace) || empty($name)) return null;
                    return Uuid::uuid3($namespace, $name)->toString();
                case 'v4':
                    return Uuid::uuid4()->toString();
                case 'v5':
                    if (empty($namespace) || empty($name)) return null;
                    return Uuid::uuid5($namespace, $name)->toString();
                default:
                    return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * 随机数16位
     * @return string
     */
    public function random()
    {
        return \ShortCode\Random::get(16);
    }

    /**
     * 随机数8位
     * @return string
     */
    public function randomShort()
    {
        return \ShortCode\Random::get(8);
    }
}