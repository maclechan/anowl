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
    App\Models\Role\AdminUsers;

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

    /**创建用户(展示&保存)
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
            $is_save = $userModel->create($request->all());
            if($is_save){
                return redirect('/role/index')->with(['type'=>'success','msg'=>'创建成功']);
            }
        }
    }

    /**
     * 显示一个表单来创建一个新的资源.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * 保存最新创建的资源
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role_name = $request->get('role_name');
        $now = \Carbon\Carbon::now()->toDateTimeString();
        echo $now;
        /*Roles::create([
            'role_name' => $role_name,
            'role_description' => '管理组a',
            //'parent_id' => '0',
        ]);*/
        /*DB::table('roles')->insert([
            ['role_name' => '管理组', 'role_description' => '后台管理组','parent_id'=>0,'type'=>'0'],
            ['role_name' => '超级管理员', 'role_description' => '后台管理组','parent_id'=>1,'type'=>'1'],
            ['role_name' => '财务部', 'role_description' => '财务部','parent_id'=>0,'type'=>'0'],
            ['role_name' => '财务总监', 'role_description' => '财务总监','parent_id'=>3,'type'=>'1']
        ]);*/
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 显示一个表单来编辑指定的资源
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 更新指定的资源.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定的资源.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
