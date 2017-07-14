<?php
namespace App\Http\Controllers\Back;

/**
 * 管理后台基类
 * @Author  maclechan@qq.com
 * @date    2017-5-30
 */

use Illuminate\Contracts\Auth\Guard,
    Illuminate\Routing\Route;

use App\Models\Back\AdminNav,
    App\Models\Back\AdminRole;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;


class BaseController extends Controller
{
    use ValidatesRequests, DispatchesJobs;

    protected $layout = 'back.layout';

    /**
     * 构造方法
     */
    public function __construct(Route $route, Guard $auth)
    {
        error_reporting(E_ERROR | E_PARSE);
        $this->middleware('auth'); //用户是否登陆中间件
        $this->middleware('permission');
        $this->auth      = $auth;
        $this->route     = $route;
        $this->user_info = $this->initUser();
        $this->getActionName();
        $this->initViewShare();    //视图共享数据

    }

    /**
     * 获取登陆用户 个人信息、用户组->角色->权限
     * @return array 用户信息
     */
    public function initUser()
    {
        if (!$this->auth->guest()){
            //获取登陆用户表的一条信息
            $user_info = $this->auth->user();

            return [
                'info'  => $user_info, //用户表中一条数据
                'group' => AdminRole::getPkId($user_info['group_id']),
                'role'  => AdminRole::getPkId($user_info['role_id'])
            ];
        }
    }

    /**
     * 取得当前用户的所有菜单列表
     * @return mixed
     */
    public function assigned()
    {
        return AdminNav::Assigned(
            $this->user_info['info']->group_id,
            $this->user_info['info']->role_id
        );
    }

    /**
     *  视图共享数据方法
     */
    public function initViewShare()
    {
        if (!$this->auth->guest()){
            //$this->_page = \Config::get('system.page');
            //view()->share('base_url', \Config::get('system.base_url'));
            view()->share('userInfo',$this->user_info);    //用户记录、用户组、角色
            view()->share('menu',$this->assigned());  //显示菜单名
            view()->share('controller_name',$this->controller_name);  //当前URI的控制器名
            view()->share('action_name',$this->action_name); //当前URL的方法器名
            view()->share('breadcrumb',  @AdminNav::getCrumb($this->controller_name,$this->action_name));
        }
    }

    /**
     * 获取控制器名、方法名、URI
     */
    public function getActionName()
    {
        /*获得当前控制器全名*/
        $this->controller_name = get_controller_name();
        /*获得当前方法名*/
        $this->action_name     = get_action_name();
        /*获得当前uri路径*/
        $this->in              = get_in();
    }

}
