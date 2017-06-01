<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminAssignedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_assigned', function (Blueprint $table) {
            $table->increments('assigned_id');
            $table->integer('group_id')->default('1')->unsigned()->comment('分组ID');
            $table->integer('role_id')->default('2')->unsigned()->comment('角色ID');
            $table->integer('nav_id')->default('0')->unsigned()->comment('菜单ID');
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
        Schema::drop('admin_assigned');
    }
}
