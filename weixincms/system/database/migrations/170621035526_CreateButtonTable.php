<?php namespace system\database\migrations;
use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;
class CreateButtonTable extends Migration {
    //执行
    public function up() {
        Schema::create( 'button', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->timestamps();
            $table->string('title')->defaults('')->comment('菜单名称');
            $table->text('content')->defaults('')->comment('菜单内容');
        });
    }

    //回滚
    public function down() {
        Schema::drop( 'button' );
    }
}