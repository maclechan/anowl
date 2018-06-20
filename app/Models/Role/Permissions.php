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

    /*
     *设置角色权限
     * @arr  表单提交的权限数组
     */
    public function saveData(array $arr)
    {
        $err       = '';
        $flag      = true;
        $is_delete = self::where(['group_id' => $arr['group_id'],'role_id'  => $arr['role_id']])->delete();

        //严谨判断是否删除成功
        foreach($arr['mod_id'] as $value){
            $save_array = [
                'group_id' => $arr['group_id'],
                'role_id'  => $arr['role_id'],
                'mod_id'   => $value,
            ];
            $is_save = self::create($save_array);
            if(!$is_save){
                $mod_name = Models::find($value)->mod_name;
                $err .= $mod_name.', ';
                $flag = false;
            }
        }

        return array($flag, $err);
    }

    /*
     * 获取当前角色拥有的权限
     * @id   角色id
     */
    public function getRoleMod($id)
    {
        $mod_data = self::where('role_id',$id)->get()->toArray();
        $role_mod_data = [];
        foreach($mod_data as $value){
            array_push($role_mod_data, $value['mod_id']);
        }
        return $role_mod_data;
    }
}
