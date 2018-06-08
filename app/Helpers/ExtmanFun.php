<?php
/**
 *    +----------------------------------------------------------------------+
 *    | @date: 2015-08-15                                                    |
 *    +----------------------------------------------------------------------+
 *    | @Functions ExtmanFun.php: 自定义函数库文件                               |
 *    +----------------------------------------------------------------------+
 *    | @Author: chan <maclechan@qq.com>                                     |
 *    +----------------------------------------------------------------------+
 */

/**
 * 获取控制器名
 * @return  HomeController
 */
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
        if($action_array[1] == 'missingMethod') {
            $action_array[1] = explode ('/', $parameters['_missing'])[0];
        }
        return $action_array;
    }
}

/**
 * 获取全小写方法名
 * @return  addgroup
 */
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

/**
 * 获得当前uri路径
 * home/addGroup
 */
if(!function_exists('get_in'))
{
    function get_in()
    {
        /*
         *  laravel5.1
            $in     = get_controller_in_name();
            $pre    = get_controller_pre_name();
            $action = get_action_name();
            return "$in/$pre/$action";
        */

        $route = \Route::current();
        return $route->uri;
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
