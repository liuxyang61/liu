<?php namespace module;

use houdunwang\route\Controller;
use houdunwang\request\Request;
use houdunwang\weixin\build\pay;
use system\model\Module;

class HdController extends Controller
{
    public function auth()
    {
        //执行登录验证
        //set（）中的参数，参照system\config\middleware.php中controller中实例化auth类的下标变量。
        Middleware::set('auth');
    }

    use Wechat;
    protected $template;

    public function __construct ()
    {
        $m = Request::get( 'm' );
        //根据地址栏m参数，查出来结果中module_is_system知道是不是系统模块
        $module         = Module::where( 'module_name' , $m )->first();
        //加载模块
        $this->template = ( $module[ 'module_is_system' ] == 1 ? 'module' : 'addons' ) . '/' . $m . '/template/';

        //		return view( $this->template );
    }

    //加载模板文件
    protected function template ( $tpl = '' , $args = [] )
    {
        $info = explode( '/' , Request::get( 'action' ) );
//        p($info);die;
        $tpl  = empty($tpl)  ? $info[ 2 ] : $tpl;

        //info[1]控制器类，$info[ 2 ]值得是方法
        return view( $this->template . strtolower( $info[ 1 ] ) . '/' . $tpl , $args );
    }



}