<?php
/**
 * 管理后台路由
 * @date 2018-5-10
 * @author maclechan@qq.com
 */

Route::group(['namespace'=>'ExtMan'],function(){
    //登陆，注册
    Auth::routes();

    //角色权限管理
    Route::match(['get','post'],'/role/index/{num?}','RoleController@index');
    Route::match(['get','post'],'/role/add/{group_id?}','RoleController@add');
    Route::match(['get','post'],'/role/edit/{id?}','RoleController@edit');
    Route::post('/role/del','RoleController@del');
    Route::get('/role/menu','RoleController@menu');
    Route::post('/role/addmenu','RoleController@addmenu');
    Route::post('/role/editmenu','RoleController@editmenu');
    Route::post('/role/delmenu','RoleController@delmenu');

    Route::resource('/role','RoleController');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/home/addGroup', 'HomeController@addGroup');
    Route::get('/show', 'HomeController@show')->name('show');

    //Route::get('user','UserController@index');
    //Route::get('car','UserController@car');

    //资源路由
    //Route::resource('posts','PostController');
});
