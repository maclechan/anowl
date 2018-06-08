<?php
namespace App\Models\Role;
/**
 * 权限模型
 * @author  maclechan@qq.com
 * @date    2018/5/16
 */

use DB;
use App\Models\Role\Models;
use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    //关联到模型的数据表
    protected $table = 'permissions';

    //主键
    protected $primaryKey = 'id';

    //所有属性都是可批量赋值
    protected $guarded = [];

    /**
     * 获取菜单表和权限分配表的交集数据
     *
     * @param $group_id  用户组ID
     * @param $role_id   角色ID
     * @return mixed
     */
    static public function getAllAssigned($group_id,$role_id)
    {
        $data = DB::table('permissions')
                    ->where('permissions.group_id',$group_id)
                    ->where('permissions.role_id',$role_id)
                    ->join('models', 'permissions.mod_id', '=', 'models.mod_id')
                    ->orderBy('models.sort', 'ASC')
                    ->orderBy('models.mod_id', 'ASC')
                    ->get();

        return $data;
    }
}
