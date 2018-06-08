<?php
use Illuminate\Database\Seeder;
use App\Models\Role\AdminUsers;

class AdminUsersTableSeeder extends Seeder
{
    /**
     *  单独填充.
     *  php artisan db:seed --class=AdminUsersTableSeeder
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $password = Hash::make('admin');
        $now = Carbon\Carbon::now()->toDateTimeString();
        // 头像假数据
        $avatars = [
            '/img/avatar/1.png',
            '/img/avatar/2.png',
            '/img/avatar/3.png',
            '/img/avatar/4.png',
            '/img/avatar/5.png',
            '/img/avatar/6.png',
            '/img/avatar/7.png',
            '/img/avatar/8.png',
            '/img/avatar/9.png',
            '/img/avatar/10.png',
            '/img/avatar/11.png',
            '/img/avatar/12.png',
            '/img/avatar/13.png',
            '/img/avatar/14.png',
            '/img/avatar/15.png',
            '/img/avatar/16.png',
            '/img/avatar/17.png',
            '/img/avatar/18.png',
            '/img/avatar/19.png',
            '/img/avatar/20.png',
        ];

        AdminUsers::create([
            'name' => 'maclechan',
            'nick_name' => '管理员',
            'email' => 'maclechan@qq.com',
            'group_id' => 1,
            'role_id' => 2,
            'password' => $password,
            'avatar' => $faker->randomElement($avatars),
            'last_login_time' => $now,
        ]);

        for ($i = 0; $i < 20; $i++) {
            AdminUsers::create([
                'name' => $faker->name,
                'nick_name' => $faker->name,
                'email' => $faker->email,
                'password' => $password,
                'avatar' => $avatars[$i+1],
                'last_login_time' => $now,
            ]);
        }

    }
}
