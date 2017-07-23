<?php
namespace app\admin\controller;



use houdunwang\db\Db;
use houdunwang\page\Page;
use module\Wechat;
use \system\model\Category;
use houdunwang\request\Request;
use \system\model\Article as ArticleModel;
use system\model\Keywords;

class Article extends Common
{
    use Wechat;
    public function __construct()
    {
        //调用common中的auth方法，进行登陆验证
        $this->auth();
    }

    //动作
    public function index(ArticleModel $article)
    {
    //此处书写代码...
//        echo v('config.arc_num');
        $num = v('config.arc_num')?:10;
        $page = Page::row($num)->make(Db::table('article')->count());
//        p($page);
        $field = Db::table('article')->limit(Page::limit())->get();
//        p($field);
//        $fieldSon = count($field->toArry()) >0 ? count($field->toArry()): 0 ;
        return view('',compact('field','page'));

        //加载微信菜单首页
//        return view();
    }

    public function post(ArticleModel $article,Category $category)
    {
//        p(Request::post());
        $arc_id = Request::get('arc_id',0,'intval');
//        p($arc_id);die;
        if (IS_POST) {
            if ($arc_id) {
                //走到这里说明是编辑，找到那一条数据
                $article = ArticleModel::find($arc_id);
            }
            //执行添加
            $post = Request::post();
            $article->save($post);
//            p($article['arc_id']);die;

            //这里是因为新添加的文章arc_id是没有的，所以需要获取一下。查看手册，新添加的返回值不是文章的主键id所以去数据表中查找了对应的文章arc_id,给关键词表中的module_id赋值。
//            $arc_id =Request::get('arc_id',0,'intval')?: ArticleModel::where('arc_keyword',$post['arc_keyword'])->pluck("arc_id");
            //添加关键词表数据
            $data = ['keywords'=>$post['arc_keyword'],'module_id'=>$arc_id?:$article['arc_id'],'module'=>'article'];
            $this->saveKeywords($data);

//            $this->setRedirect('back')->success('处理成功');
          return    message('操作成功','index');

        }



        if($arc_id){
            //编辑
            $oldData = ArticleModel::find($arc_id);
            //p($oldData->toArray());
        }
        //获取所属栏目数据
        $cateData = $category->getAllCate();
        return view('',compact('cateData','oldData'));
//



//        return view();
    }


    /***
     * 删除方法
     */
    public function del(ArticleModel $article)
    {
        //接受参数
        $arc_id = Request::get('arc_id',0,'intval');
//        p($arc_id);
        //执行删除
        $model =$article->find($arc_id);

        //删除关键词
        $keyword = Keywords::where('keywords',$model['arc_keyword'])->first();
        $keyword->destory();

    //删除当前的数据对象
        $model->destory();
        //删除关键词表中对应的关键词

//        $this->delkeywords($model['id']);



      return  message('操作成功','index');
    }
}
