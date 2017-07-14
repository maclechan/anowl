<?php
namespace App\Models\Back;

/**
 * 管理后台用户角色模型
 * @Author  maclechan@qq.com
 * @date    2017/6/14
 */

use App\Models\BaseModel;

class AdminRole extends BaseModel
{
    protected $table = 'admin_role';

    protected $primaryKey = 'id';

    protected $fillable = ['role_name', 'role_description', 'parent_id', 'type'];

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            'role_name' => 'required',
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
            'role_name' => '角色名称',
            'role_description' => '角色描述',
            'parent_id' => '父ID',
            'type' => '0=部门 1=角色组',
        ];
    }

    /**
     * 获取权限/角色数据
     * @param $group_id 权限组(角色) ID
     * @param int $type (0=权限组 1=角色)
     * @return array
     */
    static function getRoleGroupByType($group_id,$type = 0)
    {
        $roleModel = self::where('type',$type);
        if($group_id){
            $roleModel = $roleModel->where('parent_id',$group_id);
        }
        $group_data = $roleModel->orderBy('id','ASC')
                                ->get()
                                ->toArray();
        return $group_data;
    }

    /**
     * 获取一条信息
     */
    static function getPkId($_id)
    {
        return self::where('id',$_id)->first();
    }

}
