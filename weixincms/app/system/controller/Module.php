<?php
namespace app\system\controller;

use houdunwang\db\Db;
use houdunwang\dir\Dir;
use houdunwang\request\Request;
use houdunwang\validate\Validate;
use houdunwang\view\View;
use system\model\Module as ModuleModel;
class Module extends Common
{


    public function __construct ()
    {
        $this->auth();
        //分配已经安装的模块数据
        $this->assignModuleData();
    }

    public function assignModuleData()
    {
        $moduleData = Db::table('module')->where('module_is_system',0)->get();
        //p($moduleData);
        //在module表中潮查询module_is_system=0
        View::with('moduleData',$moduleData);

    }

    //动作
    public function index(ModuleModel $module){

        //获取模块数据
//        if ($module->get()){
//            $data = $module->get()->toArray();
//        }else{
//            $data = $module->get();
//        }


        //这里是之前没有分开设计模块时候的方法
//        $page = Page::row(5)->make(Db::table('module')->count());
////        p($page);die;
//        $field = Db::table('module')->where('module_is_system',0)->limit(Page::limit())->get();
////        p($field);

        //这里是设计模块和安装模块分开处理的首页数据获取方法
        //获取已经设计模块标识
        $isInstalledModule = $module->where( 'module_is_system' , 0 )->lists( 'module_name' );
//        p($isInstalledModule);die;
        //1.先扫描addons/，看有多少模块
        $modules = Dir::tree( 'addons' );
//        p($modules);die;
        //声明数组，用于首页数据循环
        $data = [];
        //2循环出来展示
        foreach ( $modules as $k => $v ) {
            //将模块配置用manifestFile变量接收
            $manifestFile = 'addons/' . $v[ 'basename' ] . '/manifest.php';
            //判断，如果模块中没有manifest.php文件，视为不合法模块
            if ( is_file( $manifestFile ) ) {
                //将设计模块时的对应配置项存储在config变量中
                $config = include $manifestFile;
                //这里是给具体标识的代码，如果新设计模块没有存在于数据库，那么将视为未安装，in_array的值为fales，如果存在，将视为已经安装，值为true，后面程序可与根据$config['insatall']判断是否已经安装此模块
                $config[ 'isinstall' ] = in_array( $v[ 'basename' ] , $isInstalledModule );
                //将需要的数据存在data中，用户页面循环展示
                $data[] = $config;
//                p($data);die;
            }

        }

//        View::with('');

		return view('',compact('data'));
    }
    //设计模块
	public function design(ModuleModel $module)
	{
		if(IS_POST)
		{
			//1.接受post数据
			$post = Request::post();
			//p($post);die;
			Validate::make([
				['module_title','required','请输入模块中文名称',Validate::MUST_VALIDATE],
				['module_name','required','请输入模块标识',Validate::MUST_VALIDATE],
				['module_author','required','请输入模块作者',Validate::MUST_VALIDATE],
			]);
			//2.判断不能重复创建模块
			//考虑规范，采用目录全部小写
			$post['module_name'] = strtolower($post['module_name']);
			//在addons或者module检测，创建的模块已存在，则不允许重复创建【目录已经存在，代表是模块已经存在】
			if(is_dir("addons/{$post['module_name']}") || is_dir("module/{$post['module_name']}")){
				return ['valid'=>0,'message'=>'模块已存在，不能重复创建'];
			}
			//3.创建出模块的基本目录结构
			$dirs = [
				'controller','model','system','template',
			];
			foreach ($dirs as $dir) {
				//Dir::create（）在hdphp手册中组件--目录操作
				Dir::create("addons/{$post['module_name']}/{$dir}");
			}
			//4.生成文件
			$module_name = $post['module_name'];
			$content = <<<str
<?php namespace addons\\{$module_name}\system;

use module\Hdprocessor;

/**
 * 微信处理器
 * Class Processor
 * @package addons\\{$module_name}\system
 */
class Processor extends Hdprocessor
{
	public function handler()
	{

	}
}
str;
			file_put_contents("addons/{$post['module_name']}/system/Processor.php",$content);
			//5.数据存储到数据库
            //因为这里需要将设计模块分为两步
            //第一步设计模块，创建目录，第二部为执行安装，
            //将设计模块时的相关数据写入模块中，存放在database.php文件中
            file_put_contents( 'addons/' . $module_name . '/manifest.php' , "<?php\r\nreturn " . var_export( $post , true ) . ";\r\n?>" );
//			$module->save($post);
			return ['valid'=>1,'message'=>'模块设计成功'];
		}

		return view();
	}


	public  function insatall(ModuleModel $module)
    {

//        echo 'insatall';
        //这里将执行安装，就是将数据写入数据库
        //获取模块标识
        $module_name = Request::get('module_name');
//        p($module_name);//links
        //获取需要存入数据库的模块数据
        $data = include 'addons/' . $module_name . '/manifest.php';
        //执行模型添加
        $module->save($data);
        //成功提示
        return $this->setRedirect('index')->success('安装成功');


    }


	//删除模块
    public function uninstall(ModuleModel $module)
    {
        //接受要删除模块module_name[英文标识]
        $module_name = Request::get( 'module_name' );
        //2.删除数据库对应数据
        ModuleModel::where( 'module_name' , $module_name )->delete();
        //3.成功提示
        return $this->setRedirect( 'index' )->success( '操作成功' );
    }
}
