<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name',60)->default('')->comment('登陆帐号');
            $table->string('email',80)->default('')->unique()->comment('邮件');
            $table->string('password', 60)->default('')->comment('密码');
            $table->string('nick_name',10)->default('')->comment('姓名');
            $table->string('mobile',11)->default('')->comment('手机号');
            $table->rememberToken()->default('')->comment('认证');
            $table->integer('group_id')->default('0')->unsigned()->comment('组别ID');
            $table->integer('role_id')->default('0')->unsigned()->comment('角色ID');
            $table->tinyInteger('status')->unsigned()->default('0')->comment('0:正常 1:禁用');
            $table->integer('created_at')->default('0')->unsigned()->comment('创建时间');
            $table->integer('updated_at')->default('0')->unsigned()->comment('修改时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admin_users');
    }
}
