<?php

namespace think\bit\traits;

use think\bit\facade\Mongo;
use think\Validate;

trait DeleteMongoDB
{
    public function delete()
    {
        // 通用验证
        $validate = Validate::make($this->delete_validate);
        if (!$validate->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];

        // 判断是否有前置处理
        if (method_exists($this, '__deleteBeforeHooks')) {
            $before_result = $this->__deleteBeforeHooks();
            if (!$before_result) return $this->delete_before_result;
        }
        
        // 执行删除
        $result = Mongo::collection($this->model)->deleteMany($this->post['where'])->isAcknowledged();
        if ($result) {
            // 判断是否有后置处理
            if (method_exists($this, '__deleteAfterHooks')) {
                if (!$this->__deleteAfterHooks()) return $this->delete_after_result;
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
            'msg' => 'fail:delete'
        ];
    }
}