<?php
namespace App\Http\Controllers\Back;

/**
 * 后台登陆处理
 * @Author  maclechan@qq.com
 * @date    2017-5-30
 */

use Validator,Auth;
use Illuminate\Http\Request;
use App\Models\Back\AdminUsers;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;


class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller 所有的逻辑,在use AuthenticatesAndRegistersUsers 这个trait里面
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    //登陆成功后将自动跳转的页面
    protected $redirectPath = '/back';

    // 登录认证失败后，将会跳转到/auth/login链接
    protected $loginPath = '/back/login';

    //指定用户名登陆
    protected $username = 'name';

    //设置退出登录后转向的页面：
    protected $redirectAfterLogout = '/back/login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * 新用户的验证规则
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admin_users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return AdminUsers::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            ]
        );
    }

    public function getLogin()
    {
        if (view()->exists('auth.authenticate')) {
            return view('auth.authenticate');
        }

        return view('back.auth.login');
    }

    public function postLogin(Request $request)
    {

        $this->validate($request,
                        [$this->loginUsername() => 'required', 'password' => 'required'],
                        ['name.unique' => '登陆帐号不能为空.', 'password.unique' => '登陆密码不能为空.'],
                        ['name'=>'登陆帐号','password'=>'登陆密码']
        );

        $throttles = $this->isUsingThrottlesLoginsTrait();

        //用户登陆次数控制
        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        //获得登陆表单信息
        $credentials = $this->getCredentials($request);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            if(Auth::user()->status == 1){
                Auth::logout();
                return redirect('/back/login')->with('msg', '该用户己被禁用.');
            }else{
                return $this->handleUserWasAuthenticated($request, $throttles);
            }
        }

        //记录登陆失败次数
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }

}
