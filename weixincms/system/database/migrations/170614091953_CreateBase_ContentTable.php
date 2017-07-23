<?php namespace system\database\migrations;
use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;
class CreateBase_ContentTable extends Migration {
    //执行
	public function up() {
		Schema::create( 'base_content', function ( Blueprint $table ) {
			$table->increments( 'id' );
            $table->timestamps();
            $table->string('content')->defaults('')->comment('回复内容');

        });
    }

    //回滚
    public function down() {
        Schema::drop( 'base_content' );
    }
}