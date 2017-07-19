<?php
namespace App\Http\Controllers\Back;

/**
 * 成功登陆后默认后台首页
 * @Author  maclechan@qq.com
 * @date    2017-5-30
 */

use DB,TestClass;

use JsonMsg;
use App\Services\UploadService;

class AdminController extends BaseController
{
    /**
     * 管理后台首页
     * @return view
     */
    public function index(UploadService $img)
    {
        //echo $img->img();
        //echo JsonMsg::Msg();
        return view('back.admin.index');
    }

}