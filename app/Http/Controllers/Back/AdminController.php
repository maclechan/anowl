<?php
namespace App\Http\Controllers\Back;

/**
 * 成功登陆后默认后台首页
 * @Author  maclechan@qq.com
 * @date    2017-5-30
 */

use DB;

class AdminController extends BaseController
{
    /**
     * 管理后台首页
     * @return view
     */
    public function index()
    {
        $_data = DB::table('admin_users')
            ->orderBy('id', 'ASC')
            ->paginate(config('system.page_limit'));

        return view('back.admin.index',[
            'pages' => $_data,
        ]);
    }
}