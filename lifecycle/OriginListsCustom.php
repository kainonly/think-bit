<?php

namespace bit\lifecycle;

interface OriginListsCustom
{
    /**
     * TODO:自定义无分页数据返回
     * @param array $lists
     * @return array
     */
    public function __originListsCustomReturn(Array $lists);
}