<?php

namespace think\bit\traits;

use think\bit\facade\Mongo;
use think\bit\validate;

trait ListsMongoDB
{
    public function lists()
    {
        // 通用验证
        $validate = new validate\Lists;
        if (!$validate->scene('page')->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];

        // 判断是否存在条件
        $condition = $this->lists_condition;
        if (isset($this->post['where'])) $condition = array_merge(
            $condition,
            $this->post['where']
        );

        // 分页计算
        $total = Mongo::collection($this->model)->countDocuments($condition);
        $divided = $total % $this->post['page']['limit'] == 0;
        if ($divided) $max = $total / $this->post['page']['limit'];
        else $max = ceil($total / $this->post['page']['limit']);
        if ($max == 0) $max = $max + 1;
        if ($this->post['page']['index'] > $max) return [
            'error' => 1,
            'msg' => 'fail:page_max'
        ];

        // 分页查询
        $lists = Mongo::collection($this->model)->find($condition, [
            '$limit' => $this->post['page']['limit'],
            '$skip' => $this->post['page']['index'],
            '$sort' => ['create_time' => -1]
        ])->toArray();

        return [
            'error' => 0,
            'data' => [
                'lists' => $lists,
                'total' => $total,
            ]
        ];
    }
}