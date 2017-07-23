<?php

namespace app\admin\controller;

use houdunwang\route\Controller;

class Common extends Controller
{
	public function auth()
	{
        //执行登录验证
        //set（）中的参数，参照system\config\middleware.php中controller中实例化auth类的下标变量。
        Middleware::set('auth');
	}
}