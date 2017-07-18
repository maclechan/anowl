<?php
namespace App\Http\Controllers\Back;

/**
 * 菜单管理
 * @Author  maclechan@qq.com
 * @date    2017-5-30
 */

use Input,DB,Validator;
use App\Models\Back\AdminNav;
use App\Models\Back\AdminAssigned;

use Illuminate\Http\Request;

class NavController extends BaseController
{
    /**
     * 菜单列表
     */
    public function getIndex(Request $request)
    {

        $pages = AdminNav::where('parent_id', 0)->orderBy('nav_id','ASC')->paginate(config('system.page_limit'));
        $_smenu = AdminNav::where('parent_id', '<>', 0)->orderBy('nav_id','ASC')->get();

        //所有一级菜单
        $select_data = AdminNav::where('parent_id', 0)->get();
        return view('back.nav.index',[
            'pages' => $pages,
            '_smenu' => $_smenu,
            'select_data' => $select_data,
        ]);
    }

    /**
     * 添加菜单
     */
    public function postAddmenu(Request $request)
    {
        $NavModel = new AdminNav();
        $AssignedModel = new AdminAssigned();

        /*表单校验*/
        $this->validate($request, $NavModel->rules(),$NavModel->ruleMsg());

        $input = $request->all();
        $filte = [
            'nav_name'              => $input['nav_name'],
            'parent_id'             => $input['parent_id'],
            'controller_name'       => $input['controller_name'],
            'action_name'           => $input['action_name'],
            'url'                   => $input['url'],
            'icon_class'            => $input['icon_class'],
            'sort'                  => $input['sort']?$input['sort']:9999,
            'is_show'               => $input['is_show'],
            'created_at'            =>time(),
            'updated_at'            =>time(),
        ];

        if(!empty($input)){
            DB::beginTransaction();
            $is_add = $NavModel->insertGetId($filte);
            if(!$is_add){
                DB::rollBack();
                return redirect('back/nav/index')->with(['type'=>'error','msg'=>'添加失败']);
            }
            $navDetail = $NavModel->select('nav_id')->where($filte)->first()->toArray();

            $navDetail['created_at'] = time();
            $navDetail['updated_at'] = time();
            $is_admin_assigned = $AssignedModel->insert($navDetail);

            if(!$is_admin_assigned){
                DB::rollBack();
                return redirect('back/nav/index')->with(['type'=>'error','msg'=>'添加失败']);
            }
            DB::commit();
               return redirect('back/nav/index')->with(['type'=>'success','msg'=>'创建成功']);
        }
    }

    /**
     * 修改菜单
     */
    public function postEditmenu()
    {
        $NavModel = new AdminNav();
        $input = Input::all();
        $info = $NavModel->where('nav_id', $input['nav_id'])->first()->toArray();

        $filte = [
            'nav_name'              => $input['nav_name'],
            'parent_id'             => $input['parent_id'],
            'controller_name'       => $input['controller_name'],
            'action_name'           => $input['action_name'],
            'url'                   => $input['url'],
            'icon_class'            => $input['icon_class'],
            'sort'                  => $input['sort']?$input['sort']:9999,
            'is_show'               => $input['is_show'],
            'updated_at'            =>time(),
        ];

        if(!empty($input)){
            $is_update = $NavModel->where('nav_id', $input['nav_id'])->update($filte);
            if(!$is_update){
                return redirect('back/nav/index')->with(['type'=>'error','msg'=>'添加失败']);
            }
            return redirect('back/nav/index')->with(['type'=>'success','msg'=>'创建成功']);

        }
    }

    /**
     * 删除菜单
     */
    public function postDel() {
        if (Input::ajax()) {
            $nav_id = Input::input('nav_id');

            $NavModel = new AdminNav();
            $AssignedModel = new AdminAssigned();

            DB::beginTransaction();

            //有子菜单不能删除
            $son_data = $NavModel->where('parent_id', $nav_id)->get()->toArray();
            if($son_data) {
                DB::rollBack();
                $data = [
                    'code' => -200,
                    'msg'  => '请先删该类下面所有除子菜单',
                ];
                return response()->json($data);
            }

            $is_del = $NavModel->where('nav_id',$nav_id)->delete();
            if(!$is_del) {
                DB::rollBack();
                $data = [
                    'code' => -200,
                    'msg'  => '删除失败',
                ];
                return response()->json($data);
            }

            $is_del_assigned = $AssignedModel->where('nav_id', $nav_id)->delete();
            if(!$is_del_assigned){
                DB::rollBack();
                $data = [
                    'code' => -200,
                    'msg'  => '删除失败',
                ];
                return response()->json($data);
            }
            DB::commit();
            $data = [
                'code' => 200,
                'msg' => '删除成功',
            ];
            return response()->json($data);
        }
    }

}
