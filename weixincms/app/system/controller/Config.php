<?php namespace app\system\controller;

use houdunwang\request\Request;
use houdunwang\route\Controller;
use system\model\Config as ConfigModel;

class Config extends Common {
    public function __construct()
    {
        //调用common中的auth方法，进行登陆验证
        $this->auth();
    }
    //动作
    public function index(ConfigModel $config){
        //此处书写代码...
        if ( IS_POST ) {
//            p(Request::post()); die;
            $config->setConfig( Request::post() );
            return $this->setRedirect('refresh')->success('操作成功');
        }
        //获取数据库的数据
        $model = ConfigModel::find(1);
        //注意这个判断，如果能找到数据，将其转为数组，分配到页面，
        //找不到数据，默认给空数组
        $field = $model ? json_decode($model['system'],true) : [];
        //此处书写代码...
        return view( '' ,compact('field'));
//        return view();
    }
}
