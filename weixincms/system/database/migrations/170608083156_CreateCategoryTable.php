<?php namespace system\database\migrations;
use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;
class CreateCategoryTable extends Migration {
    //执行
	public function up() {
		Schema::create( 'category', function ( Blueprint $table ) {
            $table->increments( 'cate_id' );
            $table->timestamps();
            $table->string('cate_name',100)->defaults('')->comment('栏目名称');
            $table->string('cate_description',200)->defaults('')->comment('栏目描述');
            $table->tinyInteger('cate_sort')->unsigned()->defaults(0)->comment('栏目排序');
            $table->string('cate_linkurl')->defaults('')->comment('外部链接url');
            $table->integer('cate_pid')->unsigned()->defaults(0)->comment('栏目父级id');
        });
    }

    //回滚
    public function down() {
        Schema::drop( 'category' );
    }
}