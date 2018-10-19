<?php

namespace think\bit\traits;

use think\Db;

trait AddModel
{
    public function add()
    {
        // 新增接口验证处理
        $validate = validate($this->model);
        if (!$validate->scene('add')->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];

        $this->post['create_time'] = $this->post['update_time'] = time();
        if (method_exists($this, '__addBeforeHooks')) {
            $before_result = $this->__addBeforeHooks();
            if (!$before_result) return [
                'error' => 1,
                'msg' => 'before hooks failed!'
            ];
        }
        // 数据库事务
        $transaction = Db::transaction(function () {
            if (!method_exists($this, '__addAfterHooks')) {
                return Db::name($this->model)->insert($this->post);
            } else {
                $result_id = Db::name($this->model)->insertGetId($this->post);
                $after_result = $this->__addAfterHooks($result_id);
                if (!$after_result) Db::rollback();
                return $result_id && $after_result;
            }
        });
        // 返回结果
        if ($transaction) return [
            'error' => 0,
            'msg' => 'ok'
        ]; else return [
            'error' => 1,
            'msg' => 'fail'
        ];
    }
}