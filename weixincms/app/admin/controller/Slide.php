<?php namespace app\admin\controller;

use houdunwang\db\Db;
use houdunwang\page\Page;
use houdunwang\request\Request;
use houdunwang\route\Controller;
use system\model\Slide as SlideModel;
class Slide extends Common {
    //动作
    public function index()
    {
        //获取所有slide表的数据
        $field = SlideModel::paginate(3);
        $page =Page::row(3)->make(Db::table('slide')->count());
//        $page = Page::row(v('config.arc_num'))->make(Db::table('article')->count());
        //此处书写代码...
        return view('',compact('field','page'));
    }

    public function post()
    {
        //获取get参数中的slide_id;
        $slide_id =Request::get('slide_id');
        //判断编辑和添加
        $model = SlideModel::find($slide_id)?: new SlideModel();
        if(IS_POST)
        {
//            p(Request::post());
            $model->save(Request::post());
            return $this->setRedirect('index')->success('操作成功');

        }

        return view('',compact('model'));
    }

    /***
     * 删除方法
     */
    public function del()
    {
        //获取需要删除的数据主键id
        $slide_id = Request::get('slide_id');
        //找到数据
        $model = SlideModel::find($slide_id);
        //执行删除
        $model->destory();
        //成功提示
        return $this->setRedirect('index')->success('操作成功');

    }



}
