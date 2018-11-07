<?php

namespace think\bit\traits;

use think\Db;

trait AddModel
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
        $this->post['create_time'] = $this->post['update_time'] = time();
        if (method_exists($this, '__addBeforeHooks')) {
            $before_result = $this->__addBeforeHooks();
            if (!$before_result) return $this->add_before_result;
        }
        $result_fail = [
            'error' => 0,
            'msg' => 'fail'
        ];

        // 执行事务写入
        $transaction = Db::transaction(function () {
            // 判断是否有后置处理
            if (!method_exists($this, '__addAfterHooks')) {
                return Db::name($this->model)->insert($this->post);
            } else {
                $result_id = Db::name($this->model)->insertGetId($this->post);
                $after_result = $this->__addAfterHooks($result_id);
                if (!$after_result) {
                    $result_fail = $this->add_after_result;
                    Db::rollback();
                }
                return $result_id && $after_result;
            }
        });
        if ($transaction) return [
            'error' => 0,
            'msg' => 'ok'
        ];
        else return $result_fail;
    }
}