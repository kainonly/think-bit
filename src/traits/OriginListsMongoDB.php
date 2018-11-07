<?php

namespace think\bit\traits;

use think\bit\facade\Mongo;
use think\bit\validate;

trait OriginListsMongoDB
{
    public function originLists()
    {
        // 通用验证
        $validate = new validate\Lists;
        if (!$validate->scene('origin')->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];

        // 是否存在条件
        $condition = $this->lists_origin_condition;
        if (isset($this->post['where'])) $condition = array_merge(
            $condition, $this->post['where']
        );

        // 执行查询
        $lists = Mongo::collection($this->model)->find($condition, [
            '$sort' => ['create_time' => -1]
        ])->toArray();

        // 是否自定义返回
        if (method_exists($this, '__originListsCustomReturn')) {
            return $this->__originListsCustomReturn($lists);
        } else {
            return [
                'error' => 0,
                'data' => $lists
            ];
        }
    }
}