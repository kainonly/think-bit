<?php

namespace bit\traits;

use bit\facade\Mongo;
use MongoDB\BSON\ObjectId;
use think\Validate;

trait GetMgo
{
    public function get()
    {
        $validate = Validate::make($this->get_validate);
        if (!$validate->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];

        $condition = $this->get_condition;
        if (isset($this->post['id'])) $condition = array_merge(
            $condition, ['_id' => new ObjectId($this->post['id'])]
        );
        if (isset($this->post['where'])) $condition = array_merge(
            $condition, $this->post['where']
        );

        $data = Mongo::collection($this->model)->findOne($condition);
        if (method_exists($this, '__getCustomReturn')) {
            return $this->__getCustomReturn($data);
        } else {
            return [
                'error' => 0,
                'data' => $data
            ];
        }
    }
}