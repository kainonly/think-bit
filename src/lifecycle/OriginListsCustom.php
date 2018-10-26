<?php

namespace think\bit\lifecycle;

interface OriginListsCustom
{
    /**
     * 自定义无分页数据返回
     * @param array $lists
     * @return array
     */
    public function __originListsCustomReturn(Array $lists);
}