<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Query;
use think\Session;
use \app\common\model\Goods as GoodsModel;
use \app\common\model\Category;


class Goods extends Common
{

    protected $cate;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        //获取当前登录用户信息
        $user = Session::get('user');
        $this->assign('user',$user);
        $this->cate = new Category();
    }


    /***
     * 商品列表方法
     */
    public function goodsList()
    {

        $model = db('category')->alias('c')
            ->join('goods g','c.category_id=g.category_category_id')
            ->where('is_recovery',0)
            ->paginate(5);
        $page = $model->render();

        $model=$model->toArray();
//        $model['data']['ceart_time'] = time();
//        halt($model);
        foreach ($model['data'] as $k =>$v){
                $model['data'][$k]['create_time']= date('Y年m月d日 h时i分',$v['create_time']);
        }
//        halt($model);

        $this->assign('data',$model);
        $this->assign('page',$page);

        return view();
    }

    /***
     * 添加新商品方法
     */
    public function post()
    {
        $id = input('param.goods_id');

        $model = $id?GoodsModel::find($id):new GoodsModel();
        if (request()->isAjax()) {

            $post=input('post.');
            $post['goods_src']=implode('|',$post['goods_src']);
            $post['create_time']=time();
//                    halt($post);
                $result = $model->validate(true)->allowField(true)->save($post);
//            halt($result);
            if (false===$result){
                return ['valid'=>0,'message'=>$model->getError()];
            } else {
                return ['valid'=>1,'message'=>'操作成功'];
            }
        }
        if (!$id){
            $model['goods_src']='';
            $model['goods_id']=-1;
            $model['goods_describe']='';
            $model['category_category_id']=0;
        }
            $this->assign('oldData',$model);
        $cateData = $this->cate->getAllCate();
        return view('',compact('cateData'));
    }

    public function uploader()
    {

//            halt($_FILES);

// 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('Filedata');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            echo 'uploads/'.$info->getSaveName();
        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }
    }


    /***
     * 删除方法
     */
    public function del()
    {

//        接收需要删除的数据id
        $id = input('param.goods_id');
        $res = GoodsModel::destroy($id);
//        dump($res);

        if ($res) {
            return ['valid'=>1,'message'=>'操作成功'];
        }else{
            return ['valid'=>0,'message'=>'操作失败'];

        }
    }


    /***
     * 商品回收
     */
    public function recovery()
    {

//        $re = input('param.re');
////        halt($id);
//        halt($re);
        $id = input('param.goods_id');
        //修改这一条数据的is_recovery的值，变为1，这样首页就读取不到这条商品的数据，在回收站中可以收到
       $res = db('goods')->where('goods_id',$id)->setField('is_recovery',1);
//       halt($res);

        if ($res) {
            return ['valid'=>1,'message'=>'操作成功'];
        }else{
            return ['valid'=>0,'message'=>'操作失败'];
        }
    }

    /***
     * 回收站列表
     */
    public function recoverylist()
    {

        $data = db('category')->alias('c')
            ->join('goods g','c.category_id=g.category_category_id')
            ->where('is_recovery',1)
            ->select();
//        halt($data);

        return view('',compact('data'));
    }

    /***
     * 恢复商品
     */
    public function undo()
    {
        $id = input('param.goods_id');
        //修改这一条数据的is_recovery的值，变为1，这样首页就读取不到这条商品的数据，在回收站中可以收到
        $res = db('goods')->where('goods_id',$id)->setField('is_recovery',0);
//       halt($res);

        if ($res) {
            return ['valid'=>1,'message'=>'操作成功'];
        }else{
            return ['valid'=>0,'message'=>'操作失败'];
        }

    }














}

