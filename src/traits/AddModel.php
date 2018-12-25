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

        // 执行事务写入
        $transaction = Db::transaction(function () {
            // 判断是否有后置处理
            if (!method_exists($this, '__addAfterHooks')) {
                return Db::name($this->model)->insert($this->post);
            } else {
                // 已存在主键id
                if (isset($this->post['id']) && !empty($this->post['id'])) {
                    $result_id = $this->post['id'];
                    $result = Db::name($this->model)->insert($this->post);

                    if (!$result) {
                        Db::rollback();
                        return false;
                    }
                } else {
                    $result_id = Db::name($this->model)->insertGetId($this->post);
                }

                if (!$result_id) {
                    Db::rollback();
                    return false;
                }

                $after_result = $this->__addAfterHooks($result_id);
                if (!$after_result) {
                    $this->add_fail_result = $this->add_after_result;
                    Db::rollback();
                    return false;
                }

                return true;
            }
        });
        if ($transaction) return [
            'error' => 0,
            'msg' => 'ok'
        ]; else {
            return $this->add_fail_result;
        }
    }
}