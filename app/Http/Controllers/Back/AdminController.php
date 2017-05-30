<?php
namespace App\Http\Controllers\Back;

/**
 * 成功登陆后默认后台首页
 * @Author  maclechan@qq.com
 * @date    2017-5-30
 */

class AdminController extends BaseController
{
    /**
     * 管理后台首页
     * @return view
     */
    public function index()
    {
        return view('back.admin.index');
    }
}