<?php namespace system\database\migrations;
use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;
class CreateKeywordsTable extends Migration {
    //执行
	public function up() {
		Schema::create( 'keywords', function ( Blueprint $table ) {
			$table->increments( 'id' );
            $table->timestamps();

            $table->string('keywords')->defaults('')->comment('触发关键词');
            $table->integer('module_id')->defaults(0)->comment('对应模块id');
            $table->string('module')->defaults('')->comment('关键词处理那个模块');
        });
    }

    //回滚
    public function down() {
        Schema::drop( 'keywords' );
    }
}