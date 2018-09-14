<?php

namespace bit\traits;

use think\Db;
use think\Validate;

trait DeleteModel
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
        // 数据库事务
        $transaction = Db::transaction(function () {
            if (isset($this->post['id'])) {
                $result = Db::name($this->model)->where('id', 'in', $this->post['id'])->delete();
            } else {
                $result = Db::name($this->model)->where($this->post['where'])->delete();
            }
            if (method_exists($this, '__deleteAfterHooks')) {
                $after_result = $this->__deleteAfterHooks();
                if (!$after_result) Db::rollback();
                return $result && $after_result;
            } else {
                return $result;
            }
        });
        // 返回结果
        if ($transaction) return [
            'error' => 0,
            'msg' => 'ok'
        ];
        else return [
            'error' => 1,
            'msg' => 'fail'
        ];
    }
}