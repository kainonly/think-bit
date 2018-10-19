<?php

namespace bit\traits;

use bit\facade\Mongo;
use bit\validate;

trait ListsMgo
{
    public function lists()
    {
        // TODO:验证分页参数
        $validate = new validate\Lists;
        if (!$validate->scene('page')->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];
        $condition = $this->lists_condition;
        if (isset($this->post['where'])) $condition = array_merge(
            $condition, $this->post['where']
        );

        $total = Mongo::collection($this->model)->countDocuments($condition);
        $divided = $total % $this->post['page']['limit'] == 0;
        if ($divided) $max = $total / $this->post['page']['limit'];
        else $max = ceil($total / $this->post['page']['limit']);
        if ($max == 0) $max = $max + 1;
        if ($this->post['page']['index'] > $max) return [
            'error' => 1,
            'msg' => lang('page index between')
        ];

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