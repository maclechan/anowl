<?php
/**
 * 后台共用函数
 * @Author  maclechan@qq.com
 * @date    2017/7/11
 */

/**
 * 后台菜单树结构
 */
if(!function_exists('modTree')){
    function modTree($list,$pid=0,$level=0,$html='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'){
        static $tree = array();
        foreach($list as $v){
            if($v['parent_id'] == $pid){
                $v['sort'] = $level;
                $v['html'] = str_repeat($html,$level);
                $tree[]    = $v;
                modTree($list,$v['nav_id'],$level+1);
            }
        }
        return $tree;
    }
}

