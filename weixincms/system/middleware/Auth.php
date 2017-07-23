<?php namespace system\middleware;

use houdunwang\middleware\build\Middleware;

class Auth implements Middleware{
	//执行中间件
	public function run($next) {
        if(!Session::get('admin.admin_id'))
        {
            //跳转到登录页面
            go('admin.login.index');
        }
         $next();
	}
}