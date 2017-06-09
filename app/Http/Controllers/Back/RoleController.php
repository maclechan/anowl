<?php
namespace App\Http\Controllers\Back;

/**
 * 用户权限
 * @Author  maclechan@qq.com
 * @date    2017-5-30
 */

use DB;
use Illuminate\Http\Request;
use App\Http\Requests;

class RoleController extends BaseController
{
    public function getIndex()
    {
        $_data = DB::table('admin_users')
            ->orderBy('id', 'ASC')
            ->paginate(config('system.page_limit'));

        return view('back.role.index',[
            'pages' => $_data,
        ]);
    }

    //添加用户视图
    public function getAdd()
    {
        return view('back.role.add');
    }
}
