<?php

/**
 * CODE
 * @param $func_name    函数名
 * @param string $ext   扩展名
 * @param string $pasth config
 */
if(!function_exists('CODE'))
{
    function CODE($key)
    {
        $code = \Config::get("code.$key");
        return $code;
    }
}

if(!function_exists('adminMsg'))
{
    function adminMsg($code,$msg,$data=[],$action=''){
        die(view('back.message',[
            'code'  => $code,
            'msg'   => $msg,
            'data'  => $data,
            'action'=> $action
        ]));
    }
}

if (!function_exists('get_debug_app')) {
    function get_debug_app(){
        $debug_app = config('system.debug_app');
        return $debug_app;
    }
}

if(!function_exists('adminAjaxData')){
    function adminAjaxData($sEcho,$iTotalRecords,$iTotalDisplayRecords,$aaData){
        die(json_encode([
            'sEcho'                => $sEcho,
            'iTotalRecords'        => $iTotalRecords,
            'iTotalDisplayRecords' => $iTotalDisplayRecords,
            'aaData'               => $aaData
        ]));
    }
}


/*
* 头像上传
*/
if(!function_exists('upLoadAvatar')){
   function upLoadAvatar($avatar_obj,$file_path){
       $file = $avatar_obj;
       if($file->isValid()){
           $client_name = $file->getClientOriginalName();
           $extension  = $file->getClientOriginalExtension();
           if(!$file_path){
               $file_path = \Config::get('system.avatar_path');
           }
           if(!file_exists($file_path)) mkdir($file_path,0777,true);
           $new_name    = md5(date('ymdhis').$client_name).".".$extension;
           $path       = $file->move($file_path,$new_name);
           if($path) return [$new_name,$file_path];
       }
       return [false,false];
   }
}

/*
二维数组
*/
if(!function_exists('excel_download')){
    function excel_download($table_name,$data){
        $excel = new \App\Services\ExcelService();
        $excel->download($table_name, $data);
    }
}

if(!function_exists('upLoadGoods')){
   function upLoadGoods($avatar_obj,$is_thump,$src_img,$width,$height,$dest_img){

       $file = $avatar_obj;

       if($file->isValid()){
           $client_name = $file->getClientOriginalName();
           $extension  = $file->getClientOriginalExtension();
           $file_path  = \Config::get('system.img_goods_path').date('Y-m-d');
           if(!file_exists($file_path)) set_dir_new($file_path,0777,true);
           $new_name    = md5(time().$client_name).".".$extension;
           $path        = $file->move($file_path,$new_name);
           if($is_thump){
               $stc_img  = $file_path.'/'.$new_name;
               chmod($path, 0777);
               $dest_img = \Config::get('system.img_goods_thump_path').date('Y-m-d');
               if(!file_exists($dest_img)){
                   set_dir_new($dest_img,0777,true);
               }

               $imgService = new \App\Services\ImgService();

               $thump_img  = $imgService->thump(base_path()."/public/".$stc_img,650,650,base_path()."/public/".$dest_img);
           }
           if($path) return [
               $new_name,
               $file_path,
               $thump_img,
               $dest_img
           ];
       }
       return [false,false];
   }
}


/*
 * 拼接头像URL
 */
if(!function_exists('avatarUrl')){
   function avatarUrl($config_key,$path='',$file_name=''){
       return \Config::get($config_key).$path.'/'.$file_name;
   }
}


/**
 * Mod Data Tree
 */
if(!function_exists('modTree')){
    function modTree($list,$pid=0,$level=0,$html='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'){
     static $tree = array();
     foreach($list as $v){
         if($v['parent_id'] == $pid){
             $v['sort'] = $level;
             $v['html'] = str_repeat($html,$level);
             $tree[]    = $v;
             modTree($list,$v['mod_id'],$level+1);
         }
     }
     return $tree;
 }
}

if(!function_exists('classTree')){
    function classTree($list,$pid=0,$level=0,$html='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'){
        static $tree = array();
        foreach($list as $v){
            if($v['class_parent_id'] == $pid){
                $v['sort'] = $level;
                $v['html'] = str_repeat($html,$level);
                $tree[]    = $v;
                classTree($list,$v['class_id'],$level+1);
            }
        }
        return $tree;
    }
}

if(!function_exists('articleTree')){
    function articleTree($list,$pid=0,$level=0,$html='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'){
        static $tree = array();
        foreach($list as $v){
            if($v['class_parent_id'] == $pid){
                $v['html'] = str_repeat($html,$level);
                $tree[]    = $v;
                articleTree($list,$v['class_id'],$level+1);
            }
        }
        return $tree;
    }
}

if(!function_exists('getClientIp')){
        function getClientIp(){
            $unknown = 'unknown';
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown)){
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown)) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            /*
        处理多层代理的情况
        或者使用正则方式：$ip = preg_match("/[\d\.]{7,15}/", $ip, $matches) ? $matches[0] : $unknown;
        */
            if (false !== strpos($ip, ',')) $ip = reset(explode(',', $ip));
            return $ip;
        }

}
if(!function_exists('sku')){
    function sku($data) {
        $result = array();
        foreach (array_shift($data) as $k=>$item) {
            $result[] = array($k=>$item);
        }
        foreach ($data as $k => $v) {
            $result2 = [];
            foreach ($result as $k1=>$item1) {
                foreach ($v as $k2=>$item2) {
                    $temp     = $item1;
                    $temp[$k2]   = $item2;
                    $result2[] = $temp;
                }
            }
            $result = $result2;
        }
        return $result;
    }
}
if(!function_exists('getSkuJoinId')){
    function getSkuJoinId($sku_data){
        foreach($sku_data as $key => $value){
            $join_data = [];
            foreach($value as $k => $v){
                $join_data[] = $k;
            }
            $join_key[] = join('_',$join_data);
        }
        return $join_key;
    }

}

if (!function_exists('array_sorts')) {
    function array_sorts($arr, $keys, $orderby = 'asc')
    {
        $keysvalue = $new_array = array();
        foreach ($arr as $k => $v) {
            $keysvalue[$k] = $v[$keys];
        }
        if ($orderby == 'asc') {
            asort($keysvalue);
        } else {
            arsort($keysvalue);
        }
        reset($keysvalue);
        foreach ($keysvalue as $k => $v) {
            $new_array[] = $arr[$k];
        }
        return $new_array;
    }
}

if(!function_exists('getDiscountPrice')) {

    /**
     * 计算折扣价
     * @param $goodsAmount  折扣前价格
     * @param $discount  折扣值
     * @param string $type 取值类型：up-向上取，down-向下取，round-四舍五入，none-不进位
     * @param int $stayPoint 保留小数点的位数
     * @return float
     */
    function getDiscountPrice($goodsAmount, $discount, $type = 'round', $stayPoint = 2)
    {
        $discountPrice = $goodsAmount * $discount * 0.01;
        $fillZero = str_repeat(0, $stayPoint);

        switch ($type) {
            case 'round':
                $discountPrice = round($discountPrice, $stayPoint);
                break;
            case 'up':
                $tempNum = pow(10, $stayPoint);
                $discountPrice = $discountPrice * $tempNum;
                $discountPrice = ceil($discountPrice);
                $discountPrice = $discountPrice / $tempNum;
                break;
            case 'down':
                $tempNum = pow(10, $stayPoint);
                $discountPrice = $discountPrice * $tempNum;
                $discountPrice = floor($discountPrice);
                $discountPrice = $discountPrice / $tempNum;
                break;
            case 'none':
                break;
        }
        $pointPlace = strpos($discountPrice, '.');
        if ($stayPoint > 0) {
            if ($pointPlace > 0) {
                $discountPrice .= $fillZero;

            } else {
                $discountPrice .= '.' . $fillZero;
                $pointPlace = strpos($discountPrice, '.');
            }
            $cutPlace = $pointPlace + $stayPoint + 1;
            $discountPrice = substr($discountPrice, 0, $cutPlace);
        } else {
            if ($pointPlace > 0) {
                $discountPrice = substr($discountPrice, 0, $pointPlace);
            }
        }
        return $discountPrice;
    }
}

if(!function_exists('set_visit_store')) {
    function set_visit_store($visit_store_id)
    {
        $user_info  = get_session('user_info');
        $visit_store_info = \App\Models\Stores\StoresModel::find($visit_store_id);
        if(!empty($visit_store_info)){
            $visit_store_info = $visit_store_info->toArray();
        }
        if (!empty($visit_store_info)) {
            /*$order_count = \App\Models\Order\OrderInfoModel::
                where(
                    array(
                        'store_id' => $visit_store_id,
                        'user_id' => $user_info['user_id'],
                    )
                )->count();*/

            //if($order_count > 0){
            \App\Models\Users\UsersModel::where(array('user_id' => $user_info['user_id']))->update(array('stores_id' => $visit_store_id));
            $user_info['stores_id'] = $visit_store_id;
            //}

            $user_info['is_reset_store'] = 1;
            set_session('user_info', $user_info);
            set_session('user_store_info', $visit_store_info);
        }
    }
}

/* 根据商品数量计算运费 */
if (!function_exists('get_shipping_price')) {
    function get_shipping_price(){
        $parame             = func_get_args();
        $packages_number_in = $parame[0];
        $packages_fee       = $parame[1];
        $packages_add       = $parame[2];
        $fee_add            = $parame[3];
        $goods_number       = $parame[4];
        $shipping_price     = 0;
        if($goods_number <= $packages_number_in){
            $shipping_price = $packages_fee;
        }

        if($goods_number > $packages_number_in){
            $goods_number -= $packages_number_in;
            $shipping_price+=$packages_fee;
            $packages_number = ceil($goods_number/$packages_add);
            $shipping_price += $packages_number * $fee_add;
        }

        return $shipping_price;

    }
}
if (!function_exists('open_wechat_payment')) {
    function open_wechat_payment($body,$total_fee,$openid,$notify_url,$attach=''){
        \Wechat::setConfig([
            'appId' => \Config::get('wechat.appId'),
            'secret' => \Config::get('wechat.secret'),
            'token' => \Config::get('wechat.token'),
            'encodingAESKey' => \Config::get('wechat.encodingAESKey')
        ]);
        $wechat_config = \Wechat::orderConfig($body,$total_fee,$openid,$notify_url,$attach);
        return $wechat_config->getConfig();
    }
}

if (!function_exists('open_wechat_refund')) {
    function open_wechat_refund($total_fee,$refund_fee,$out_trade_no,$out_refund_no){
        \Wechat::setConfig([
            'appId' => \Config::get('wechat.appId'),
            'secret' => \Config::get('wechat.secret'),
            'token' => \Config::get('wechat.token'),
            'encodingAESKey' => \Config::get('wechat.encodingAESKey')
        ]);
        return \Wechat::refundConfig($total_fee,$refund_fee,$out_trade_no,$out_refund_no);
    }
}

if(!function_exists('arrTree')){
    function arrTree($tree, $pid = 0){
        $arr = array();
        foreach($tree as $v){
            if($v['parent_id'] == $pid){
                $arr[]=$v;
                $arr = array_merge($arr, arrTree($tree,$v['mod_id']));
            }
        }

        return $arr;
    }
}

if (!function_exists('length_limit')) {
    function length_limit($str, $limit, $first_limit, $sec_limit)
    {
        $len = mb_strlen($str, 'utf-8');
        if ($len <= $limit) {
            echo $str;
        } elseif ($len <= 2 * $limit) {
            $first_line = mb_substr($str, 0, $limit, 'utf-8');
            //echo $first_line . '<br />';
            echo $first_line;
            $sec_line = mb_substr($str, $limit, $first_limit, 'utf-8');
            echo $sec_line;
        } else {
            $first_line = mb_substr($str, 0, $limit, 'utf-8');
            //echo $first_line . '<br />';
            echo $first_line;
            $sec_line = mb_substr($str, $limit, $sec_limit, 'utf-8') . "...";
            echo $sec_line;
        }
    }
}


if (!function_exists('dump')) {
    function dump($data,$stop){
        echo '<pre>';
        var_dump($data);
        if($stop)
        {
            exit;
        }
    }
}

if (!function_exists('get_debug_fee')) {
    function get_debug_fee(){
        $debug_pay = config('system.debug_pay');
        if($debug_pay['is_debug']){
            return $debug_pay['debug_fee']+0;
        }else{
            return 0;
        }
    }
}
if (!function_exists('get_unique_str')) {
    function get_unique_str(){
        $OrderSnService  = new \App\Services\OrderSnService();
        return $OrderSnService->get32BitUniqid();
        //return strtoupper(md5(uniqid(md5(microtime(true)),true)));
    }
}

if (!function_exists('open_wechat_query_order')) {
    function open_wechat_query_order($transaction_id){
        \Wechat::setConfig([
            'appId' => \Config::get('wechat.appId'),
            'secret' => \Config::get('wechat.secret'),
            'token' => \Config::get('wechat.token'),
            'encodingAESKey' => \Config::get('wechat.encodingAESKey')
        ]);
        return \Wechat::queryOrderConfig($transaction_id);
    }
}

if (!function_exists('open_wechat_co_pay')) {
    function open_wechat_co_pay($partner_trade_no,$amount,$open_id,$real_user_name,$spbill_create_ip){
        \Wechat::setConfig([
            'appId' => \Config::get('wechat.appId'),
            'secret' => \Config::get('wechat.secret'),
            'token' => \Config::get('wechat.token'),
            'encodingAESKey' => \Config::get('wechat.encodingAESKey')
        ]);
        return \Wechat::coPayConfig($partner_trade_no,$amount,$open_id,$real_user_name,$spbill_create_ip);
    }
}


if (!function_exists('open_wechat_query_refund')) {
    function open_wechat_query_refund($query_type,$value){
        \Wechat::setConfig([
            'appId' => \Config::get('wechat.appId'),
            'secret' => \Config::get('wechat.secret'),
            'token' => \Config::get('wechat.token'),
            'encodingAESKey' => \Config::get('wechat.encodingAESKey')
        ]);
        return \Wechat::queryRefundConfig($query_type,$value);
    }
}

if (!function_exists('open_wechat_query_co_pay')) {
    function open_wechat_query_co_pay($partner_trade_no){
        \Wechat::setConfig([
            'appId' => \Config::get('wechat.appId'),
            'secret' => \Config::get('wechat.secret'),
            'token' => \Config::get('wechat.token'),
            'encodingAESKey' => \Config::get('wechat.encodingAESKey')
        ]);
        return \Wechat::queryCoPayConfig($partner_trade_no);
    }
}

if(!function_exists('upLoadTopic')){
    function upLoadTopic($avatar_obj){
        $file = $avatar_obj;
        if($file->isValid()){
            $client_name = $file->getClientOriginalName();
            $extension   = $file->getClientOriginalExtension();
            $file_path   = \Config::get('system.img_topic_path').date('Y-m-d');
            if(!file_exists($file_path)) set_dir_new($file_path,0777,true);
            $new_name    = md5(date('Y-m-d-H:i:s').$client_name).".".$extension;
            $path        = $file->move($file_path,$new_name);
            if($path) return [
                $new_name,
                $file_path
            ];
        }
        return [];
    }
}

