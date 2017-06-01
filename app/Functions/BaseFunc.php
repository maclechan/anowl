<?php

/**
 *    +----------------------------------------------------------------------+
 *    | @date: 2015-08-15                                                    |
 *    +----------------------------------------------------------------------+
 *    | @Functions BaseFunc.php: 自定义函数库文件                               |
 *    +----------------------------------------------------------------------+
 *    | @Author: chan <maclechan@qq.com>                                     |
 *    +----------------------------------------------------------------------+
 */


/**
 * 引入函数库文件
 * @param $func_name    函数名
 * @param string $ext   扩展名
 * @param string $pasth 文件路径
 */

if(!function_exists('format_money'))
{
    function format_money($money){

        return sprintf("%.2f", $money * 0.01);
    }
}

if(!function_exists('load_func'))
{
    function load_func($func_name, $ext = '.func.php', $pasth = '')
    {
        if(strpos($func_name, ','))
        {
            $funcs = explode(',', $func_name);
            foreach($funcs as $func_name)
            {
                $realpath = $pasth == '' ? app_path() . '/Functions/' . $func_name . $ext : $pasth . $func_name . $ext;
                require_once($realpath);
            }
        }
        else
        {
            $realpath = $pasth == '' ? app_path() . '/Functions/' . $func_name . $ext : $pasth . $func_name . $ext;
            require_once($realpath);
        }
    }
}

/* 获取控制器名 */
if(!function_exists('get_controller_name'))
{
    function get_controller_name()
    {
        $action_array     = action_obj();
        $controller_array = explode('\\', $action_array[0]);
        $controller_name  = end($controller_array);
        return $controller_name;
    }
}

if(!function_exists('action_obj'))
{
    function action_obj()
    {
        $route                 = app('Illuminate\Routing\Route');
        $action_array          = explode('@',$route->getActionName());
        $parameters            = $route->parameters();
        if($action_array[1] == 'missingMethod') $action_array[1] = explode ('/', $parameters['_missing'])[0];
        return $action_array;
    }
}

/*获取方法名*/
if(!function_exists('get_action_name'))
{
    function get_action_name()
    {
        $action_array = action_obj();
        $action_name  = strtolower($action_array[1]);
        $end = 0;
        if(strpos($action_name, 'post') === 0) $end = 4;
        if(strpos($action_name, 'get') === 0) $end = 3;
        if($end){
            $action_name = substr($action_name,$end,strlen($action_name));
        }
        return $action_name;
    }
}

if(!function_exists('get_in'))
{
    function get_in()
    {
        $in     = get_controller_in_name();
        $pre    = get_controller_pre_name();
        $action = get_action_name();
        return "$in/$pre/$action";
    }
}

if(!function_exists('get_path_name'))
{
    function get_path_name()
    {
        $route                 = app('Illuminate\Routing\Route');
        $action_array          = explode('@',$route->getActionName());
        $parameters            = $route->parameters();

        if($action_array[1] == 'missingMethod') $action_array[1] = explode ('/', $parameters['_missing'])[0];

        $controller_array      = explode('\\', $action_array[0]);
        $key = count($controller_array)-2;
        $path_name = strtolower($controller_array[$key]);
        return $path_name;
    }
}

/* 获取控制器小写名称 */
if(!function_exists('get_controller_tolower_name'))
{
    function get_controller_tolower_name()
    {
        $controller_name = strtolower(get_controller_name());
        return $controller_name;
    }
}

/* 获取控制器小写前缀名称 goodsController=goods */
if(!function_exists('get_controller_pre_name'))
{
    function get_controller_pre_name()
    {
        $controller_name = get_controller_tolower_name();
        $space_name      = preg_replace('/controller/','',$controller_name);
        return $space_name;
    }
}

/* 获取内部路径名称 */
if(!function_exists('get_controller_in_name'))
{
    function get_controller_in_name()
    {
        $action_array     = action_obj();
        $controller_array = explode('\\', $action_array[0]);
        $key              = count($controller_array)-2;
        $in_name          = $controller_array[$key];
        return strtolower($in_name);
    }
}

if(!function_exists('config')){
    function config($key)
    {
        $Config = app('Illuminate\Support\Facades\Config');
        return $Config::get($key);
    }
}

////////////
// order ///
////////////
if(!function_exists('create_return_sn')){
    function create_return_sn()
    {
        return \Config::get('order.return_sn_prefix').date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }
}


////////////
// cache ///
////////////
if(!function_exists('set_cache')){
    function set_cache($key,$data,$expires=NULL)
    {
        $Cache = app('Illuminate\Support\Facades\Cache');
        return $Cache::put($key, $data, $expires);
    }
}

if(!function_exists('get_cache')){
    function get_cache($key)
    {
        $Cache = app('Illuminate\Support\Facades\Cache');
        return $Cache::get($key);
    }
}


if(!function_exists('db_start')){
    function db_start(){
        \DB::connection()->enableQueryLog();
    }
}

if(!function_exists('get_session')){
    function get_session($session_key){
        return \Session::get($session_key);
    }
}

if (!function_exists('set_session')) {
    function set_session($session_key, $session_value)
    {
        \Session::put($session_key, $session_value);
        \Session::save();
    }
}

if(!function_exists('del_session')){
    function del_session($session_key){
        \Session::forget($session_key);
        \Session::save();
    }
}

if(!function_exists('db_end')){
    function db_end(){
        \DB::connection()->enableQueryLog();
        var_dump(\DB::getQueryLog());
    }
}


if(!function_exists('create_order_sn'))
{
    function create_order_sn()
    {
        $OrderSnService  = new \App\Services\OrderSnService();
        return $OrderSnService->get32BitUniqid(\Config::get('order.order_sn_prefix'));
    }
}

if(!function_exists('create_qrcode_sn'))
{
    function create_qrcode_sn($length=10)
    {
        $OrderSnService  = new \App\Services\OrderSnService();
        return $OrderSnService->getUniqid($length);
    }
}

if(!function_exists('guid'))
{
    function guid(){
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }else{
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = chr(123)// "{"
                .substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12)
                .chr(125);// "}"
            return $uuid;
        }
    }
}




if(!function_exists('create_wechat_order_sn'))
{
    function create_wechat_order_sn()
    {
        $OrderSnService  = new \App\Services\OrderSnService();
        return $OrderSnService->get32BitUniqid('W');
    }
}

if(!function_exists('event_name')){
    function event_name($event){
        return get_class($event);
    }
}

if(!function_exists('msm_code')){
    function msm_code($length = 6) {
        $min = pow(10 , ($length - 1));
        $max = pow(10, $length) - 1;
        return rand($min, $max);
    }
}

function curl_get($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $r = curl_exec($ch);
    $httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
    curl_close($ch);
    if($httpCode == 200){
        return $r;
    }else{
        return null;
    }
}


function curl_post($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);      //跟踪301
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        //返回结果
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
    if($httpCode == 200){
        return $result;
    }else{
        return '';
    }
}

if (!function_exists('http_post')) {
    function http_post($url, $post)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $url);//url
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_POST, true);  //post
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
}


function curl_download($from_url,$file_name,$type = 'curl'){
    if($type == 'curl'){
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$from_url);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,10);
        $img=curl_exec($ch);
        curl_close($ch);

        //$size=strlen($img);
        //文件大小
        $fp=@fopen($file_name,'w');
        fwrite($fp,$img);
        fclose($fp);
    }elseif($type == 'file'){
        $img = file_get_contents($file_name);
        file_put_contents($file_name,$img);
    }
}

function set_dir($url,$root_name='root'){
    $url = trim($url,'/');
    $urlArray = explode('/',$url);
    $tempUrl = '';
    foreach($urlArray as $urlCell){
        $tempUrl .= '/'.$urlCell;
        $tempUrl = ltrim($tempUrl,'/');
        if(!file_exists($tempUrl)){
            mkdir($tempUrl,0777);
            chmod($tempUrl,0777);
        }
    }

}

function set_dir_new($path){
    if(!is_dir($path)){
        mkdir($path,0777,true);
        chmod($path,0777);
    }
}


if(!function_exists('create_img_name')){
    function create_img_name($entension){
        $allchar = "abcdefghijklnmopqrstuvwxyz1234567890" ;
        $name = date("YmdHi");
        for ( $i = 0; $i<3 ; $i++ ){
            $name .= substr( $allchar, mt_rand (0,25), 1 ) ;
        }
        return $name.'.'.$entension;
    }
}

if(!function_exists('set_img_path')){
    function set_img_path($config_path){
        //图片上传数据初始化
        $img_date = date("Ym", time());
        $img_day = date("d", time());
        $img_dir = $config_path.$img_date.'/'.$img_day.'/';
        set_dir_new($img_dir);
        return $img_dir;
    }

}

if(!function_exists('upload_img')) {
    function upload_img($img_file, $img_dir)
    {
        if ($img_file->isValid()) {
            $entension = $img_file->getClientOriginalExtension();
            $img_name = create_img_name($entension);
            $img_size = $img_file->getClientSize();
            $img_file->move($img_dir, $img_name);

            return array(
                'img' => ltrim($img_dir,'/').$img_name,
                'img_name' => $img_name,
                'entension' => $entension,
                'img_size' => $img_size
            );
        }
        return array();
    }
}

if(!function_exists('get_img_url')) {
    function get_img_url($img_name)
    {
        $mark = strpos($img_name,'http://');
        if($mark || $mark === 0){
            return $img_name;
        }

        $img_url = rtrim(config('system.src_url'),'/');
        $img_name = ltrim($img_name,'/');
        $result = $img_url.'/'.$img_name;
        return $result;
    }
}

if(!function_exists('get_base_url')) {
    function get_base_url($url)
    {
        $mark = strpos($url,'http://');
        if($mark || $mark === 0){
            return $url;
        }

        $base_url = rtrim(config('system.base_url'),'/');
        $url = ltrim($url,'/');
        $result = $base_url.'/'.$url;
        return $result;
    }
}


if(!function_exists('create_file_name')){
    function create_file_name($entension){
        $allchar = "abcdefghijklnmopqrstuvwxyz1234567890" ;
        $name = date("YmdHi");
        for ( $i = 0; $i<3 ; $i++ ){
            $name .= substr( $allchar, mt_rand (0,25), 1 ) ;
        }
        return $name.'.'.$entension;
    }
}

if(!function_exists('set_file_path')){
    function set_file_path($config_path){
        //图片上传数据初始化
        $date = date("Ym", time());
        $day = date("d", time());
        $dir = $config_path.$date.'/'.$day.'/';
        set_dir_new($dir);
        return $dir;
    }

}

if(!function_exists('upload_file')) {
    function upload_file($file, $dir)
    {
        if ($file->isValid()) {
            $entension = $file->getClientOriginalExtension();
            $name = create_file_name($entension);
            $file->move($dir, $name);

            return array(
                'file' => ltrim($dir,'/').$name,
                'file_name' => $name,
                'entension' => $entension,
            );
        }
        return array();
    }
}

//生成微信支付时发送给微信的商户订单号
if(!function_exists('get_trade_no')) {
    function get_trade_no()
    {
        return md5(uniqid(md5(microtime(true)),true));
    }
}
