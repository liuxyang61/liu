<?php namespace system\middleware;

use houdunwang\middleware\build\Middleware;

class Base implements Middleware{
	//执行中间件
	public function run($next) {
	    if (is_file('lock.php'))
        {
            //微信默认回复消息的中间件
            $this->setBaseConfig();
        }

         $next();
	}

    //设置微信基本消息
    public function setBaseConfig()
    {
        $model = \system\model\Base::find( 1 );
        $field = $model ? json_decode( $model[ 'base' ] , true ) : [];
//p($field);
//系统v函数，需要看函数，追踪代码
        v( 'base' , $field );
    }
}