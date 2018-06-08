<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUsersTable extends Migration
{
    /**
     * 新增表
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 60)->default('')->comment('用户名称');
            $table->string('nick_name', 60)->default('')->comment('用户昵称');
            $table->string('avatar')->default('')->comment('用户图像');
            $table->string('email', 100)->default('')->comment('用户邮箱');
            $table->string('password', 255)->default('')->comment('密码');
            $table->rememberToken()->comment('记住登陆状态');
            $table->char('mobile', 11)->default('')->comment('手机号');
            $table->unsignedInteger('group_id')->default('0')->comment('组别ID');
            $table->unsignedInteger('role_id')->default('0')->comment('角色ID');
            $table->unsignedTinyInteger('status')->default('0')->comment('状态 0=正常,1=禁止');
            $table->timestamps();
            $table->timestamp('last_login_time')->nullable();

            $table->unique('email','email');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_users');
    }
}
