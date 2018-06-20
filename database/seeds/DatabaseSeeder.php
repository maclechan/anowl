<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * 填充加载的填充器.
     * php artisan db:seed
     * @return void
     */
    public function run()
    {
          //后台管理帐号
         $this->call(AdminUsersTableSeeder::class);
          //后台角色组
         $this->call(RoleTableSeeder::class);
         //后台菜单管理
         $this->call(ModelsTableSeeder::class);
          //后台权限管理
         $this->call(PermissionsTableSeeder::class);
    }
}
