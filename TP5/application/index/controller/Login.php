<?php

namespace app\index\controller;

use app\common\model\User;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Login extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //登录
        if (\request()->isAjax()) {
        $post = input('post.');
//        halt($post);
            if (empty($post['user_name'] )|| empty($post['user_password']))
            {
                return ['valid'=>0,'message'=>'请输入用户名或者密码'];
            }
            if (empty($post['user_code'] ))
            {
                return ['valid'=>0,'message'=>'请输入验证码'];
            }
            //验证码比对
            if(!captcha_check($post['user_code'])){
                //验证失败
                return ['valid'=>0,'message'=>'验证码错误'];
            };
            $user = Db::table('user')
                ->where('user_name',$post['user_name'])
                ->where('user_password',md5($post['user_password']))
                ->find();
            //验证账号密码是否正确
            if ($user) {
                //成功后将用户信息存入session中
                Session::set('user',$user);
                return ['valid'=>1,'message'=>'登录成功'];
            }else{
                return ['valid'=>0,'message'=>'用户名或密码错误'];
            }


        }


        return view('');
    }

    public function register()
    {

        if (\request()->isPost()) {
            $post = input('post.');
//            halt($post);
            if ($post['user_password']!==$post['confirm_password']) {
                return ['valid'=>0,'message'=>'两次密码不一致'];
            }

            $post['user_password']=md5($post['user_password']);
            $user = new User();
            $res =  $user->validate(true)->allowField(true)->save($post);

//            dump($res);
            if ($res) {
                return ['valid'=>1,'message'=>'注册成功'];
            } else {
                return ['valid'=>0,'message'=>'注册失败'];
            }

        }

        return view();
    }
}
