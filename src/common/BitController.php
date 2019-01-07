<?php

namespace think\bit\common;

use think\Controller;

abstract class BitController extends Controller
{
    /**
     * 模型名称
     * @var string
     */
    protected $model;

    /**
     * 请求数据
     * @var array
     */
    protected $post = [];

    /**
     * 列表数据前置返回
     * @var array
     */
    protected $lists_origin_before_result = [
        'error' => 1,
        'msg' => 'error:before_fail'
    ];

    /**
     * 列表数据固定条件
     * @var array
     */
    protected $lists_origin_condition = [];

    /**
     * 列表数据排序设定
     * @var string
     */
    protected $lists_origin_orders = 'create_time desc';

    /**
     * 列表数据固定返回字段
     * @var array
     */
    protected $lists_origin_field = ['update_time,create_time', true];

    /**
     * 分页数据前置返回
     * @var array
     */
    protected $lists_before_result = [
        'error' => 1,
        'msg' => 'error:before_fail'
    ];

    /**
     * 分页列表数据固定条件
     * @var array
     */
    protected $lists_condition = [];

    /**
     * 分页数据排序设定
     * @var string
     */
    protected $lists_orders = 'create_time desc';

    /**
     * 分页数据固定返回字段
     * @var array
     */
    protected $lists_field = ['update_time,create_time', true];

    /**
     * 单条数据验证器
     * @var array
     */
    protected $get_validate = ['id' => 'require'];

    /**
     * 单条数据前置返回
     * @var array
     */
    protected $get_before_result = [
        'error' => 1,
        'msg' => 'error:before_fail'
    ];

    /**
     * 单条数据固定条件
     * @var array
     */
    protected $get_condition = [];

    /**
     * 单条数据固定返回字段
     * @var array
     */
    protected $get_field = ['update_time,create_time', true];

    /**
     * 新增自定义前置返回
     * @var array
     */
    protected $add_before_result = [
        'error' => 1,
        'msg' => 'error:before_fail'
    ];

    /**
     * 新增后置返回结果
     * @var array
     */
    protected $add_after_result = [
        'error' => 1,
        'msg' => 'error:after_fail'
    ];

    /**
     * 新增执行失败返回结果
     * @var array
     */
    protected $add_fail_result = [
        'error' => 1,
        'msg' => 'error:insert_fail'
    ];

    /**
     * 修改数据验证器
     * @var array
     */
    protected $edit_validate = [
        'id' => 'require',
        'switch' => 'bool'
    ];

    /**
     * 修改自定义前置返回
     * @var array
     */
    protected $edit_before_result = [
        'error' => 1,
        'msg' => 'error:before_fail'
    ];

    protected $edit_fail_result = [
        'error' => 1,
        'msg' => 'error:fail'
    ];

    /**
     * 修改自定义后置返回
     * @var array
     */
    protected $edit_after_result = [
        'error' => 1,
        'msg' => 'error:after_fail'
    ];

    /**
     * 状态切换请求
     * @var bool
     */
    protected $edit_status_switch = false;

    /**
     * 删除数据验证器
     * @var array
     */
    protected $delete_validate = [
        'id' => 'require'
    ];

    /**
     * 删除自定义前置返回
     * @var array
     */
    protected $delete_before_result = [
        'error' => 1,
        'msg' => 'error:before_fail'
    ];

    /**
     * 事务开启之后，数据执行之前
     * @var array
     */
    protected $delete_prep_result = [
        'error' => 1,
        'msg' => 'error:prep_fail'
    ];

    /**
     * 删除通用错误
     * @var array
     */
    protected $delete_fail_result = [
        'error' => 1,
        'msg' => 'error:fail'
    ];

    /**
     * 删除自定义后置返回
     * @var array
     */
    protected $delete_after_result = [
        'error' => 1,
        'msg' => 'error:after_fail'
    ];


    protected function initialize()
    {
        $this->post = input('post.');
    }

    /**
     * 空函数处理
     * @return array
     */
    public function _empty()
    {
        return [];
    }

}