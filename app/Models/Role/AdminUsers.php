<?php
namespace App\Models\Role;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Validator;

class AdminUsers extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin_users';

    //更改原始存储时间戳的字段
    //const UPDATED_AT = 'last_login_time';

    //不通过表单，可直接填充 可以批量赋值的属性
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'nick_name', 'group_id', 'role_id', 'mobile', 'status', 'last_login_time'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    //字段检索
    protected $fields_search;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->fields_search = [
            'id'              => ['show' => '序号'],
            'name'            => ['show' => '英文', 'search' => "name like CONCAT('%', ?, '%')"],
            'nick_name'       => ['show' => '昵称', 'search' => "nick_name like CONCAT('%', ?, '%')"],
            'email'           => ['show' => '邮箱', 'search' => "email like CONCAT('%', ?, '%')"],
            'password'        => ['show' => '密码'],
            'group_id'        => ['show' => '权限'],
            'role_id'         => ['show' => '角色'],
            'mobile'          => ['show' => '手机'],
            'created_at'      => ['show' => '创建时间','as'=>'created_at','algorithm'=>'>='],
            'updated_at'      => ['show' => '更新时间','as'=>'updated_at','algorithm'=>'<='],
            'status'          => ['show' => '状态'],
        ];
    }

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:1',
            'password' => 'required|confirmed|min:6',
            'email' => 'required|email|unique:admin_users|min:1,max:120',
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
            'name' => '英文名称',
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
     * 创建用户
     * @param  array  $data
     * @return User
     */
    public function creates(array $data)
    {
        return AdminUsers::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => \Hash::make($data['password']),
                'nick_name' => $data['nick_name'],
                'avatar' => '/img/avatar/'.rand(1,20).'.png',
                'mobile' => $data['mobile'],
                'group_id' => $data['group_id'],
                'role_id' => $data['role_id'],
                'status' => $data['status'],
            ]
        );
    }

    /**
     * 所属权限信息
     */
    public function hasGroup()
    {
        return $this->hasOne("App\Models\Role\Roles", 'id', 'group_id');
    }

    /**
     * 所属角色信息
     */
    public function hasRole()
    {
        return $this->hasOne("App\Models\Role\Roles", 'id', 'role_id');
    }

    /**
     * 用户信息检索
     * @param $input  表单输入数据
     * @param $request http请求
     * @return array
     */
    public function getUsers($input, $request)
    {
        $users = $this->orderBy('id');

        foreach ($input as $field => $value) {

            if (empty($value) || $value<0 || !isset($this->fields_search[$field])){
                continue;
            }

            $search = $this->fields_search[$field]; //查询字段

            if (isset($search['search'])) {
                $users->whereRaw($search['search'], [$value]);
            } else {
                $algorithm = '=';
                if(isset($search['as'])){
                    $field     = $search['as'];
                    $algorithm = $search['algorithm'];
                }
                $users->where("$field","$algorithm","$value");
            }
        }

        $paginate  = $input['page_number']>0 ? $input['page_number'] : \Config::get('system.page_limit');
        $list_data = $users->paginate($paginate);

        return $list_data;
    }

}
