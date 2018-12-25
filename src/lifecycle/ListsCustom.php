<?php

namespace think\bit\lifecycle;

interface ListsCustom
{
    /**
     * 自定义无分页数据返回
     * @param array $lists
     * @param int $total
     * @return array
     */
    public function __listsCustomReturn(Array $lists, int $total);
}