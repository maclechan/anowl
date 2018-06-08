<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('role_name', 60)->default('')->comment('角色名称');
            $table->string('role_description', 128)->default('')->comment('角色描述');
            $table->unsignedInteger('parent_id')->default('0')->comment('上级ID');
            $table->unsignedTinyInteger('type')->default('0')->comment('0=部门 1=角色组');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
