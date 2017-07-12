<?php
namespace App\Models\Back;

/**
 * 管理后台菜单模型
 * @Author  maclechan@qq.com
 * @date    2017/6/1
 */

use DB;
use App\Models\BaseModel;
use App\Models\Back\AdminNav;

class AdminAssigned extends BaseModel
{
    protected $table      = 'admin_assigned';
    protected $primaryKey = 'assigned_id';
    protected $fillable = ['group_id', 'role_id', 'nav_id', 'created_at', 'updated_at'];

    /**
     * 获取菜单表和权限分配表的交集数据
     *
     * @param $group_id  用户组ID
     * @param $role_id   角色ID
     * @return mixed
     */
    static public function getAllAssigned($group_id,$role_id){
        $assigned_data = DB::table('admin_assigned')
            ->where('admin_assigned.group_id',$group_id)
            ->where('admin_assigned.role_id',$role_id)
            ->join('admin_nav', 'admin_assigned.nav_id', '=', 'admin_nav.nav_id')
            ->orderBy('admin_nav.sort', 'ASC')
            ->orderBy('admin_nav.nav_id', 'ASC')
            ->get();
        return $assigned_data;
    }

    /*
     *设置角色权限
     * @arr  表单提交的权限数组
     */
    static function saveData(array $arr){
        $err       = '';
        $flag      = true;
        $is_delete = self::where(['group_id' => $arr['group_id'],'role_id'  => $arr['role_id']])->delete();

        //严谨判断是否删除成功
        foreach($arr['nav_id'] as $value){
            $save_array = [
                'group_id' => $arr['group_id'],
                'role_id'  => $arr['role_id'],
                'nav_id'   => $value,
                //'create_time'=> mktime()
            ];
            $is_save = self::create($save_array);
            if(!$is_save){
                $nav_name = AdminNav::find($value)->nav_name;
                $err .= $nav_name.', ';
                $flag = false;
            }
        }
        return array($flag, $err);
    }

    /*
     * 获取当前角色拥有的权限
     * @id   角色id
     */
    static function getRoleMod($id){
        $mod_data = self::where('role_id',$id)->get()->toArray();
        $role_mod_data = [];
        foreach($mod_data as $value){
            array_push($role_mod_data, $value['nav_id']);
        }
        return $role_mod_data;
    }
}
