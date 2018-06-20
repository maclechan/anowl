<?php
use Illuminate\Database\Seeder;
use App\Models\Role\Roles;

class RoleTableSeeder extends Seeder
{
    /** 角色填充
     *  php artisan db:seed --class=AdminUsersTableSeeder
     * @return void
     */
    public function run()
    {
        $role_name = ['超管组', '超级管理员', '财务部', '财务总监'];
        $role_description = ['超级管理组', '后台管理组', '财务部', '财务总监'];
        $parent_id = [0,1,0,3];
        $type = [0,1,0,1];

        for ($i = 0; $i < count($role_name); $i++) {
            Roles::create([
                'role_name' => $role_name[$i],
                'role_description' => $role_description[$i],
                'parent_id' => $parent_id[$i],
                'type' => $type[$i],
            ]);
        }
    }
}
