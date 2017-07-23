<?php

namespace app\wechat\controller;

use houdunwang\route\Controller;



abstract class Common extends Controller
{
	//执行中间件，进行登录验证
	//final 最终意思，不允许子类重写auth方法
	//加上final之后，如果子类出现auth方法，报错
	final public function auth()
	{
		Middleware::set('auth');
	}
}