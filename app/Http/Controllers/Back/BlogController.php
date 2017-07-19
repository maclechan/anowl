<?php
namespace App\Http\Controllers\Back;

/**
 * 博客管理
 * @Author  maclechan@qq.com
 * @date    2017-7-19
 */

use JsonMsg;
use App\Services\UploadService;

class BlogController extends BaseController
{
    /**
     * 
     * @return view
     */
    public function getIndex(UploadService $img)
    {
        return view('back.admin.index');
    }

}