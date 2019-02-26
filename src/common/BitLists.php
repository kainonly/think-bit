<?php

namespace think\bit\common;

use Closure;

final class BitLists
{
    private $source = [];

    /**
     * 列表数组初始化
     * @param array $source
     * @return BitLists $this
     */
    public function data(array $source)
    {
        $lists = new BitLists();
        $lists->source = $source;
        return $lists;
    }

    /**
     * 获取数组大小
     * @return int
     */
    public function size()
    {
        return count($this->source);
    }

    /**
     * 设置键值
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        $this->source[$key] = $value;
    }

    /**
     * 数组加入元素
     * @param mixed $data
     */
    public function add(...$data)
    {
        array_push($this->source, ...$data);
    }

    /**
     * 向前数组加入元素
     * @param mixed ...$data
     */
    public function unshift(...$data)
    {
        array_unshift($this->source, ...$data);
    }

    /**
     * 数组是否为空
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->source);
    }

    /**
     * 判断是否存在键名
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $this->source);
    }

    /**
     * 判断是否存在键值
     * @param mixed $value
     * @return bool
     */
    public function contains($value)
    {
        return in_array($value, $this->source);
    }

    /**
     * 获取键值
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->source[$key];
    }

    /**
     * 移除键值
     * @param string $key
     */
    public function delete($key)
    {
        unset($this->source[$key]);
    }

    /**
     * 数组开头的单元移出元素
     * @return mixed
     */
    public function shift()
    {
        return array_shift($this->source);
    }

    /**
     * 数组出栈
     * @return mixed
     */
    public function pop()
    {
        return array_pop($this->source);
    }

    /**
     * 去除重复
     */
    public function unique()
    {
        $this->source = array_unique($this->source);
    }

    /**
     * 清除数据
     */
    public function clear()
    {
        $this->source = [];
    }

    /**
     * 返回键名
     * @return array
     */
    public function keys()
    {
        return array_keys($this->source);
    }

    /**
     * 返回键值
     * @return array
     */
    public function values()
    {
        return array_values($this->source);
    }

    /**
     * 搜索给定的值，返回键名
     * @param $value
     * @return false|int|string
     */
    public function indexOf($value)
    {
        return array_search($value, $this->source);
    }

    /**
     * 数组遍历返回
     * @param Closure $closure
     * @return array
     */
    public function map(Closure $closure)
    {
        return array_map($closure, $this->source);
    }

    /**
     * 数组过滤
     * @param Closure $closure
     * @return array
     */
    public function filter(Closure $closure)
    {
        return array_filter($this->source, $closure);
    }

    /**
     * 数组切片
     * @param $offset
     * @param null $length
     * @return array
     */
    public function slice($offset, $length = null)
    {
        return array_slice($this->source, $offset, $length);
    }

    /**
     * 获取数组
     * @return array
     */
    public function toArray()
    {
        return $this->source;
    }

    /**
     * 转为Json
     * @return false|string
     */
    public function toJson()
    {
        return json_encode($this->source);
    }

    /**
     * 转为二进制
     * @return mixed
     */
    public function toBinary()
    {
        return msgpack_pack($this->source);
    }

    /**
     * 转为树形结构
     * @param string $id_name 数组主键名称
     * @param string $parent_name 数组父级关联名称
     * @param string $child_name 树形子集名称定义
     * @param int|string $top_parent 最高级父级
     * @return array
     */
    public function toTree($id_name = 'id', $parent_name = 'parent', $child_name = 'children', $top_parent = 0)
    {
        if (empty($this->source)) return [];
        $refer = [];
        foreach ($this->source as $key => $data) {
            $refer[$data[$id_name]] = &$this->source[$key];
        }
        $tree = [];
        foreach ($this->source as $key => $data) {
            $parentId = $data[$parent_name];
            if ($top_parent == $parentId) {
                $tree[] = &$this->source[$key];
            } else {
                if (isset($refer[$parentId])) {
                    $parent = &$refer[$parentId];
                    $parent[$child_name][] = &$this->source[$key];
                }
            }
        }
        return $tree;
    }
}