<?php

namespace app\admin\validate;

use think\Validate;

class Category extends Validate
{
	//验证规则
	protected $rule = [
		'category_name'  =>  'require',
		'category_sort'=>    'require',
		'category_describe'=>    'require',

	];
	//定义提示消息
	protected $message = [
		'category_name.require'  =>  '分类名称必须输入',
		'category_sort.require'  =>  '分类排序必须输入',
		'category_describe.require'  =>  '分类描述必须输入',
	];

}