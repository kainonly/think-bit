<?php

namespace think\bit\traits;

use think\bit\facade\Mongo;
use think\bit\validate;

trait OriginListsMgo
{
    public function originLists()
    {
        $validate = new validate\Lists;
        if (!$validate->scene('origin')->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];

        $condition = $this->lists_origin_condition;
        if (isset($this->post['where'])) $condition = array_merge(
            $condition, $this->post['where']
        );

        $lists = Mongo::collection($this->model)->find($condition, [
            '$sort' => ['create_time' => -1]
        ])->toArray();

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