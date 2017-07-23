<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Session;
use  \app\common\model\Category as CategoryModel;

class Category extends Common
{

    protected $db;
    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->db = new CategoryModel();
    }

    public function index()
    {

        //获取首页全部数据
        $model = $this->db->getAllCate();
//        halt($model);

        return view( '' , compact( 'model' ) );
    }


    public function post()
    {
        $id = input('param.category_id');
        $model = $id?CategoryModel::find($id):new CategoryModel();
        if (\request()->isPost()) {

            $post = input('post.');
            $result = $model->validate(true)->allowField(true)->save($post);
            if (!$result===false) {

                return ['valid'=>1,'message'=>'操作成功'];
            } else {
                return ['valid'=>0,'message'=>$model->getError()];
            }
        }
        //获取所有栏目数据
        if ( !$id ) {
            //说明是添加
            $model = [ 'category_name' => '' , 'category_sort' => 100 , 'cate_pid' => 0 ,'category_describe'=>''];
        }
        if($id){
            //编辑
            $cateData = $this->db->getCateData($id);
        }else{
            //添加
            $cateData = $this->db->getAllCate();
        }

        return view( '',compact('cateData','model'));
    }


    public function del()
    {

           // 接收需要删除的数据id
        $id = input('param.category_id');
        $res = CategoryModel::destroy($id);
        if ($res) {
            return ['valid'=>1,'message'=>'操作成功'];
        }else{
            return ['valid'=>0,'message'=>'操作失败'];

        }

    }
}
