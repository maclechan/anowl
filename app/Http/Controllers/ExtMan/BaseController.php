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
        //用户是否授权中间件
        $this->middleware('permission');
        //用户是否登陆中间件
        $this->middleware('auth'); 

        
    }

    /**
     * 向终端 输出json 字符串；
     * $result 不等于 false 时 输出   {'return_code':0, 'data':'数据内容'];
     *
     * $result 等于  false 时 {'return_code':1, 'return_msg':'错误字符串内容'];
     *
     *    $err 是 model对象时 输出 {'return_code':1, 'return_msg':'model error 内容'];此时注意:自定义error属性,  model error 只取一条
     *    $err 是字符串内容时 输出 {'return_code':1, 'return_msg':'字符串内容'];
     *    $err 是数组内容时 输出 {'return_code':1, 'return_msg':'数组中最后一条信息'];
     *
     * @param mix $result
     * @param mix $err
     */
    public function echoJSON($result, $err = null)
    {
        if ($result === false) {
            //错误对象
            if(is_object($err) || method_exists($err, 'error')){
                $err = $err->error;
            }
            if (empty($err)) {
                $err = '未知错误';
            };
            return response()->json(['code' => 1, 'msg' => is_array($err) ? array_pop($err) : $err]);

        } else {

            return response()->json(['code' => 0, 'msg' => $result]);
        }
    }
}
