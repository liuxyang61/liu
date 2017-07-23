<?php namespace system\model;
use houdunwang\model\Model;
class Config extends Model{
	//数据表
	protected $table = "config";

	//允许填充字段
	protected $allowFill = [ ];

	//禁止填充字段
	protected $denyFill = [ ];

	//自动验证
	protected $validate=[
		//['字段名','验证方法','提示信息',验证条件,验证时间]
//        ['arc_num','isnull','请输入文章分页数量',3,3],
//        ['code','isnull','请输入验证码数量',3,3],
//        ['codeW','isnull','请输入验证码宽度',3,3],
//        ['code','isnull','请输入验证码宽高度',3,3],
//        ['icp','isnull','请输入备案号',3,3],
//        ['tel','isnull','请输入客服电话',3,3],
//        ['email','isnull','请输入站长邮箱',3,3],
//        ['description','isnull','请输入网站描述',3,3],
//        ['webname','isnull','请输入网站名称',3,3],
    ];

	//自动完成
	protected $auto=[
		//['字段名','处理方法','方法类型',验证条件,验证时机]
	];

	//自动过滤
    protected $filter=[
        //[表单字段名,过滤条件,处理时间]
    ];

	//时间操作,需要表中存在created_at,updated_at字段
	protected $timestamps=true;

	//这是系统配置项
	public function setConfig($post)
	{
//	    获取数据，如果有，就更新
		$model = Config::find(1);
		if(!$model) {
//            说明数据表找数据，执行添加
			$model = $this;
		}
//		执行赋值
		$model->system = json_encode($post,JSON_UNESCAPED_UNICODE);
		$model->save();
	}
	//设置微信配置项
	public function setWexinConfig($post)
	{
		$model = Config::find(1);
		if(!$model) {
			//说明数据表找不到id=1数据，执行添加
			$model = $this;
			//这句话，相当于楼上这一句
//			$model = new static();
		}
		$model->weixin = json_encode($post,JSON_UNESCAPED_UNICODE);
		$model->save();
	}
}