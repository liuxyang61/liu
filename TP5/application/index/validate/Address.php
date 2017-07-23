<?php

namespace app\index\validate;

use think\Validate;

class Address extends Validate
{
	//验证规则
	protected $rule = [
		'ress_name'  =>  'require',
		'ress_city'  =>  'require',
		'ress_county'=>    'require',
		'ress_house'=>    'require',
		'ress_code'=>    'require',
		'ress_phone'=>    'require',

	];
	//定义提示消息
	protected $message = [
		'ress_name.require'  =>  '收货人名称必须输入',
		'ress_city.require'  =>  '收货地址必须选全',
        'ress_county.require'=> '收货地址必须选全',
        'ress_house.require'  =>  '请输入详细地址',
        'ress_code.require'  =>  '邮编必须输入',
        'ress_phone.require'  =>  '联系电话必须输入',
	];

}