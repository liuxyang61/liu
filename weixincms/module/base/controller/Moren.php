<?php
namespace module\base\controller;

use houdunwang\request\Request;
use houdunwang\route\Controller;
use \module\base\model\Base;
use module\HdController;

class Moren extends HdController {

        //登陆验证




    //动作
    public function index(){
        //登陆验证
        $this->auth();
        //此处书写代码...
        if ( IS_POST ) {
            $base = new Base();
//            p(Request::post()); die;
            $base ->setConfig( Request::post() );
            return $this->setRedirect('refresh')->success('操作成功');
        }
        //获取数据库的数据
        $model = Base::find(1);
        //注意这个判断，如果能找到数据，将其转为数组，分配到页面，
        //找不到数据，默认给空数组
        $field = $model ? json_decode($model['default'],true) : [];
        //此处书写代码...
        return $this->template('',compact('field'));
//		return view();
    }
}
