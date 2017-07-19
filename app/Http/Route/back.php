<?php
# 后台路由
/*启用子域名要关闭prefix*/
Route::group(['prefix'=>'back','namespace' => 'Back' /*,'domain' => 'wiki.homestead.app'*/], function() {
    Route::get('/', [ 'as' => 'admin', 'uses' => 'AdminController@index']); //管理后台默认首页
    // 认证路由...
    Route::get('/login', 'AuthController@getLogin');
    Route::post('/login', 'AuthController@postLogin');
    Route::get('/logout', 'AuthController@getLogout');

    Route::controller('admin', 'AdminController');
    Route::controller('nav', 'NavController');
    Route::controller('role', 'RoleController');
    Route::controller('blog', 'BlogController');

});