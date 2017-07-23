<?php
namespace app\admin\controller;
use app\admin\controller;
use app\common\Admin;
use think\Request;
use think\Session;
use think\View;

class Index extends Common
{
    public function __construct(Request $request)
    {
        parent::__construct($request);

    }

    public function index()
    {


        return view();
    }


    public function changePassword()
    {
        $id=$_GET['id'];
        if (Request::instance()->isPost()) {
//        halt($id);
            //调用模型进行修改密码
            $model = new Admin();
            $model->changePassword($id,$_POST);
//        return $this->success('操作成功,请重新登录','admin/login/index');

        }

        return view('changePassword');
    }














}