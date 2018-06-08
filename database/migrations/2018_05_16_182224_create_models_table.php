<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelsTable extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate
     * @return void
     */
    public function up()
    {
        Schema::create('models', function (Blueprint $table) {
            $table->increments('mod_id');
            $table->string('mod_name',60)->default('')->comment('菜单中文名称');
            $table->integer('parent_id')->default('0')->unsigned()->comment('父ID');
            $table->string('controller_name',128)->default('')->comment('菜单控制器名');
            $table->string('action_name',128)->default('')->comment('菜单方法名');
            $table->string('url',128)->default('')->comment('菜单路径');
            $table->string('icon_class',30)->default('')->comment('图标样式');
            $table->unsignedInteger('sort')->default('9999')->comment('排序');
            $table->unsignedTinyInteger('is_show')->default('0')->comment('菜单栏 (0:显示 1:隐藏)');
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
        Schema::dropIfExists('models');
    }
}
