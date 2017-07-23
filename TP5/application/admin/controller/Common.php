<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Session;

class Common extends Controller
{
    /***
     * 自动触发登录验证
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        //判断是否登录
        if (!Session::has('admin')) {

            //跳转到登录页面
            $this->redirect('/admin/login/index');
        }

        $this->getAdminInfo();
    }


    public function getAdminInfo()
    {
        //获取当前登录用户信息
        $admin = Session::get('admin');
//        halt($admin);
        if (empty($admin)) {
            $admin = [
                'admin_user'=>'',
                'admin_id'=>0,
            ];
        }
        $this->assign('admin',$admin);
    }
}
