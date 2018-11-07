<?php

namespace think\bit\traits;

use think\bit\facade\Mongo;
use MongoDB\BSON\UTCDateTime;

trait AddMongoDB
{
    public function add()
    {
        // 通用验证
        $validate = validate($this->model);
        if (!$validate->scene('add')->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];

        // 判断是否有前置处理
        $this->post['create_time'] = $this->post['update_time'] = new UTCDateTime(time() * 1000);
        if (method_exists($this, '__addBeforeHooks')) {
            $before_result = $this->__addBeforeHooks();
            if (!$before_result) return $this->add_before_result;
        }

        // 通用写入
        $result = Mongo::collection($this->model)->insertOne($this->post)->isAcknowledged();
        if ($result) {
            // 判断是否有后置处理
            if (method_exists($this, '__addAfterHooks')) {
                if (!$this->__addAfterHooks()) return $this->add_after_result;
                else return [
                    'error' => 0,
                    'msg' => 'ok'
                ];
            } else return [
                'error' => 0,
                'msg' => 'ok'
            ];
        } else return [
            'error' => 1,
            'msg' => 'fail:insert'
        ];
    }
}