<?php
use Illuminate\Database\Seeder;
use App\Models\Role\Permissions;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 15; $i++) {
            Permissions::create([
                'group_id' => 1,
                'role_id' => 2,
                'mod_id' => $i+1
            ]);
        }
    }
}
