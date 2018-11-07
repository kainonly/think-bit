<?php

namespace think\bit\traits;

use think\bit\facade\Mongo;
use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;
use think\Validate;

trait EditMongoDB
{
    public function edit()
    {
        // 通用验证
        $validate = Validate::make($this->edit_validate);
        if (!$validate->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];

        // 判断是否为开关请求
        if (isset($this->post['switch']) && $this->post['switch']) {
            $this->edit_status_switch = true;
        } else {
            $validate = validate($this->model);
            if (!$validate->scene('edit')->check($this->post)) return [
                'error' => 1,
                'msg' => $validate->getError()
            ];
        }

        // 判断是否有前置处理
        unset($this->post['switch']);
        $this->post['update_time'] = new UTCDateTime(time() * 1000);
        if (method_exists($this, '__editBeforeHooks')) {
            $before_result = $this->__editBeforeHooks();
            if (!$before_result) return $this->edit_before_result;
        }

        // 判断是通用主键或条件更新
        if (isset($this->post['id'])) {
            $object_id = new ObjectId($this->post['id']);
            unset($this->post['where'], $this->post['id']);
            $result = Mongo::collection($this->model)->updateOne(
                ['_id' => $object_id],
                ['$set' => $this->post]
            )->isAcknowledged();
        } else {
            $condition = $this->post['where'];
            unset($this->post['where']);
            $result = Mongo::collection($this->model)->updateOne(
                [$condition],
                ['$set' => $this->post]
            )->isAcknowledged();
        }

        if ($result) {
            // 判断是否有后置处理
            if (method_exists($this, '__editAfterHooks')) {
                if (!$this->__editAfterHooks()) return $this->edit_after_result;
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
            'msg' => 'fail:edit'
        ];
    }
}