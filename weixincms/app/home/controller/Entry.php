<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace app\home\controller;

use houdunwang\db\Db;
use houdunwang\page\Page;
use houdunwang\request\Request;
use houdunwang\session\Session;
use houdunwang\view\View;
use system\model\Article;
use system\model\Category;
use system\model\Module;

class Entry
{

    protected $template;
    public function __construct ()
    {
       $module =  v('config.template')?:'bolg';
        //给$template赋值，加载页面的路径
        $this->template = 'template/' . (IS_MOBILE ? 'mobile' : 'web').'/'.$module;
        //定义常量，方便页面使用加载页面
        define(__TEMPLATE__,__ROOT__.'/' . $this->template);

//		var_dump(IS_MOBILE);
//        echo __TEMPLATE__;die;

        $res = $this->runModule();
    }

    /***
     * 网站首页
     * @return mixed
     */
    public function index()
    {
        //通过地址栏访问进自己定义的模块中<<中心思想——实例化>>
        //http://cms.liuxyang.com/index.php?m=base&action=controller/base/index

        //运行模块
//        $res = $this->runModule();
//        //当运行了模块中的类方法，就不让代码继续往下走了
//        if ( $res !== false ) {
//            return $res;
//        }

        if(ISSET($_GET['code']) && isset($_GET['state']))
        {
            $qc = new \QC();
            //执行代码获取登陆者信息
            //获取access_token
            $access_token = $qc->qq_callback();
            //echo $access_token;die;
            //获取openid
            $openid = $qc->get_openid();
//            echo $openid;
            $qc = new \QC($access_token, $openid);
            $userInfo = $qc->get_user_info();
            $userInfo['openid']=$openid;
            echo '<pre>';
            //将用户数据存入session中
             Session::set('userInfo',$userInfo);
            $userInfo=Session::get('userInfo');
//                print_r($userInfo);die;
            go('index');

        }

        //获取qq登陆信息
        $userInfo=Session::get('userInfo')?:[];
//        p($userInfo);

        $data = Db::table('category')
            ->join('article','article.cate_cid','=','category.cate_id')
            ->get();

//        p($data);die;
        //当模块没有被实例化，默认加载以下页面
        return view($this->template.'/index.html',compact('data','userInfo'));
    }




    /**
     * 栏目页面
     */
    public function category()
    {
        //接受get参数中的栏目id
        $cate_id = Request::get('cate_id');
        //获取对应栏目的数据，方便页面使用
        $categoryData = Category::find($cate_id);
        //指定分页数量
//        $num = v('config.cate_num')?:1;
        //获取所属栏目的所有文章，并且分页
//        $ArticleData = Article::where('cate_cid',$cate_id)->paginate(1);
        //分页无效
//        $ArticleData = Article::where('cate_cid',$cate_id)->get();

        //原生获取分页数据
        $page =Page::row(5)->make(Db::table('article')->where('cate_cid',$cate_id)->count());
        //原生获取分页数据
        $ArticleData = Db::table('article')->where('cate_cid',$cate_id)->limit(Page::limit())->get();
        //考虑所属栏目没有数据，需要给空数组，不然会报错。
        $ArticleData = $ArticleData?:[];
        return view($this->template . '/list.html',compact('ArticleData','categoryData','page'));

    }

    //实例化模块方法
    public function runModule()
    {
        //通过地址栏访问进自己定义的模块中
        //http://cms.liuxyang.com/index.php?m=base&action=controller/base/index
        //获取模型参数，方便下面拼接实例化链接
            $m = Request::get('m');
//            dd($m);die;
        //找到当前m参数对应的模块数据，因为只有m参数在数据库存在，才能进行下一步实例化
        $module = Module::where( 'module_name' , $m )->first();

        //获取动作参数
        $action = Request::get( 'action' );
//        p($action);

        //判断是否存在模块，并却m参数模块和action动作类和方法都存在，才进行下面的代码进行实例化
        if ( $module && $m && $action ) {
            //将action动作以 / 替换，转为数组。
            $info = explode( '/' , $action );
            //打印查看
//            p($info);
            //将action转为数组
//            Array
//            (
//                [0] => controller
//                [1] => base
//            [2] => index
//          )
//          因为系统模块需要去module里面实例化，所以判断是不是为系统模块，根据数据库中的module_is_system的值是否为1判断。
            $class = ( $module[ 'module_is_system' ] == 1 ? 'module' : 'addons' ) . "\\" . $m . '\\' . $info[ 0 ] . '\\' . ucfirst( $info[ 1 ] );

            //将实例化的对象返回出去
//            return call_user_func_array( [ new $class , $info[ 2 ] ] , [] );
            die( call_user_func_array( [ new $class , $info[ 2 ] ] , [] ) );
        }
//        return false;

    }


    //图文消息外部链接
    public function content()
    {
//        p($this->template . '/content.html');
        //获取文章主键
        $arc_id = Request::get('arc_id');
        //找对应数据
        $data = Article::find($arc_id);
//        p($data);die;
        //加载页面
        return view($this->template . '/content.html', compact('data') );
    }



    /***
     * qq登陆
     */

    public function qqLogin()
    {
        $qc = new \QC();
        $qc->qq_login();

    }

    /***
     * qq退出
     */
    public function qqout()
    {
        //清除session中的userInfo
        Session::del('userInfo');

        go('index');

    }










}