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
}
