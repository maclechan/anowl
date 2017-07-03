<?php
namespace App\Models\Back;

/**
 * 管理后台用户模型
 * @Author  maclechan@qq.com
 * @date    2017/5/30
 */

use Validator;
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
    protected $fillable = ['name', 'email', 'password', 'nick_name', 'mobile', 'group_id', 'role_id', 'status'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /*字段检索*/
    protected $fields_search;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->fields_search = [
            'id'              => ['show' => '序号'],
            'name'            => ['show' => '登陆帐号', 'search' => "name like CONCAT('%', ?, '%')"],
            'nick_name'       => ['show' => '昵称', 'search' => "nick_name like CONCAT('%', ?, '%')"],//模糊匹配
            'email'           => ['show' => '邮箱'],
            'password'        => ['show' => '密码'],
            'group_id'        => ['show' => '所在部门'],
            'role_id'         => ['show' => '角色组'],
            'mobile'          => ['show' => '手机'],
            'created_at'      => ['show' => '创建时间','as'=>'created_at','algorithm'=>'>='],
            'updated_at'      => ['show' => '创建时间','as'=>'updated_at','algorithm'=>'<='],
            'status'          => ['show' => '账号状态'],
        ];
    }

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:admin_users|min:1',
            'password' => 'required|confirmed|min:6',
            'email' => 'required|email|unique:admin_users|min:1,max:80',
            'nick_name' => 'required|string|min:1,max:10',
            'group_id' => 'required',
            'role_id' => 'required',
            'status' => 'required|boolean',
            'mobile' => 'unique:admin_users|regex:/^1[345789][0-9]{9}$/',
        ];
    }

    /**
     * 自定义错误信息
     * @return array
     */
    public function ruleMsg()
    {
        return [
            'required' => ':attribute不能为空.',
            'name.unique' => '登陆帐号己存在.',
            'email.unique' => '该邮箱己被使用.',
            'mobile.unique' => '该手机号己被使用.'
        ];
    }

    /**
     * 字段映射中文
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => '登陆帐号',
            'email' => 'E-mail',
            'password' => '密码',
            'nick_name' => '姓名',
            'mobile' => '手机',
            'group_id' => '权限',
            'role_id' => '角色',
            'status' => '用户状态 (0:正常 1:禁用)',
        ];
    }

    /**
     * 表单数据校验
     * @param $post_data
     * @return bool
     */
    public function validator($post_data)
    {
        return Validator::make(
            $post_data,
            $this->rules(),
            $this->ruleMsg(),
            $this->attributeLabels()
        );
    }

    /**
     * 所属权限信息
     */
    public function hasGroup()
    {
        return $this->hasOne("App\Models\Back\AdminRole", 'id', 'group_id');
    }

    /**
     * 所属角色信息
     */
    public function hasRole()
    {
        return $this->hasOne("App\Models\Back\AdminRole", 'id', 'role_id');
    }

    /**
     * 用户信息检索
     * @param $input  表单输入数据
     * @param $request http请求
     * @return array
     */
    public function getUserList($input,$request)
    {
        $UserModel = $this->orderBy('id');
        foreach ($input as $field => $value) {

            if (empty($value) || $value<0 || !isset($this->fields_search[$field])){
                continue;
            }

            $search = $this->fields_search[$field]; //查询字段

            if(isset($search['search'])){
                $UserModel->whereRaw($search['search'], [$value]);
            }else{
                $algorithm = '=';
                if(isset($search['as'])){
                    $field     = $search['as'];
                    $algorithm = $search['algorithm'];
                }
                $UserModel->where("$field","$algorithm","$value");
            }
        }

        $paginate = $input['page_number']>0?$input['page_number']:\Config::get('system.page_limit');

        $list_data = $UserModel->paginate($paginate);
        return $list_data;
    }
}
