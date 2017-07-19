<?php
namespace App\Providers;

/**
 * 文件上传服务提供者
 * @Author  maclechan@qq.com
 * @date    2017/7/19
 */

use Illuminate\Support\ServiceProvider;

class UploadServiceProvider extends ServiceProvider
{
    //服务提供者是否延迟加载.
    /*protected $defer = true;

    //返回该提供者注册的服务容器绑定
    public function provides()
    {
        return ['\App\Services\Upload'];
    }*/


    /**
     * Bootstrap the application services.
     *  启动应用程序服务
     */
    public function boot()
    {
        //
    }

    /**
     *  Register the application services.
     *  在容器中注册绑定
     */
    public function register()
    {
        //使用singleton绑定单例
        $this->app->singleton('UploadService',function(){
            return new \App\Services\UploadService;
        });


        //使用bind绑定实例到接口以便依赖注入
        /*$this->app->bind('App\Services\Upload',function(){
            return new Upload();
        });*/


        /*$this->app->singleton('Upload', function ($app) {
            return new \App\Services\Upload();
        });*/
    }
}
