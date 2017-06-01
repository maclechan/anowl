<?php
/**
 *    +----------------------------------------------------------------------+
 *    | @date: 2016-11-18                                                   |
 *    +----------------------------------------------------------------------+
 *    | @Functions CommonFunc.php: 后台类                               |
 *    +----------------------------------------------------------------------+
 *    | @Author: 金佳诚 <422737839@qq.com>                                     |
 *    +----------------------------------------------------------------------+
 */

use JohnLui\AliyunOSS\AliyunOSS;



if(!function_exists('oss_upload_file'))
{
    /** OSS 上传图片文件
     * @param $file  Input::file('**')
     */
    function oss_upload_file($file)
    {
        if(empty($file)) $file='';
        if($file == '')
        {
            return '';
        }else
        {
            if($file->isValid()){

                $clientName = $file->getClientOriginalName();

                $tmpName = $file->getFileName();

                $realPath = $file->getRealPath();

                $extension = $file->getClientOriginalExtension();

                $mimeTye = $file->getMimeType();

                $newName = md5(date('ymdhis').$clientName).".".$extension;

                $path = $file->move('uploads',$newName); //这里是缓存文件夹，存放的是用户上传的原图，这里要返回原图地址给flash做裁切用

                $oss = AliyunOSS::boot(Config::get('UEditorUpload.core.oss.Server') , Config::get('UEditorUpload.core.oss.AccessKeyId'), Config::get('UEditorUpload.core.oss.AccessKeySecret'));
                $oss = $oss->setBucket( Config::get('UEditorUpload.core.oss.bucket'));
                $oss->uploadFile('ujiacitysrc/' . date("Ymd") . '/' . $newName ,public_path('uploads/' . $newName));
                @unlink (public_path('uploads/' . $newName));
                return  'ujiacitysrc/' . date("Ymd") . '/' . $newName;
            }
        }
    }
}


if(!function_exists('oss_del'))
{
    /** OSS 删除
     * @param $file   OSS的文件地址
     */
    function oss_del($file)
    {
        $oss = AliyunOSS::boot(Config::get('UEditorUpload.core.oss.Server') , Config::get('UEditorUpload.core.oss.AccessKeyId'), Config::get('UEditorUpload.core.oss.AccessKeySecret'));
        $oss = $oss->setBucket( Config::get('UEditorUpload.core.oss.bucket'));
        $oss->deleteObject( Config::get('UEditorUpload.core.oss.bucket'),$file);
        return  '';
    }
}

if(!function_exists('oss_get'))
{
    /** OSS 获取链接地址
     * @param $file   OSS的文件地址
     */
    function oss_get($file)
    {
        if(!empty($file))
        {
//Config::get('UEditorUpload.core.oss.Server'),
            $oss = AliyunOSS::boot(Config::get('UEditorUpload.core.oss.Server') , Config::get('UEditorUpload.core.oss.AccessKeyId'), Config::get('UEditorUpload.core.oss.AccessKeySecret'));
            $oss = $oss->setBucket( Config::get('UEditorUpload.core.oss.bucket'));
            $_data =   $oss->getUrl($file, new DateTime("+1 day"));
            return  $_data;
        }
    }
}


