<?php

namespace think\bit\traits;

use think\bit\facade\Mongo;
use MongoDB\BSON\UTCDateTime;

trait AddMgo
{
    public function add()
    {
        // 新增接口验证处理
        $validate = validate($this->model);
        if (!$validate->scene('add')->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];

        $this->post['create_time'] = $this->post['update_time'] = new UTCDateTime(time() * 1000);
        if (method_exists($this, '__addBeforeHooks')) {
            $before_result = $this->__addBeforeHooks();
            if (!$before_result) return [
                'error' => 1,
                'msg' => 'before hooks failed!'
            ];
        }

        $result = Mongo::collection($this->model)->insertOne($this->post)->isAcknowledged();

        if ($result) {
            if (method_exists($this, '__addAfterHooks')) {
                if (!$this->__addAfterHooks()) return [
                    'error' => 1,
                    'msg' => 'fail'
                ]; else return [
                    'error' => 0,
                    'msg' => 'ok'
                ];
            } else return [
                'error' => 0,
                'msg' => 'ok'
            ];
        } else return [
            'error' => 1,
            'msg' => 'fail'
        ];
    }
}