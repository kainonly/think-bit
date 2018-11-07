<?php

namespace think\bit\traits;

use think\bit\facade\Mongo;
use MongoDB\BSON\ObjectId;
use think\Validate;

trait GetMongoDB
{
    public function get()
    {
        // 通用验证
        $validate = Validate::make($this->get_validate);
        if (!$validate->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];

        $condition = $this->get_condition;
        
        // 判断是否存在id
        if (isset($this->post['id'])) $condition = array_merge(
            $condition, ['_id' => new ObjectId($this->post['id'])]
        );

        // 判断是否有条件存在
        if (isset($this->post['where'])) $condition = array_merge(
            $condition, $this->post['where']
        );

        // 执行查询
        $data = Mongo::collection($this->model)->findOne($condition);

        // 判断是否自定义返回
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