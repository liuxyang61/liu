<?php

namespace app\admin\controller;

use houdunwang\session\Session;
use system\model\Admin;

/**
 * 登录管理控制器
 * Class Login
 * @package app\admin\controller
 */
class Login
{
    public function index()
    {
    	//测试数据库连接
			//$res = Db::table('admin')->get();
			//p($res);
		//测试通过模型操作数据
			//$res = (new Admin())->get();
			//p($res);
		if(IS_POST)
		{
			//echo p(1);die;
			$res = (new Admin())->login();
            if($res['valid']) {
                //执行成功
             return   message( $res['msg'], u('admin.entry.index'), $type = 'success', $timeout = 3 );
            }else{
                //执行失败
                return   message($res['msg'],'back','error');
            }
		}
        //加载模板文件
		return View::make();
    }
    /**
	 * 验证码
	 */
    public function code()
	{
//		Code::width(v('config.codeW'))->height(v('config.codeH'))->num(v('config.code'))->make();
        $num = v('config.code')?:1;
		Code::width(100)->height(50)->num($num)->make();
	}


	//退出登陆
	public function out()
    {
        //清空session所有数据
        Session::flush();
        go('admin.login.index');
    }

    //修改密码
    public function setPassword()
    {

        if (IS_POST)
        {
            $newpassword =Admin::setNewPassword();
            if ($newpassword)
            {
                //操作成功
                return   message( $newpassword['msg'], u('admin.entry.index'), $type = 'success', $timeout = 3 );

            }else{
//                操作失败
                return   message( $newpassword['msg'], 'admin.login.setPassword', $type = 'error', $timeout = 3 );
            }

        }

        return view();
    }
}