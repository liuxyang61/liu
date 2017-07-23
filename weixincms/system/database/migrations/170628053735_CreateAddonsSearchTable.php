<?php namespace system\database\migrations;
use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;
class CreateAddonsSearchTable extends Migration {
    //执行
	public function up() {
		Schema::create( 'addons_search', function ( Blueprint $table ) {
			$table->increments( 'search_id' );
            $table->timestamps();
            $table->string('search_name')->defaults('')->comment('热搜名称');
            $table->integer('search_num')->defaults(0)->comment('搜索量');
        });
    }

    //回滚
    public function down() {
        Schema::drop( 'addons_search' );
    }
}