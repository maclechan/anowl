<?php
namespace App\Http\ViewComposers;

use App\Models\Role\Roles,
    App\Models\Role\Models;

use Illuminate\Contracts\Auth\Guard,
    Illuminate\Support\Facades\Auth,
    Illuminate\View\View;

class AuthComposer
{
    //Role模型
    protected $role;

    //用户信息 包括己获取的权限
    protected $userInfo;

    //当前控制器名 HomeController
    protected $controller_name;

    //当前方法名 全小写 addgroup
    protected $action_name;

    //当前URI
    protected $uri;

    public function __construct(Roles $role)
    {
        // 依赖关系由服务容器自动解析...
        $this->role = $role;

        $this->userInfo = $this->initUser();
        $this->getActionName();

    }

    //绑定数据到视图
    public function compose(View $view)
    {
        if (!\Auth::guest()) {
            //用户记录、用户组、角色
            $view->with('userInfo', $this->userInfo);
            //显示菜单名
            view()->share('menu', $this->assigned());
            //获得当前控制器全名
            view()->share('controller_name', $this->controller_name);
            //获得当前方法名
            view()->share('action_name', $this->action_name);
            //获得当前uri路径
            // view()->share('uri', get_in());
            //面包屑
            view()->share('breadcrumb',  Models::getCrumb($this->controller_name, $this->action_name));
        }
    }

    /**
     * 获取登陆用户 个人信息、用户组->角色->权限
     * @return array 用户信息
     */
    public function initUser()
    {
        if (!\Auth::guest()){
            //获取登陆用户表的一条信息
            $user_info = \Auth::user();

            return [
                'info'  => $user_info, //用户表中一条数据
                'group' => $this->role->getById($user_info['group_id']),
                'role'  => $this->role->getById($user_info['role_id'])
            ];
        }
    }

    /**
     * 取得当前用户的所有菜单列表
     * @return mixed
     */
    public function assigned()
    {
        if (!\Auth::guest()){
            return Models::Assigned(
                $this->userInfo['info']['group_id'],
                $this->userInfo['info']['role_id']
            );
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
        //$this->uri              = get_in();
    }
}