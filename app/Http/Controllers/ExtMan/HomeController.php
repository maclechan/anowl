<?php
namespace App\Http\Controllers\ExtMan;

use Illuminate\Http\Request;
//use App\Http\Controllers\ExtMan\BaseController;
use Illuminate\Contracts\Auth\Guard,
    Illuminate\Support\Facades\Auth,
    Illuminate\Support\Facades\View;
use App\Models\Role\AdminUsers;
use Illuminate\Support\Facades\Route;

class HomeController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$user = \Auth::user();
        //$user_info = $this->auth->guest();
        //$user_info = $this->auth->user();
        //print_r($this->user_message);
       // dd($this->user_info);



        $now = \Carbon\Carbon::now();

        return view('extman.home');
    }

    public function addGroup(){
        $route = Route::current();
        $name = Route::currentRouteName();

        //App\Http\Controllers\ExtMan\HomeController@addGroup
        $action = Route::currentRouteAction();

        //home/addGroup
        //echo($route->uri);


        $route  = app('Illuminate\Routing\Route');

        // print_r(get_in());
         //print_r($route->controller_name);
         //print_r($route->action_name);

        return view('extman.home');
    }

    public function show(Request $request)
    {
        // 获取当前认证用户...
        $user = \Auth::user();

        // 获取当前认证用户的ID...
        $id = \Auth::id();

        $users = $request->user();

        //返回认证用户实例...
        print_r($user->name);
    }
}
