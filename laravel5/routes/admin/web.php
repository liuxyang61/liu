<?php

//Route::get('/login','Admin\LoginController@index');
Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){
    //登录
    Route::get('/login','LoginController@index');
    Route::post('/login','LoginController@login');
    //后台首页
    Route::get('/index','EntryController@index');
    //修改密码changePass
    Route::get('/changePass','EntryController@pass');
    Route::post('/changePass','EntryController@changePass');
    //退出登录
    Route::get('/out','EntryController@logout');
    Route::resource('/tag','TagController');
    //课程视频
    Route::resource('/lesson','LessonController');

});

