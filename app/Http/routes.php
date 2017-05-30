<?php
/**
 * 路由管理
 */

# 管理后台
require app_path('Http/Route/back.php');

Route::get('/', function () {
    return view('welcome');
});
