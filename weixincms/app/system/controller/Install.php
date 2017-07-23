<?php namespace app\system\controller;

use houdunwang\dir\Dir;
use houdunwang\request\Request;
use houdunwang\route\Controller;
use system\model\Admin;

class Install extends Common{
    //动作

    public function __construct()
    {
        //检测是否安装调用
        $this->isInstalled();
    }


    //检测是否安装

    public function isINstalled()
    {
        if ( is_file( 'lock.php' ) ) {
            die( view( 'isInstalled' ) );
        }
    }
    //版本信息
    public function copyright(){

        //加载页面
        return view();
    }


    //环境检测
    public function testing()
    {

        //将环境信息全部存储到data中，方便页面使用判断
        $data['server_software'] = $_SERVER['SERVER_SOFTWARE'];
        $data['php_version'] = PHP_VERSION;
        $data['pdo'] = extension_loaded('pdo');
        $data['gd'] = extension_loaded('gd');
        $data['curl'] = extension_loaded('curl');
        $data['openssl'] = extension_loaded('openssl');

        return view('',compact('data'));
    }

    //初始数据方法
    public function database()
    {
        if(IS_AJAX)
        {
            //测试
//            echo 1;die;//1 成功
            //接受数据
            $post = Request::post();
//            p($post);die;
//   Array
//       (
//        [csrf_token] =>
//        [host] => 127.0.0.1
//        [user] => cms
//        [password] => cms123
//        [database] => cms
//        [prefix] => weixincms_
//       )

            //要链接的数据库地址，和数据库名
            $dsn = "mysql:host={$post['host']};dbname={$post['database']}";
            try{
                //链接数据库，实例化PDO抽象层；
                $pdo = new \PDO($dsn,$post['user'],$post['password']);
                //走到这里已经链接成功，创建文件，将数据写入database文件中
                Dir::create('data');
                file_put_contents('data/database.php',"<?php\r\nreturn ".var_export($post,true).";\r\n?>");
            }catch(\Exception $e){
                //走到这里说明没有链接成功，那么将异常抛出给页面
                return $this->error("数据库连接失败：".$e->getMessage());
            }

        //给出成功提示
            return $this->success('数据库连接成功');
        }
        return view();
    }

    //创建数据表
    public function tables()
    {
        //测试
//        echo 'tables';die; //tables
        //这里进行数据表的创建
        cli('hd migrate:make');
        cli('hd seed:make');
        $model = new Admin();
        $model['admin_username'] = 'admin';
        $model['admin_password'] = 'Gw7yHXj+AS8VPYVOeHNHHA==';
        $model->save();
        go('finish');

    }


    //完成安装
    public function finish()
    {
        //生成lock.php文件
        touch('lock.php');
//		file_put_contents('lock.php','');
        return view();
    }
}
