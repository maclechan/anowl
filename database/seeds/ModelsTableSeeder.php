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
            '权限管理', '用户列表', '菜单列表', '角色组列表', '创建用户', '编辑用户', '删除用户', '创建角色',
            '编辑角色', '删除角色', '权限列表', '创建权限', '创建菜单', '修改菜单', '删除菜单'
        ];

        $parent_id = [
            '0', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1'
        ];

        $controller_name = [
            'Role', 'Role', 'Role', 'Role', 'Role', 'Role', 'Role', 'Role', 'Role', 'Role', 'Role', 'Role', 'Role', 'Role', 'Role'
        ];

        $action_name = [
            '', 'index', 'navList', 'grouList', 'add', 'edit', 'del', 'addGroup', 'editGroup',
            'delGroup', 'permission', 'rolePermission', 'addMenu', 'editMenu', 'delMenu'
        ];

        $url = [
            '', '/role/index', '/role/navlist', '/role/groulist', '/role/add', '/role/edit', '/role/del',
            '/role/addgroup', '/role/editgroup','/role/delgroup', '/role/permission', '/role/rolepermission',
            '/role/addmenu', '/role/editmenu', '/role/delmenu'
        ];

        $icon_class = [
            'fa-project-diagram', 'fa-user-ninja', 'fa-clipboard-list', 'fa-sitemap', '', '', '', '', '','', '', '', '', '', ''
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
