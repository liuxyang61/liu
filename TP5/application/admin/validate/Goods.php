<?php

namespace app\admin\validate;

use think\Validate;

class Goods extends Validate
{
	//验证规则
	protected $rule = [
		'goods_name'  =>  'require',
		'category_category_id'  =>  'notIn:0',
		'goods_price'=>    'require',
		'goods_src'=>    'require',
		'goods_describe'=>    'require',

	];
	//定义提示消息
	protected $message = [
		'goods_name.require'  =>  '商品名称必须输入',
		'goods_price.require'  =>  '商品价格必须输入',
		'goods_src.require'  =>  '请选择商品图片',
        'goods_describe.require'=> '商品描述必须输入',
//        'category_category_id.require'=> '请选择商品类别',
        'category_category_id.notIn'=> '请选择商品类别',
	];

}