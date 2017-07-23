<?php namespace system\database\migrations;
use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;
class CreateModuleTable extends Migration {
    //执行
    public function up() {
        Schema::create( 'module', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->timestamps();
            $table->string('module_title',100)->defaults('')->comment('模块中文名称');
            $table->string('module_name',100)->defaults('')->comment('模块英文标识');
            $table->string('module_author',100)->defaults('')->comment('模块作者');
            $table->string('module_introduction',200)->defaults('')->comment('模块介绍');
            $table->string('module_thumb',200)->defaults('')->comment('模块缩略图');
            $table->tinyInteger('module_is_wechat')->defaults(0)->comment('是否处理微信消息，1代表处理，0代表不处理');
            $table->tinyInteger('module_is_system')->defaults(0)->comment('是否为系统模块，1代表是，0代表不是');
        });
    }

    //回滚
    public function down() {
        Schema::drop( 'module' );
    }
}