<?php
namespace App\Models\Back;

/**
 * 管理后台菜单模型
 * @Author  maclechan@qq.com
 * @date    2017/6/1
 */

use DB;
use App\Models\BaseModel;
use App\Models\Back\AdminAssigned;

class AdminNav extends BaseModel
{
    protected $table      = 'admin_nav';

    protected $primaryKey = 'nav_id';

    protected $fillable = ['action_name', 'url', 'icon_class', 'sort', 'is_show'];

    static $crumb;
    static $key = 0;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            'nav_name' => 'required',
            'parent_id' => 'required|numeric',
            'controller_name' => 'required',
        ];
    }

    /**
     * 自定义错误信息
     * @return array
     */
    public function ruleMsg()
    {
        return [
            'required' => ':attribute不能为空.',
        ];
    }

    /**
     * 字段映射中文
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'nav_name' => '菜单中文名称',
            'parent_id' => '父ID',
            'controller_name' => '菜单控制器名',
            'action_name' => '菜单方法名',
            'url' => '菜单路径',
            'icon_class' => '图标样式',
            'sort' => '排序',
            'is_show' => '菜单栏 (1:显示 0:隐藏)',
        ];
    }

    /**
     * 获取权限
     * @param $group_id  用户组ID
     * @param $role_id   角色ID
     * @return mixed
     */
    static function Assigned($group_id,$role_id){
        //获取菜单表和权限分配表的交集数据
        $assigned_data  = AdminAssigned::getAllAssigned($group_id,$role_id,1);

        foreach($assigned_data as $key => $value){
            if(!$value->parent_id && $value->is_show){
                $assigned[$value->nav_id] = $value;

                //二级菜单
                foreach($assigned_data as $k => $v){
                    if($v->parent_id == $value->nav_id && $v->is_show){
                        $assigned[$value->nav_id]->menu[] = $v;
                    }
                }

            }
        }
        return $assigned;
    }

    /**
     * 面包屑
     * @param $controller_name
     * @param $action_name
     * @return mixed
     */
    static function getCrumb($controller_name,$action_name){
        $controller_array = explode('Controller',$controller_name);
        $nav_data = AdminNav::where('controller_name',$controller_array[0])->where('action_name',$action_name)->get()->toArray();
        self::getBackstepping($nav_data[0]['nav_id']);
        krsort(self::$crumb);
        return self::$crumb;
    }

    /**
     * @param $nav_id
     */
    static function getBackstepping($nav_id){
        $k        = self::$key++;
        $nav_data = AdminNav::where('nav_id',$nav_id)->get()->toArray();

        self::$crumb[$k]['nav_name']        = $nav_data[0]['nav_name'];
        self::$crumb[$k]['url']             = $nav_data[0]['url'];
        self::$crumb[$k]['action_name']     = $nav_data[0]['action_name'];
        self::$crumb[$k]['controller_name'] = $nav_data[0]['controller_name'];
        if($nav_data[0]['parent_id']){
            $parent_nav_data = AdminNav::where('nav_id',$nav_data[0]['parent_id'])->get()->toArray();
            self::$crumb[$k]['parent_action_name'] = $parent_nav_data[0]['action_name'];
        }

        if($nav_data[0]['parent_id']){
            self::getBackstepping($nav_data[0]['parent_id']);
        }
    }

    /**
     * 树状菜单
     * @return mixed
     */
    public function getAllMenu(){
        $_data = DB::table('admin_nav')
            ->orderBy('nav_id', 'ASC')
            ->get();

        foreach($_data as $key => $value){
            if(!$value->parent_id){
                $nav[$value->nav_id] = $value;

                //二级菜单
                foreach($_data as $k => $v){
                    if($v->parent_id == $value->nav_id){
                        $nav[$value->nav_id]->menu[] = $v;
                    }
                }

            }
        }
        return $nav;
    }

    /**所有菜单数据
     * @return mixed
     */
    static function getAllNav(){
        $data = self::orderBy('nav_id','ASC')
            ->orderBy('parent_id','ASC')
            ->get()->toArray();
        return $data;
    }
}
