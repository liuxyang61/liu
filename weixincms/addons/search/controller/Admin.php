<?php namespace addons\search\controller;

use houdunwang\db\Db;
use houdunwang\page\Page;
use houdunwang\request\Request;
use module\HdController;
use addons\search\model\Search;

class admin extends HdController
{


    /***
     * 插件列表
     * @return mixed
     */
    public function index()
    {
        //制作分页
        $page = Page::row(5)->make(Db::table('addons_search')->count());
        $data = Db::table('addons_search')->limit(Page::limit())->orderBy('search_num', 'DESC')->get();
        //加载模板,分配数据
        return $this->template('', compact('data', 'page'));
    }


    /***
     * 插件添加/编辑
     * @return mixed
     */
    public function post()
    {

        $search_id = Request::get('search_id');

        $model = Search::find($search_id) ?: new Search();
//        dd($model->toArray());die;
        if (IS_POST) {
            //出现没有数据添加，打印之后看出问题，并解决，模型允许填充未开，
//            p(Request::post());die;
            $model->save(Request::post());
            return $this->setRedirect(url('admin.index'))->success('操作成功');
        }

        //加载模板
        return $this->template('', compact('model'));
    }


    public function del()
    {
        //找到需要删除的数据ID
        $search_id = Request::get('search_id');
        //模型找数据
        $model = Search::find($search_id);
        //执行删除
        $model->destory();
        //成功提示
        return $this->setRedirect(url('admin.index'))->success('操作成功');
    }

    public function search()
    {

        $post = Request::post();
        if (IS_POST) {

            //首先查看数据库中有无此搜索关键词，
            $searchData = Db::table('addons_search')->where('search_name', 'like', "%" . $post['search_name'] . "%")->get();
//        p($searchData);die;
            //如果有这个搜索词，那么将其搜索次数自增1
            if ($searchData) {
                //获取需要增加搜索次数的热搜词id
                $search_id = Db::table('addons_search')->where('search_name', $post['search_name'])->pluck('search_id');
//            p($search_id);
                //执行自增搜索量
                Db::table('addons_search')->where('search_id', $search_id)->increment('search_num', 1);
//            echo 11;die;
            } else {
                //走到这里说明没有这个关键词，那么将执行添加
                $data = Db::table('addons_search')->insert(['search_name' => $post['search_name'], 'search_num' => 0]);
                //获取需要增加搜索次数的热搜词id
                $search_id = Db::table('addons_search')->where('search_name', $post['search_name'])->pluck('search_id');
//            p($search_id);
                //执行自增搜索量
                Db::table('addons_search')->where('search_id', $search_id)->increment('search_num', 1);
            }
//        p($post);
            //将$post['search_name']放在文章表中的标题或者内容模糊匹配下
            $data = Db::table('article')
                ->where('arc_title', 'like', "%" . $post['search_name'] . "%")
                ->get();
            //将搜索的关键词存入数据中，需要使用
            $data[0] = $data[0] ?: $data;

            $data[0]['search_name'] = $post['search_name'];
        }
//        p($data);die;

        return $this->template('', compact('data'));
    }
}