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

    //protected $fillable = ['action_name', 'url', 'icon_class', 'sort', 'is_show'];

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

}
