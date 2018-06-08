<?php
namespace App\Http\Controllers\ExtMan\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    //登录认证成功后的跳转路径
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('extman.login');
    }

    //重写登陆
    public function login(Request $request)
    {
        //表单验证
        $this->validateLogin($request);

        if (Auth::attempt($request->only(['email','password']), $request->filled('remember'))) {

            if (Auth::user()->status ==1) {
                Auth::logout();
                return redirect('/login')->with('msg', '该用户己被禁用.');
            } else {
                \App\Models\role\AdminUsers::find(Auth::id())->update(['last_login_time' => \Carbon\Carbon::now()]);
                return redirect()->intended('/home');
            }

        } else {
            return redirect()->intended('/login');
        }
    }


    /**
     * 重写用户验证记录
     * @param Request $request
     * @return bool
     */
    /*protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            ['email' => $request->get('email'), 'password' => $request->get('password'), 'status' => 0],
            $request->filled('remember')
        );
    }*/
}
