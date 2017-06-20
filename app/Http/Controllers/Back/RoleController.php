<?php
namespace App\Http\Controllers\Back;

/**
 * 用户权限
 * @Author  maclechan@qq.com
 * @date    2017-5-30
 */

use DB,
    Input,
    Validator;
use Illuminate\Http\Request;

use App\Models\Back\AdminRole;
use App\Models\Back\AdminUsers;

class RoleController extends BaseController
{
    /**
     * 用户列表
     */
    public function getIndex($group_id=0)
    {
        #角色
        if($group_id){
            $role_group = AdminRoleGroupModel::getRoleGroupByType($group_id,1);
            die(json_encode($role_group));
        }
        #权限组
        $group_data = AdminRole::getRoleGroupByType(0);



        //权限组列表
        $groups = AdminRole::where('parent_id', 0)->orderBy('id','ASC')->get();


        $users = AdminUsers::orderBy('id','ASC')->paginate(config('system.page_limit'));
        return view('back.role.index',[
            'pages' => $users,
            'groups' => $groups
        ]);
    }

    /**
     * 创建用户
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return AdminUsers::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'nick_name' => $data['nick_name'],
                'mobile' => $data['mobile'],
                'status' => $data['status'],
            ]
        );
    }

    //显示添加用户视图
    public function getAdd(Request $request)
    {
        return view('back.role.add');
    }

    /**
     * 创建用户
     */
    public function postAdd(Request $request)
    {
        $userModel = new AdminUsers();
        /*表单校验*/
        $validator = $userModel->validator($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        //校验成功入库
        $this->create($request->all());
        return redirect('/back/role/index');

    }

    /**
     * 修改用户
     */
    public function postEdit(Request $request)
    {
        $model = new AdminUsers();
        $input = $request->all();

        $info = $model->where('id', $input['id'])->first()->toArray();

        $filte = [
            'email'              => $input['email'],
            'nick_name'       => $input['nick_name'],
            'mobile'           => $input['mobile'],
            'status'                   => $input['status'],
        ];

        if($input['password']) {
            $filte['password'] =  bcrypt($input['password']);
        }

        if(!empty($input)){
            $is_update = $model->where('id', $info['id'])->update($filte);
            if(!$is_update){
                return redirect('back/role/index')->with('msg', '修改失败.');
            }
            return redirect('back/role/index')->with('msg', '修改成功.');
        }
    }

    /**
     * 删除用户
     */
    public function postDel() {
        if (Input::ajax()) {
            $id = Input::input('id');
            $model = new AdminUsers();

            $is_del = $model->where('id',$id)->delete();
            if(!$is_del) {
                $data = [
                    'code' => -200,
                    'msg'  => '删除失败',
                ];
                return response()->json($data);
            }

            $data = [
                'code' => 200,
                'msg' => '删除成功',
            ];
            return response()->json($data);
        }
    }

    /**
     * 权限组列表/角色列表
     */
    public function getGrouplist($id)
    {
        //角色列表 角色ID
        if($id>0){
            $roles = AdminRole::where('parent_id','<>',0)
                                    ->where('parent_id', $id)
                                    ->orderBy('id', 'ASC')
                                    ->paginate(config('system.page_limit'));
            //权限组
            $groups = AdminRole::where('parent_id',0)->get();
            return view('back.role.grouplist',[
                'role_id' =>$id,
                'tag' => 'role',
                'groups' => $groups,//权限列表
                'pages' => $roles, //角色列表
            ]);
        }

        //权限组列表
        $groups = AdminRole::where('parent_id', 0)->orderBy('id','ASC')->paginate(config('system.page_limit'));
        return view('back.role.grouplist',[
            'pages' => $groups,
        ]);
    }

    /**
     * 创建权限组/角色
     */
    public function postAddgroup()
    {
        $input = Input::all();
        $is_save = AdminRole::create($input);

        $url = '/back/role/grouplist';
        $msg = '权限组创建成功.';

        //创建角色跳转
        if($input['role_id']){
            $url = '/back/role/grouplist/'.$input['role_id'];
            $msg = '角色创建成功.';
        }

        if(!$is_save){
            return redirect($url)->with('msg', '创建失败.');
        }
        return redirect($url)->with('msg', $msg);
    }

    /**
     * 编辑权限组
     */
    public function postEditgroup()
    {
        $input = Input::all();
        $is_update = AdminRole::find($input['id'])->update($input);

        $url = '/back/role/grouplist';
        $msg = '权限组编辑成功.';

        //编辑角色跳转
        if($input['role_id']){
            $url = '/back/role/grouplist/'.$input['role_id'];
            $msg = '角色编辑成功.';
        }

        if(!$is_update){
            return redirect($url)->with('msg', '编辑失败.');
        }
        return redirect($url)->with('msg', $msg);
    }

    /**
     * 删除权限组、角色
     */
    public function postDelgroup() {
        if (Input::ajax()) {
            $id = Input::input('id');
            $model = new AdminRole();

            //权限组下面有角色不能删除
            $data = $model::where('parent_id',$id)->first();
            if(count($data)>0){
                $data = [
                    'code' => -200,
                    'msg'  => '请先清空该组的所有角色成员.',
                ];
                return response()->json($data);
            }

            //权限，角色己分配过不能删除
            $user_data = AdminUsers::where('group_id',$id)->orwhere('role_id',$id)->first();
            if(count($user_data)>0){
                $data = [
                    'code' => -200,
                    'msg'  => '该权限己分配无法删除.',
                ];
                return response()->json($data);
            }

            $is_del = $model->where('id',$id)->delete();
            if(!$is_del) {
                $data = [
                    'code' => -200,
                    'msg'  => '删除失败.',
                ];
                return response()->json($data);
            }

            $data = [
                'code' => 200,
                'msg' => '删除成功.',
            ];
            return response()->json($data);
        }
    }
}
