<?php

namespace app\index\validate;

use think\Validate;

class User extends Validate
{
	//验证规则
	protected $rule = [
		'user_name'  =>  'require',
		'user_email'  =>  'notIn:0',
		'user_phone'=>    'require',
		'user_password'=>    'require',

	];
	//定义提示消息
	protected $message = [
		'user_name.require'  =>  '用户名必须输入',
		'user_email.require'  =>  '邮箱必须输入',
        'user_phone.require'=> '手机号码必须输入',
        'user_password.require'  =>  '用户密码必须输入',
	];

}