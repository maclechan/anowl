<?php
namespace App\Http\Controllers\Extman;
/**
 * 用户权限
 * @Author  maclechan@qq.com
 * @date    2018-5-14
 */

use DB,
    Validator;

use App\Models\Role\Roles,
    App\Models\Role\Models,
    App\Models\Role\AdminUsers,
    App\Models\Role\Permissions;

use Illuminate\Http\Request;
use App\Http\Controllers\ExtMan\BaseController;

class RoleController extends BaseController
{
    //模型菜单
    protected $roles;

    /**
     * 注入模型菜单依赖.
     * @param Roles $roles
     */
    public function __construct(Roles $roles)
    {
        parent::__construct();
        $this->roles = $roles;
    }

    /** 显示一个资源的列表
     *  用户列表&用户检索
     * @param int $num 每页条数
     * @param Request $request 检索表单
     */
    public function index(Request $request, $num=0)
    {
        if ($request->isMethod('get')) {
            $role_id  = $request->get('role_id');
            $paginate = $num ? $num : \Config::get('system.page_limit');

            $users = AdminUsers::with('hasGroup', 'hasRole')
                ->when($role_id, function ($query) use ($role_id) {
                    return $query->where('role_id', $role_id);
                })
                ->orderBy('id', 'ASC')
                ->paginate($paginate);

        } elseif ($request->isMethod('post')) {
            //用户检索
            $usersModel = new AdminUsers();
            $input      = $request->all();
            $users      = $usersModel->getUsers($input,$request);

            if ($input['page_number'] > 0) {
                $page_num = $input['page_number'];
                $users->setPath('index/'.$page_num);
            }
        }

        return view('extman.role.index',[
            'pages' => $users,
            'groups' => $this->roles->getRoleGroupByType(0),
        ]);
    }

    /**创建管理员(展示&保存)
     * @param Request $request
     * @param int $group_id 权限ID
     */
    public function add(Request $request, $group_id=0)
    {
        //显示一个表单来创建一个新的用户资源
        if ($request->isMethod('get')) {
            #获取角色
            if ($group_id > 0) {
                $role_group = $this->roles->getRoleGroupByType($group_id,1);
                return response()->json($role_group);
            }
            #权限组
            $groups = $this->roles->getRoleGroupByType(0);

            return view('extman.role.add',[
                'groups' => $groups
            ]);

        } elseif ($request->isMethod('post')) {
            //保存最新创建的用户资源
            $userModel = new AdminUsers();
            //表单校验
            $validator = $userModel->validator($request->all());

            if ($validator->fails()) {
                return redirect('/role/add')
                    ->withErrors($validator)
                    ->withInput();
            }

            //校验成功入库
            $is_save = $userModel->creates($request->all());
            if($is_save){
                return redirect('/role/index')->with(['type'=>'success','msg'=>'创建成功']);
            }
        }
    }

    /**编辑管理员(展示&保存)
     * @param Request $request
     * @param int $id 管理员ID
     */
    public function edit(Request $request, $id=0)
    {
        //显示一个表单来编辑管理员资源
        if ($request->isMethod('get')) {
            $id = intval($id);
            $user = AdminUsers::find($id);

            if($user){
                $group_id   = $user->group_id;
                $groups = $this->roles->getRoleGroupByType(0);
                $roles  = $this->roles->getRoleGroupByType($group_id,1);
                return view('extman.role.add',[
                    'id' => $id,
                    'user'  => $user,
                    'groups' => $groups,
                    'roles'  => $roles
                ]);
            }else{
                return redirect('/role/index')->with(['type'=>'error','msg'=>'正在非法操作数据.']);
            }

        } else if ($request->isMethod('post')) {
            //保存修管理员资源
            $model = new AdminUsers();
            $input = $request->all();

            $info = $model->where('id', $input['id'])->first()->toArray();

            $filte = [
                'name' => $input['name'],
                'nick_name' => $input['nick_name'],
                'mobile' => $input['mobile']?$input['mobile']:'',
                'group_id' => $input['group_id'],
                'role_id' => $input['role_id'],
                'status' => $input['status'],
            ];

            if($input['password']) {
                $filte['password'] =  \Hash::make($input['password']);
            }

            if(!empty($input)){
                $is_update = $model->where('id', $info['id'])->update($filte);
                if(!$is_update){
                    return redirect('/role/index')->with(['type'=>'error','msg'=>'信息修改失败']);
                }
                return redirect('/role/index')->with(['type'=>'success','msg'=>'信息修改成功']);
            }
        }
    }

    /** 删除管理员
     * @param $id 管理员ID
     */
    public function del(Request $request)
    {
        $id = $request->get('id');
        $userModel = new AdminUsers();

        $is_del = $userModel->where('id',$id)->delete();

        if(!$is_del) {
            return $this->echoJSON(false,'删除失败');
        }

        return $this->echoJSON('删除成功');
    }

    /**
     * 菜单列表
     */
    public function menu(Request $request)
    {
        //一级菜单
        $pages = Models::where('parent_id', 0)->orderBy('mod_id','ASC')->paginate(1);
        $_smenu = Models::where('parent_id', '<>', 0)->orderBy('mod_id','ASC')->get();

        //所有一级菜单
        $select_data = Models::where('parent_id', 0)->get();
        return view('extman.role.menu',[
            'pages' => $pages,
            '_smenu' => $_smenu,
            'select_data' => $select_data,
        ]);
    }

    /**
     * 删除菜单
     */
    public function delmenu(Request $request)
    {
        $mod_id = $request->get('mod_id');

        $Models = new Models();
        $Permissions = new Permissions();

        DB::beginTransaction();

        //有子菜单不能删除
        $son_data = $Models->where('parent_id', $mod_id)->get()->toArray();
        if($son_data) {
            DB::rollBack();
            return $this->echoJSON(false,'请先删该类下面所有除子菜单');
        }

        $is_del = $Models->where('mod_id',$mod_id)->delete();
        if(!$is_del) {
            DB::rollBack();
            return $this->echoJSON(false,'删除失败');
        }


        $is_del_assigned = $Permissions->where('mod_id', $mod_id)->delete();

        if(!$is_del_assigned){
            DB::rollBack();
            return $this->echoJSON(false,'删除失败');
        }

        DB::commit();
        return $this->echoJSON('删除成功');
    }

    /**
     * 创建菜单
     */
    public function addmenu(Request $request)
    {
        $Models = new Models();
        $Permissions = new Permissions();

        //表单校验
        $validator = $Models->validator($request->all());
        if ($validator->fails()) {
            return redirect('/role/menu')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        //校验成功入库
        $mod_id = $Models->creates($request->all());

        if(!$mod_id){
            DB::rollBack();
            return redirect('/role/menu')->with(['type'=>'error','msg'=>'添加失败']);
        }

        $menu = $Models->select('mod_id')->where('mod_id',$mod_id)->first()->toArray();

        $super = $Permissions->create($menu);

        if(!$super){
            DB::rollBack();
            return redirect('/role/menu')->with(['type'=>'error','msg'=>'添加失败']);
        }
        DB::commit();
        return redirect('/role/menu')->with(['type'=>'success','msg'=>'创建成功']);
    }

    /**
     * 修改菜单
     */
    public function editmenu(Request $request)
    {
        $NavModel = new Models();
        $data = $request->all();

        $filte = [
            'mod_name'              => $data['mod_name'],
            'parent_id'             => $data['parent_id'],
            'controller_name'       => $data['controller_name'],
            'action_name'           => $data['action_name']?$data['action_name']:'',
            'url'                   => $data['url']?$data['url']:'',
            'icon_class'            => $data['icon_class']?$data['icon_class']:'',
            'sort'                  => $data['sort']?$data['sort']:9999,
            'is_show'               => $data['is_show'],
        ];

        if(!empty($data)){
            $is_update = $NavModel->where('mod_id', $data['mod_id'])->update($filte);
            if(!$is_update){
                return redirect('/role/menu')->with(['type'=>'error','msg'=>'编辑失败']);
            }
            return redirect('/role/menu')->with(['type'=>'success','msg'=>'编辑成功']);

        }
    }

    /**
     * 权限组列表/角色列表
     */
    public function group($id = 0)
    {
        //角色列表 角色ID
        if($id > 0){
            $roles =$this->roles->where('parent_id','<>',0)
                                    ->where('parent_id', $id)
                                    ->orderBy('id', 'ASC')
                                    ->paginate(config('system.page_limit'));
            //权限组
            $groups = $this->roles->where('parent_id',0)->get();
            return view('extman.role.group',[
                'role_id' =>$id,
                'tag' => 'role',
                'groups' => $groups,//权限列表
                'pages' => $roles, //角色列表
            ]);
        }

        //权限组列表
        $groups = $this->roles->where('parent_id', 0)->orderBy('id','ASC')->paginate(config('system.page_limit'));
        return view('extman.role.group',[
            'pages' => $groups,
        ]);
    }

    /**
     * 创建权限组/角色
     */
    public function addgroup(Request $request)
    {
        $input = $request->all();
        $is_save = $this->roles->create($input);

        $url = '/role/group';
        $msg = '权限组创建成功.';

        //创建角色跳转
        if(!empty($input['parent_id'])) {
            $url = '/role/group/'.$input['parent_id'];
            $msg = '角色创建成功.';
        }

        if(!$is_save){
            return redirect($url)->with(['type'=>'error','msg'=>'创建失败']);
        }
        return redirect($url)->with(['type'=>'success','msg'=>$msg]);
    }

    /**
     * 编辑权限组
     */
    public function editgroup(Request $request)
    {
        $input = $request->all();
        $is_update = $this->roles->find($input['id'])->update($input);

        $url = '/role/group';
        $msg = '权限组编辑成功.';

        //编辑角色跳转
        if(!empty($input['parent_id'])) {
            $url = '/role/group/'.$input['parent_id'];
            $msg = '角色编辑成功.';
        }

        if(!$is_update){
            return redirect($url)->with(['type'=>'error','msg'=>'编辑失败']);
        }
        return redirect($url)->with(['type'=>'success','msg'=>$msg]);
    }

    /**
     * 删除权限组、角色
     */
    public function delgroup(Request $request)
    {
        if ($request->ajax()) {

            $id = $request->get('id');

            //权限组下面有角色不能删除
            $data = $this->roles->where('parent_id', $id)->first();
            if (isset($data)) {
                return $this->echoJSON(false, '请先清空该组的所有角色成员');
            }

            //权限，角色己分配过不能删除
            $user_data = AdminUsers::where('group_id', $id)->orwhere('role_id', $id)->first();
            if (isset($user_data)) {
                return $this->echoJSON(false, '该角色己分配无法删除');
            }

            $is_per = Permissions::select()->where('role_id', $id)->get();

            if (count($is_per) > 0) {
                DB::beginTransaction();
                $del_role = $this->roles->where('id', $id)->delete();
                $del_per = Permissions::where('role_id', $id)->delete();

                if ($del_role && $del_per) {
                    DB::commit();
                    return $this->echoJSON('删除成功');
                } else {
                    DB::rollback();
                    return $this->echoJSON(false, '删除失败');
                }
            } else {
                $this->roles->where('id', $id)->delete();
                return $this->echoJSON('删除成功');
            }
        }
    }

    /**权限列表
     * @param $id 角色ID
     */
    public function permission($id)
    {
        $models = new Models();
        $permission = new Permissions();
        //所有权限
        $data = modTree($models->getAllNav());
        //当前角色所获得的权限
        $role_mod_data = $permission->getRoleMod($id);

        return view('extman.role.permission',[
            'role_id' => $id,
            'nav_data' => $data,
            'role_mod_data' => $role_mod_data
        ]);
    }

    /**
     * 编辑/创建权限
     */
    public function rolepermission(Request $request)
    {
        $input = $request->all();

        //角色组ID
        $input['group_id'] = $this->roles->find($input['role_id'])->parent_id;
        $permission = new Permissions();
        list($flag, $err) = $permission->saveData($input);

        if ($flag == false) {
            return redirect('/role/permission/'.$input['role_id'])->with(['type'=>'error','msg'=>'权限分配失败']);
        }

        return redirect('/role/permission/'.$input['role_id'])->with(['type'=>'success','msg'=>'权限分配成功']);
    }

}
