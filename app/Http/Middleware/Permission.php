<?php
namespace App\Http\Middleware;

/**
 * 权限中间件
 * @Author  maclechan@qq.com
 * @date    2017-7-14
 */

use Closure;
use Illuminate\Routing\Route;
use Illuminate\Contracts\Auth\Guard;

use App\Models\Back\AdminAssigned;

class Permission
{
    const _NotPermissionMsg = '请联系管理员或部门主管开通权限';

    public function __construct(Route $route, Guard $auth)
    {
        $this->auth  = $auth;
        $this->route = $route;
    }

    /**返回请求过滤器
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->is_ajax = $request->ajax();
        $this->getActionName();
        $this->userInfo();

        $assigned  = $this->assigned();
        $run_is_ok = 0;
        $is_ajax   = $this->is_ajax;
        //当前访问的控制器和方法
        foreach($assigned as $value){
            if(ucwords($value->controller_name).'Controller' == $this->controller_name
                &&
                (strtolower($value->action_name) == $this->action_name
                    || 'get'.ucwords($value->action_name) == $this->action_name
                    || 'post'.ucwords($value->action_name) == $this->action_name
                )
            ){
                $run_is_ok = 1;
            }
        }

        if(!$run_is_ok){
            if($is_ajax){
                die(json_encode(['code' => -200,'msg' => self::_NotPermissionMsg]));
            }else{
                return view('back.notice',[
                    'code'    => -200,
                    'msg'     => self::_NotPermissionMsg,
                    'content' => $this->controller_name.'控制器'.$this->action_name.'方法  '.'权限验证失败'
                ]);
            }
        }

        return $next($request);
    }


    public function userInfo()
    {
        return $this->user_info = $this->auth->user();
    }

    public function assigned()
    {
       return  AdminAssigned::getAllAssigned (
                    $this->user_info->group_id,
                    $this->user_info->role_id
        );
    }

    public function getActionName(){
        $this->controller_name = get_controller_name();
        $this->action_name     = get_action_name();
        $this->in              = get_in();
    }

}
