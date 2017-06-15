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
use App\Models\Back\AdminUsers;

class RoleController extends BaseController
{
    public function getIndex()
    {
        $_data = DB::table('admin_users')
            ->orderBy('id', 'ASC')
            ->paginate(config('system.page_limit'));

        return view('back.role.index',[
            'pages' => $_data,
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

    //创建用户
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

    //修改用户
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
                return redirect('back/role/index')->with('msg', '修改失败!');
            }
            return redirect('back/role/index')->with('msg', '修改成功!');
        }
    }

    /**
     * 删除用户
     */
    public function postDel() {
        if (Input::ajax()) {
            $id = Input::input('id');
            $model = new AdminUsers();

            //DB::beginTransaction();
            $is_del = $model->where('id',$id)->delete();
            if(!$is_del) {
                DB::rollBack();
                $data = [
                    'code' => -200,
                    'msg'  => '删除失败',
                ];
                return response()->json($data);
            }

            /*$is_del_assigned = $AssignedModel->where('nav_id', $nav_id)->delete();
            if(!$is_del_assigned){
                DB::rollBack();
                $data = [
                    'code' => -200,
                    'msg'  => '删除失败',
                ];
                return response()->json($data);
            }*/
            //DB::commit();
            $data = [
                'code' => 200,
                'msg' => '删除成功',
            ];
            return response()->json($data);
        }
    }
}
