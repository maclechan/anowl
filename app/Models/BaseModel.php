<?php
namespace App\Models;

/**
 * 模型基类
 * @Author  maclechan@qq.com
 * @date    2017/6/1
 */

use Log;
use Validator;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    /**
     * 设置日期时间格式为Unix时间戳
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * 关闭自动管理时间戳
     * @var bool
     */
    //public $timestamps = false;
}