<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 使用基于类方法
        // 第一个参数可以指定共享给那个视图,多个视图用数组，共享到全部视图可以用 *
        view()->composer(
            ['extman.*'], 'App\Http\ViewComposers\AuthComposer'
        );

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
