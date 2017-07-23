<?php namespace system\database\migrations;
use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;
class CreateAddonsLinksTable extends Migration {
    //执行
	public function up() {
		Schema::create( 'addons_links', function ( Blueprint $table ) {
			$table->increments( 'links_id' );
            $table->timestamps();
            $table->string('links_name')->defaults('')->comment('友情链接名称');
            $table->string('links_url')->defaults('')->comment('友情链接地址');
            $table->integer('links_orderby')->defaults(0)->comment('友情链接排序');
        });
    }

    //回滚
    public function down() {
        Schema::drop( 'addons_links' );
    }
}