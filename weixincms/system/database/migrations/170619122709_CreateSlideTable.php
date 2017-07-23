<?php namespace system\database\migrations;
use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;
class CreateSlideTable extends Migration {
    //执行
	public function up() {
		Schema::create( 'slide', function ( Blueprint $table ) {
			$table->increments( 'slide_id' );
            $table->timestamps();
            $table->string('slide_title')->defaults('')->comment('缩略图标题');
            $table->string('slide_url')->defaults('')->comment('缩略图外部链接');
            $table->string('slide_orderby')->defaults('')->comment('缩略图排序');
            $table->string('slide_thumb')->defaults('')->comment('缩略图排序');

        });
    }

    //回滚
    public function down() {
        Schema::drop( 'slide' );
    }
}