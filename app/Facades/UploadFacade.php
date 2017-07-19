<?php
namespace App\Facades;

/**
 * 文件上传门面
 * @Author  maclechan@qq.com
 * @date    2017/7/19
 */

use Illuminate\Support\Facades\Facade;

class UploadFacade extends Facade
{
    protected static function getFacadeAccessor() { return 'UploadService'; }

}
