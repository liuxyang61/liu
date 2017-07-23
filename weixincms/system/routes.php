<?php
use \houdunwang\route\Route;
/*--------------------------------------------------------------------------
| 路由规则设置
|--------------------------------------------------------------------------
| 框架支持路由访问机制与普通GET方式访问
| 如果使用普通GET方式访问时不需要设置路由规则
| 当然也可以根据业务需要两种方式都使用
|-------------------------------------------------------------------------*/


Route::get('/admin','app\admin\controller\Entry@index');
Route::any('/login','app\admin\controller\Login@index');
//Route::post('/search','addons\search\controller\admin@index');


//文章内容页面伪静态
Route::get('/c/{cate_id}.html','app\home\controller\Entry@category');
Route::get('/{arc_id}.html','app\home\controller\Entry@content');


