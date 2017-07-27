@section('title', '用户权限-用户列表')
@extends('back.layout')
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">

                    @include('back.message')

                            <!--search-->
                    <div class="panel">
                        <div class="panel-heading">
                            <a class="btn btn-sm btn-primary btn-outline" href="/back/blog/add"><i class="fa fa-plus"></i> 创建文章</a>
                        </div>

                        <form action="{{ url('/back/role/index') }}" method="post" class="form-horizontal" enctype="multipart/form-data">

                            <div class="panel-body p-l-none p-b-none">
                                <div class="col-md-2">
                                    <label class="pull-left">
                                        <select class="form-control select" name="page_number" id='page_number'>
                                            <option value="-1">每页条目数</option>
                                            <option value="10">每页10条</option>
                                            <option value="20">每页20条</option>
                                            <option value="50">每页50条</option>
                                            <option value="100">每页100条</option>
                                        </select>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="name" class="form-control" placeholder="登陆帐号">
                                </div>

                                <div class="col-md-1 p-r-none">
                                    <select class="select form-control" id="group_id" name="group_id">
                                        <option value="0">选择权限组</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <button class="btn btn-primary" type="submit">搜索</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--end search-->

                    <div class="ibox-content">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>登陆帐号</th>
                                <th>E-mail</th>
                                <th>姓名</th>
                                <th>手机</th>
                                <th>权限组</th>
                                <th>角色</th>
                                <th>帐号状态</th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>x</td>
                                    <td>x</td>
                                    <td>x</td>
                                    <td>x</td>
                                    <td>x</td>
                                    <td>x</td>
                                    <td>x</td>
                                    <td>x</td>
                                    <td>x</td>
                                    <td>
                                        <a href="/back/role/edit/" class="btn btn-primary btn-xs btn-rounded btn-outline">
                                            <i class="fa fa-pencil"></i> 编辑
                                        </a>
                                <span class="btn btn-primary btn-xs btn-rounded btn-outline">
                                    <i class="fa fa-trash-o"></i> 删除
                                </span>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                       {{-- @include('back.page',['pages'=>$pages])--}}

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection