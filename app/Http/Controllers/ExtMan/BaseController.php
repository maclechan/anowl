<?php
namespace App\Http\Controllers\ExtMan;
/**
 * 管理后台基类
 * @Author: chan <maclechan@qq.com>
 * @date: 2018/5/10
 */

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Bus\DispatchesJobs,
    Illuminate\Foundation\Validation\ValidatesRequests;

class BaseController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    protected $layout = 'extman.layout';

    public function __construct()
    {
        $this->middleware('auth'); //用户是否登陆中间件
    }
}
