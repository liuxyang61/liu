<?php namespace system\database\migrations;
use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;
class CreateBaseTable extends Migration {
    //执行
	public function up() {
		Schema::create( 'base', function ( Blueprint $table ) {
			$table->increments( 'id' );
            $table->timestamps();
            $table->text('base')->comment('微信基本消息');
        });
    }

    //回滚
    public function down() {
        Schema::drop( 'base' );
    }
}