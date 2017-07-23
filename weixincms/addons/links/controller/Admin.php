<?php namespace addons\links\controller;

use addons\links\model\Links;
use houdunwang\db\Db;
use houdunwang\request\Request;
use module\HdController;

class admin extends HdController {


    /***
     * 插件列表
     * @return mixed
     */
    public function index()
    {
        //测试
        //echo 'admin.index';

        //将链接数据获取，首页循环使用
        $data = Db::table('addons_links')->orderBy('links_orderby','DESC')->get();

        //加载模板,分配数据
        return $this->template('',compact('data'));
    }


    /***
     * 插件添加/编辑
     * @return mixed
     */
    public function post()
    {
        $links_id = Request::get('links_id');
        $model = Links::find($links_id)?: new Links();
        if (IS_POST) {
            //出现没有数据添加，打印之后看出问题，并解决，模型允许填充未开，
//            p(Request::post());die;
           $model->save(Request::post());
           return $this->setRedirect(url('admin.index'))->success('操作成功');
        }

        //加载模板
        return $this->template('',compact('model'));
    }


    public function del()
    {
        //找到需要删除的数据ID
        $links_id = Request::get('links_id');
        //模型找数据
       $model =  Links::find($links_id);
        //执行删除
        $model->destory();
        //成功提示
        return $this->setRedirect(url('admin.index'))->success('操作成功');
    }
}