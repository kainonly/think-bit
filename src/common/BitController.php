<?php

namespace think\bit\common;

use think\Controller;

abstract class BitController extends Controller
{
    protected $model;
    protected $post = [];

    protected $origin_lists_default_validate = [
        'where' => 'array'
    ];
    protected $origin_lists_before_result = [
        'error' => 1,
        'msg' => 'error:before_fail'
    ];
    protected $origin_lists_condition = [];
    protected $origin_lists_condition_query = null;
    protected $origin_lists_orders = 'create_time desc';
    protected $origin_lists_field = ['update_time,create_time', true];

    protected $lists_default_validate = [
        'page' => 'require',
        'page.limit' => 'require|number|between:1,50',
        'page.index' => 'require|number|min:1',
        'where' => 'array'
    ];
    protected $lists_before_result = [
        'error' => 1,
        'msg' => 'error:before_fail'
    ];
    protected $lists_condition = [];
    protected $lists_condition_query = null;
    protected $lists_orders = 'create_time desc';
    protected $lists_field = ['update_time,create_time', true];

    protected $get_default_validate = [
        'id' => 'requireWithout:where|number',
        'where' => 'requireWithout:id|array'
    ];
    protected $get_before_result = [
        'error' => 1,
        'msg' => 'error:before_fail'
    ];
    protected $get_condition = [];
    protected $get_field = ['update_time,create_time', true];

    protected $add_default_validate = [];
    protected $add_before_result = [
        'error' => 1,
        'msg' => 'error:before_fail'
    ];
    protected $add_after_result = [
        'error' => 1,
        'msg' => 'error:after_fail'
    ];
    protected $add_fail_result = [
        'error' => 1,
        'msg' => 'error:insert_fail'
    ];

    protected $edit_default_validate = [
        'id' => 'require|number',
        'switch' => 'require|bool'
    ];
    protected $edit_switch = false;
    protected $edit_before_result = [
        'error' => 1,
        'msg' => 'error:before_fail'
    ];
    protected $edit_condition = [];
    protected $edit_fail_result = [
        'error' => 1,
        'msg' => 'error:fail'
    ];
    protected $edit_after_result = [
        'error' => 1,
        'msg' => 'error:after_fail'
    ];

    protected $delete_default_validate = [
        'id' => 'require'
    ];
    protected $delete_before_result = [
        'error' => 1,
        'msg' => 'error:before_fail'
    ];
    protected $delete_condition = [];
    protected $delete_prep_result = [
        'error' => 1,
        'msg' => 'error:prep_fail'
    ];
    protected $delete_fail_result = [
        'error' => 1,
        'msg' => 'error:fail'
    ];
    protected $delete_after_result = [
        'error' => 1,
        'msg' => 'error:after_fail'
    ];

    protected function initialize()
    {
        $this->post = input('post.');
    }
}