<?php namespace system\middleware;

use houdunwang\middleware\build\Middleware;
use \system\model\Config as ConfigModel;
use \houdunwang\config\Config as ConfigModels;
class Config implements Middleware{
	//执行中间件
	public function run($next) {

        //检测系统是否安装
        //检测是否有lock.php[该文件判断是否已经执行过安装]
        //需要考虑的是没有安装，不能访问系统任意地方，但是除了syste/install这个类
        if ( !is_file( 'lock.php' ) && !preg_match( "#system/install#i" , Request::get( 's' ) ) ) {
            go( 'system.install.copyright' );
        }

	    if (is_file('lock.php'))
        {
            //微信配置项
            $this->setWeiXinConfig();
            //系统配置项
            $this->setSysConfig();
        }
        $next();
	}


    //设置微信配置项
    private function setWeiXinConfig ()
    {
        $model = ConfigModel::find(1);
//        var_dump($model);die;
        $field = $model?json_decode( $model[ 'weixin' ] , true ):[];

        \Config::set('wechat',array_merge(\Config::get('wechat'), $field));
    }

    //设置系统配置项
    private function setSysConfig ()
    {
        $model = ConfigModel::find( 1 );
        $field = $model ? json_decode( $model[ 'system' ] , true ) : [];
        //p($field);
        //系统v函数，需要看函数，追踪代码
        v( 'config' , $field );
    }


}