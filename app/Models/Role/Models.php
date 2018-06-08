<?php
namespace App\Models\Role;
/**
 * 菜单模块模型
 * @author  maclechan@qq.com
 * @date    2018/5/16
 */

use DB;
use App\Models\Role\Permissions;
use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    //关联到模型的数据表
    protected $table = 'models';

    //主键
    protected $primaryKey = 'mod_id';

    static $crumb;

    static $key = 0;

    /**
     * 获取权限下的菜单
     * @param $group_id  用户组ID
     * @param $role_id   角色ID
     * @return mixed
     */
    static function Assigned($group_id,$role_id)
    {
        //获取菜单表和权限分配表的交集数据
        $assigned_data  = Permissions::getAllAssigned($group_id,$role_id);

        foreach($assigned_data as $key => $value){
            //p_id !=0   is_show=1
            if(!$value->parent_id && !$value->is_show){
                $assigned[$value->mod_id] = $value;

                //二级菜单
                foreach($assigned_data as $k => $v){
                    if($v->parent_id == $value->mod_id && $v->is_show == 0){
                        $assigned[$value->mod_id]->menu[] = $v;
                    }
                }

            }
        }
        return $assigned;

    }

    /**
     * 树状菜单
     * @return mixed
     */
    static function getAllMenu(){
        $_data = DB::table('models')
            ->orderBy('mod_id', 'ASC')
            ->get();

        foreach($_data as $key => $value){
            if(!$value->parent_id){
                $nav[$value->mod_id] = $value;

                //二级菜单
                foreach($_data as $k => $v){
                    if($v->parent_id == $value->mod_id){
                        $nav[$value->mod_id]->menu[] = $v;
                    }
                }

            }
        }
        return $nav;
    }

    /**
     * 面包屑
     * @param $controller_name
     * @param $action_name
     * @return mixed
     */
    static function getCrumb($controller_name, $action_name)
    {
        $controller_array = explode('Controller',$controller_name);

        //当前控制器、方法
        $data = self::where('controller_name',$controller_array[0])
                        ->where('action_name',$action_name) //这里应有问题
                        ->get()
                        ->toArray();
        //查找父类
        self::getBackstepping($data[0]['mod_id']);

        krsort(self::$crumb);
        return self::$crumb;
    }

    /**
     * @param $nav_id 2
     */
    static function getBackstepping($mod_id)
    {
        $k        = self::$key++; //1
        //当前菜单
        $nav_data = self::where('mod_id',$mod_id)->get()->toArray();
        self::$crumb[$k]['mod_name']        = $nav_data[0]['mod_name'];
        self::$crumb[$k]['url']             = $nav_data[0]['url'];
        self::$crumb[$k]['action_name']     = $nav_data[0]['action_name'];
        self::$crumb[$k]['controller_name'] = $nav_data[0]['controller_name'];

        if($nav_data[0]['parent_id']){
            $parent_nav_data = self::where('mod_id',$nav_data[0]['parent_id'])->get()->toArray();
            self::$crumb[$k]['parent_action_name'] = $parent_nav_data[0]['action_name'];
        }

        //查找父类
        if($nav_data[0]['parent_id']){
            self::getBackstepping($nav_data[0]['parent_id']);
        }
    }
}
