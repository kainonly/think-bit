<?php

namespace think\bit\traits;

use think\Db;

/**
 * Trait AddModel
 * @package think\bit\traits
 * @property string model 模型名称
 * @property array post 请求主体
 * @property array add_before_result 前置返回结果
 * @property array add_after_result 后置返回结果
 * @property array add_fail_result 新增执行失败结果
 */
trait AddModel
{
    public function add()
    {
        $validate = validate($this->model);
        if (!$validate->scene('add')->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];

        $this->post['create_time'] = $this->post['update_time'] = time();

        // 检测是否有前置处理
        if (method_exists($this, '__addBeforeHooks') &&
            !$this->__addBeforeHooks()) {
            return $this->add_before_result;
        }

        return !Db::transaction(function () {
            // 检测是否有后置处理
            if (!method_exists($this, '__addAfterHooks')) {
                return Db::name($this->model)->insert($this->post);
            }

            $id = null;
            if (isset($this->post['id'])) {
                $id = $this->post['id'];
                $result = Db::name($this->model)->insert($this->post);
                if (!$result) return false;
            } else {
                $id = Db::name($this->model)->insertGetId($this->post);
            }

            if (empty($id) || !$this->__addAfterHooks($id)) {
                $this->add_fail_result = $this->add_after_result;
                Db::rollback();
                return false;
            }

            return true;
        }) ? $this->add_fail_result : [
            'error' => 0,
            'msg' => 'ok'
        ];
    }
}