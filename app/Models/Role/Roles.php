<?php
namespace App\Models\Role;
/**
 * 角色模型
 * @author  maclechan@qq.com
 * @date    2018/5/16
 */

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    //关联到模型的数据表
    protected $table = 'roles';

    //主键
    protected $primaryKey = 'id';

    //允许被批量赋值的属性(包括自定义和http请求)
    /*protected $fillable = [
        'role_name', 'role_description', 'parent_id', 'type'
    ];*/

    //所有属性都是可批量赋值
    protected $guarded = [];

    //获取角色信息
    public function getById($_id)
    {
        return self::where('id',$_id)->first();
    }

    /**
     * 获取权限/角色数据
     * @param $group_id 权限组(角色) ID
     * @param int $type (0=权限组 1=角色)
     * @return array
     */
    public function getRoleGroupByType($group_id,$type = 0)
    {
        $group_data = self::where('type',$type)
                         ->when($group_id, function($query) use ($group_id){
                             return $query->where('parent_id',$group_id);
                         })
                        ->orderBy('id','ASC')
                        ->get()
                        ->toArray();

        return $group_data;
    }
}
