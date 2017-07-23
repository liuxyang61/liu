<?php
namespace app\admin\controller;
use houdunwang\request\Request;
use \system\model\Category as CategoryModel;
class Category extends Common
{
    public function __construct()
    {
        //调用common中的auth方法，进行登陆验证
        $this->auth();
    }
    //动作
    public function index(CategoryModel $category)
    {
//
////       new \system\model\Category()
//        //获取所有数据，模板使用
        $cateData = $category->getAllCate();
//            p($cateData);
//        //加载模板并且分配变量
        View::with('cateData', $cateData);
        return view();
    }

//    添加和编辑

    public function post(CategoryModel $category)
    {

        //数据主键id
        $cate_id = Request::get('cate_id',0,'intval');
        //添加数据
        if (IS_POST)
        {
            if ($cate_id)
            {
                //这里是编辑功能，用手册中的更新方法，find方法
                $category = CategoryModel::find($cate_id);
            }
            //执行save进行数据新增
            $category->save( Request::post() );
            //请求回应
         return   message( '操作成功' , 'index' );
        }


        //处理旧数据
        if($cate_id){

            //走到这里表示是编辑功能
            $oldData = CategoryModel::find($cate_id);
//            p($oldData->toArray());
            View::with('oldData',$oldData);
            //所属栏目数据，需要去掉自己和自己的所有子级
            $cateData = $category->getSonCateData($cate_id);
            //p($cateData);
        }else{
            //走到这里表示是添加栏目

            //获取栏目所有数据，数据要放在添加页面中所属栏目
            $cateData = $category->getAllCate();
//            p($cateData);
        }
        //分配变量
        View::with( 'cateData' , $cateData );

        return view();



    }


    //删除方法
    public function del(CategoryModel $category)
    {

//        //获取要删除的数据主键id
         $cate_id = Request::get('cate_id',0,'intval');
//         p($cate_id);
//        //调用模型执行删除
         $res = $category->del($cate_id);

//         p($res['valid']);
//         成功提示
        if ($res['valid'])
        {
//            message('nihao ','index');
//            echo 1;
          return  message($res['msg'], $redirect = 'index', $type = 'success', $timeout = 2);
//            go('index');
//            echo 3;
        }else{

        }
    }
}
