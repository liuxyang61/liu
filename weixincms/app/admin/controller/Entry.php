<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace app\admin\controller;

/**
 * 后台首页管理控制器
 * Class Entry
 * @package app\admin\controller
 */
class Entry extends Common
{
    public function __construct()
    {
        //调用common中的auth方法，进行登陆验证
        $this->auth();
    }
    public function index()
    {
        //加载模板文件
		return view('copyright');
    }

        public function code()
        {
            message('nihao','index');
        }
}