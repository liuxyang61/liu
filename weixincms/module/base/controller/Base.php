<?php
namespace module\base\controller;

use houdunwang\db\Db;
use houdunwang\request\Request;
use houdunwang\view\View;
use module\base\model\Base_content;
use module\HdController;
use module\Wechat;
use system\model\Keywords;

class Base extends HdController
{



    public function index()
    {
        //登陆验证
        $this->auth();
        $base = Db::table('base_content')
            ->join('keywords','keywords.module_id','=','base_content.id')
            ->where('module','base')
            ->get();

//        Db::table('user')
//            ->join('class','user.cid','=','class.cid')
//            ->join('contacts','user.id','=','contacts.uid')
//            ->get()

//        return $this->template( '' , compact( 'field' ) );
        //p($base);
        //分配变量
        //执行加载模板
       return $this->template('',compact('base'));
    }

    /***
     * 添加编辑方法
     * @return array|mixed
     */
    public function post()
    {
        //接受git参数。
        $id = Request::get('id',0,'intval');
        //声明变量，接受实例化Base_content模型的对象.
        //如果有这个id，就是编辑(找出这条数据),没有这个id，就是添加(新实例出一个模型)
        $baseModel = Base_content::find( $id ) ? : new Base_content();
//        p($id);
        //判断是否为POST提交，
        if(IS_POST)
        {
            //接受POST参数。
            $post = Request::post();
            //执行添加
            $baseModel->save( $post );
            //p($post);
            //添加关键词表
            //数据库中没有添加的字段，给压进去
            $post['module_id'] = $baseModel['id'];
            //执行添加关键词，这里调用的是tatit中的添加关键词方法。将$post传进去。
            $this->saveKeywords($post);
            //成功提示，跳转页面
            return $this->setRedirect(url('base.index'))->success('操作成功');

        }
        if ($id)
        {
//            //走到这里表示有id参数，那么将进行编辑
//            //找到当前数据，需要进行多表关联
            $base =Db::table('base_content')
                ->join('keywords','base_content.id','=','keywords.module_id')
                ->where('base_content.id',$id)
                ->get();
            //调用编辑方法，
//            $this->editkeywords($base);
//            p($base);
        }

//调用Wechat类中assignKeywords(base_content表的主键)
        $this->assignKeywords($id);
//        加载模板
        return $this->template('',compact('base'));
    }

    /***
     * 删除方法
     * @return array
     */
    public function del()
    {
        $id = Request::get('id');
        $id = Keywords::find($id)->module_id;
//        p($id);die;
//        p($id);die;
        //实例化模型，找到需要删除的数据
        $baseModel = Base_content::find($id);
//        p($baseModel);die;
        //执行删除方法
        $baseModel->destory();
        //结束需要删除的id
        $id = Request::get('id');
        //这里是执行删除关键词的方法，在wechat类中书写着。
        $this->delKeywords($id);
        //成功提示
        return $this->setRedirect(url('base.index'))->success('操作成功');
    }
}