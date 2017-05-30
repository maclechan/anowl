<?php
namespace App\Http\Controllers\Back;

/**
 * 用户权限
 * @Author  maclechan@qq.com
 * @date    2017-5-30
 */

use Illuminate\Http\Request;
use App\Http\Requests;

class RoleController extends BaseController
{
    public function getIndex()
    {
        return view('back.admin.index');
    }
}
