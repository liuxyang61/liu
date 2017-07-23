<?php namespace system\model;
use houdunwang\model\Model;
class Article extends Model{
	//数据表
	protected $table = "article";

	//允许填充字段
	protected $allowFill = ['*'];

	//禁止填充字段
	protected $denyFill = [ ];

	//自动验证
	protected $validate=[
		//['字段名','验证方法','提示信息',验证条件,验证时间]
        ['arc_title','required','请输入文章标题',3,3],
//        ['arc_content','required','请输入文章内容',3,3],
        ['arc_description','required','请输入描述',3,3],
        ['arc_author','required','请输入文章作者',3,3],
        ['cate_cid','required','请选择所属栏目',3,3],
	];

	//自动完成
	protected $auto=[
		//['字段名','处理方法','方法类型',验证条件,验证时机]
        ['arc_ishot',0,'string',5,self::MODEL_BOTH],
        ['arc_iscommed',0,'string',5,self::MODEL_BOTH],
	];

	//自动过滤
    protected $filter=[
        //[表单字段名,过滤条件,处理时间]
    ];

	//时间操作,需要表中存在created_at,updated_at字段
	protected $timestamps=true;
}