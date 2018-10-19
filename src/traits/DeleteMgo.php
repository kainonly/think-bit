<?php

namespace think\bit\traits;

use think\bit\facade\Mongo;
use think\Validate;

trait DeleteMgo
{
    public function delete()
    {
        // TODO:删除基本参数验证，主键为数组
        $validate = Validate::make($this->delete_validate);
        if (!$validate->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];
        if (method_exists($this, '__deleteBeforeHooks')) {
            $before_result = $this->__deleteBeforeHooks();
            if (!$before_result) return [
                'error' => 1,
                'msg' => 'before hooks failed!'
            ];
        }

        $result = Mongo::collection($this->model)->deleteMany($this->post['where'])->isAcknowledged();

        if ($result) {
            if (method_exists($this, '__deleteAfterHooks')) {
                if (!$this->__deleteAfterHooks()) return [
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