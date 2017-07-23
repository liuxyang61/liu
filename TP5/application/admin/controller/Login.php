<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Login extends Controller
{
    /**
     * 登录页面
     * @return \think\Response
     */
    public function index()
    {
        $post=$_POST;
//        dump($post);
//        获取数据，，测试用
        //判断，是否为post提交
        if (Request::instance()->isAjax()){
            $admin = Db::table('admin')
                ->where('admin_name',$post['admin_name'])
                ->where('admin_password',$post['admin_password'])
                ->find();
//        halt($user);
//            dump($user);
//            halt($_POST);
            if(!captcha_check($post['admin_code'])){
                //验证失败
               return ['valid'=>0,'message'=>'验证码错误'];
            };

            //验证账号密码是否正确
            if ($admin) {

                //成功后将用户信息存入session中
               Session::set('admin',$admin);
//                halt(Session::get('user'));
//                $this->assign('user',$user['admin_user']);
                return ['valid'=>1,'message'=>'登录成功'];
            }else{
                return ['valid'=>0,'message'=>'用户名或密码错误'];
            }

        }

        return view();
    }

    /***
     * 注册
     */
    public function register()
    {
        if (Request::instance()->isPost()){
            echo 1;
        }

        return view();
    }
}
