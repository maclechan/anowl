<?php
namespace App\Models\Back;

/**
 * 管理后台用户模型
 * @Author  maclechan@qq.com
 * @date    2017/5/30
 */

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class AdminUsers extends Model implements AuthenticatableContract,
                                          AuthorizableContract,
                                          CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'admin_users';

    /**
     * 设置日期时间格式为Unix时间戳
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * The attributes that are mass assignable.
     * 允许通过表单批量赋值
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    public function rules()
    {
        return [
            'name' => 'required|string|min:1,max:60',
            'email' => 'required|string|min:1,max:80',
            'nick_name' => 'required|string|min:1,max:10',
            //        'mobile' => 'required|string',
            'status' => 'required|boolean',
        ];
    }

    public function ruleMsg()
    {
        return [
            'name.required' => '登录帐号不能为空',
            'email.required' => '邮箱不能为空',
            'nick_name.required' => '姓名不能为空',
            'status.required' => '状态不能为空',
            'mobile.required' => '手机号不能为空',
            'string' => '不是有效字符串.',
            'boolean' => '参数错误.',
            'min' => '小于.',
            'max' => '大于.',
        ];
    }
}
