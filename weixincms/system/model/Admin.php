<?php

namespace system\model;

use houdunwang\model\Model;
use houdunwang\request\Request;

class Admin extends model
{
	//操作的数据表
	protected $table = "admin";

    //自动验证
    protected $validate=[
        //['字段名','验证方法','提示信息',验证条件,验证时间]
        [ 'admin_username', 'isnull', '用户名不能为空', self::MUST_VALIDATE ],
        [ 'admin_password', 'isnull', '密码不能为空', self::MUST_VALIDATE ],
//        [ 'code', 'isnull', '验证码不能为空', self::MUST_VALIDATE ]
        ];



	//登录
	public function login()
	{
		//echo 'login';die;
        //调用自动验证
        $res = Validate::make($this->validate);
//        p($res);
        if($res===false){
            return ['valid'=>0,'msg'=>Validate::getError()];
            //print_r(Validate::getError());
        }
//        验证码是否正确
        if(strtolower(Code::get())!=strtolower($_POST['code'])) {
            return ['valid'=>0,'msg'=>'验证码不正确'];
        }
//       验证用户名密码是否正确
        $userInfo = $this->where('admin_username',$_POST['admin_username'])
            ->where('admin_password', Crypt::encrypt($_POST['admin_password']))->first();
//        p(Crypt::encrypt($_POST['admin_password']));die;
        if(!$userInfo){
            //用户名密码不对
            return ['valid'=>0,'msg'=>'用户名或者密码不正确'];
        }

//        验证通过 ，存‘session’
        Session::set('admin.admin_id',$userInfo['admin_id']);
        Session::set('admin.admin_username',$userInfo['admin_username']);
        return ['valid'=>1,'msg'=>'登录成功'];

	}


	public function setNewPassword()
    {
        //获取新密码
        $newpass = Request::post();
        //判断两次输入的是否一样
        if ($newpass['newpasswordOne']==$newpass['newpasswordTwo'])
        {

//            p(Session::get("admin.admin_username"));
            //相同的输入，将数据库中的admin账户的密码修改
            //加密密码
            $newpass = Crypt::encrypt($newpass['newpasswordOne']);
         $res =    Db::table('admin')->where("admin_username",  Session::get("admin.admin_username"))->update(['admin_password'=>$newpass]);
                return ['valid'=>1,'msg'=>'修改密码成功'];
        }else{
            return ['valid'=>0,'msg'=>'两次密码不一致'];
        }

    }

}