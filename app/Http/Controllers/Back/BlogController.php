<?php
namespace App\Http\Controllers\Back;

/**
 * 博客管理
 * @Author  maclechan@qq.com
 * @date    2017-7-19
 */


class BlogController extends BaseController
{
    /**
     *
     * @return view
     */
    public function getIndex()
    {
        return view('back.blog.index');
    }

    /**
     * show blog view
     */
    public function getAdd()
    {
        return view('back.blog.add');
    }

}