<?php namespace system\database\migrations;
use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;
class CreateAdminTable extends Migration {
    //执行
	public function up() {
		Schema::create( 'admin', function ( Blueprint $table ) {
			$table->increments( 'admin_id' );
			$table->timestamps();
            $table->string('admin_username',100)->defaults('')->comment('cms后台管理员用户名');
            $table->string('admin_password',100)->defaults('')->comment('cms后台管理员密码');
        });
    }

    //回滚
    public function down() {
        Schema::drop( 'admin' );
    }
}