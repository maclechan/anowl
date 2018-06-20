<?php
use Illuminate\Database\Seeder;
use App\Models\Role\Models;

class ModelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mod_name = [
            '权限管理', '帐户管理', '菜单管理', '权限分配', '创建帐号', '编辑帐号', '删除帐号', '创建权限',
            '编辑权限', '删除权限', '分配权限', '创建权限', '创建菜单', '修改菜单', '删除菜单'
        ];

        $parent_id = [
            '0', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1'
        ];

        $controller_name = [
            'Role', 'Role', 'Role', 'Role', 'Role', 'Role', 'Role', 'Role', 'Role', 'Role', 'Role', 'Role', 'Role', 'Role', 'Role'
        ];

        $action_name = [
            '', 'index', 'menu', 'group', 'add', 'edit', 'del', 'addgroup', 'editgroup',
            'delgroup', 'permission', 'addpermission', 'addmenu', 'editmenu', 'delmenu'
        ];

        $url = [
            '', '/role/index', '/role/menu', '/role/group', '/role/add', '/role/edit', '/role/del',
            '/role/addgroup', '/role/editgroup','/role/delgroup', '/role/permission', '/role/addpermission',
            '/role/addmenu', '/role/editmenu', '/role/delmenu'
        ];

        $icon_class = [
            'fa-clipboard', 'fa-user-ninja', 'fa-clipboard-list', 'fa-code-branch', '', '', '', '', '','', '', '', '', '', ''
        ];

        $is_show = [
            '0', '0', '0', '0', '1', '1', '1', '1', '1','1', '1', '1', '1', '1', '1'
        ];
        for ($i = 0; $i < count($mod_name); $i++) {
            Models::create([
                'mod_name' => $mod_name[$i],
                'parent_id' => $parent_id[$i],
                'controller_name' => $controller_name[$i],
                'action_name' => $action_name[$i],
                'url' => $url[$i],
                'icon_class' => $icon_class[$i],
                'is_show' => $is_show[$i],
            ]);
        }
    }
}
