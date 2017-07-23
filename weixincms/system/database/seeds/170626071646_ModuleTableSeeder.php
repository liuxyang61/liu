<?php namespace system\database\seeds;
use houdunwang\database\build\Seeder;
use houdunwang\db\Db;
use system\model\Module;

class ModuleTableSeeder extends Seeder {
    //执行
	public function up() {
        $data = [
            [ 'module_title'        => '微信基本功能' ,
                'module_name' => 'base' ,
                'module_author'        => '后盾网' ,
                'module_introduction'     => '微信基本功能' ,
                'module_thumb'         => 'attachment/2017/06/08/7881496908908.png',
                'module_is_wechat'         => 1,
                'module_is_system'         => 1
            ] ,
            [ 'module_title'        => '微信图文回复' ,
                'module_name' => 'article' ,
                'module_author'        => '后盾网' ,
                'module_introduction'     => '微信图文回复' ,
                'module_thumb'         => 'attachment/2017/06/08/7881496908908.png',
                'module_is_wechat'         => 1,
                'module_is_system'         => 1
            ] ,
            [ 'module_title'        => '微信菜单' ,
                'module_name' => 'button' ,
                'module_author'        => '后盾网' ,
                'module_introduction'     => '微信菜单' ,
                'module_thumb'         => 'attachment/2017/06/08/7881496908908.png',
                'module_is_wechat'         => 1,
                'module_is_system'         => 1
            ] ,
        ];
        foreach ( $data as $k => $v ) {
            $module = new Module();
            //Category模型
            //允许填充的字段['*'],$timestamps=true
            $module->save($v);
        }
    }
    //回滚
    public function down() {

    }
}