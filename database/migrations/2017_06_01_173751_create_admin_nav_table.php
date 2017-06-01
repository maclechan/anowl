<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminNavTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_nav', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('nav_id');
            $table->string('nav_name',60)->default('')->comment('菜单中文名称');
            $table->integer('parent_id')->default('0')->unsigned()->comment('父ID');
            $table->string('controller_name',128)->default('')->comment('菜单控制器名');
            $table->string('action_name',128)->default('')->comment('菜单方法名');
            $table->string('url',128)->default('')->comment('菜单路径');
            $table->string('icon_class',30)->default('')->comment('图标样式');
            $table->mediumInteger('sort')->default('9999')->unsigned()->comment('排序');
            $table->tinyInteger('is_show')->default('0')->unsigned()->comment('菜单栏 (1:显示 0:隐藏)');
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
        Schema::drop('admin_nav');
    }
}
