<?php
namespace App\Http\Controllers\Back;

/**
 * 用户权限
 * @Author  maclechan@qq.com
 * @date    2017-5-30
 */

use DB,Validator;
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
}
