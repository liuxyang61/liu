<?php namespace system\database\migrations;
use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;
class CreateAttachmentTable extends Migration {
    //执行
	public function up() {
		Schema::create( 'attachment', function ( Blueprint $table ) {
			$table->increments( 'id' );
            $table->timestamps();
            $table->integer('uid')->defaults(0)->comment('会员编号');
            $table->string('name',80)->defaults('')->comment('名称');
            $table->string('filename',300)->defaults('')->comment('文件名');
            $table->string('path',300)->defaults('')->comment('文件路径');
            $table->string('extension',10)->defaults('')->comment('文件类型');
            $table->integer('createtime')->defaults(0)->comment('上传时间');
            $table->mediumint('size')->defaults(0)->comment('文件大小');
            $table->string('data',100)->defaults('')->comment('辅助信息');
            $table->tinyInteger('status')->unsigned()->defaults(0)->comment('状态');
            $table->text('content')->defaults('')->comment('扩展数据内容');
        });
    }

    //回滚
    public function down() {
        Schema::drop( 'attachment' );
    }
}