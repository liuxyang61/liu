<?php namespace system\database\migrations;
use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;
class CreateArticleTable extends Migration {
    //执行
    public function up() {
        Schema::create( 'article', function ( Blueprint $table ) {
            $table->increments( 'arc_id' );
            $table->timestamps();
            $table->string('arc_title',100)->defaults( '' )->comment( '文章标题' );
            $table->string('arc_thumb',200)->defaults( '' )->comment( '文章缩略图' );
            $table->integer('arc_click')->unsigned()->defaults( 0 )->comment( '点击次数' );
            $table->text('arc_content')->defaults( '' )->comment( '文章标题' );
            $table->string('arc_description')->defaults( '' )->comment( '文章描述' );
            $table->string('arc_author',100)->defaults( '' )->comment( '文章作者' );
            $table->tinyInteger('arc_orderby')->defaults( 0 )->comment( '文章排序' );
            $table->string('arc_source')->defaults( '' )->comment( '文章来源' );
            $table->string('arc_linkurl')->defaults( '' )->comment( '外部连接' );
            $table->integer('cate_cid')->unsigned()->defaults( 0 )->comment( '栏目id' );
            $table->string('arc_keyword')->defaults( '' )->comment( '微信回复关键词' );
            $table->tinyInteger('arc_iscommed')->defaults( 0 )->comment( '是否推荐' );
            $table->tinyInteger('arc_ishot')->defaults( 0 )->comment( '是否热门' );



        });
    }

    //回滚
    public function down() {
        Schema::drop( 'article' );
    }
}