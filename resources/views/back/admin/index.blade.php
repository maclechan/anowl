@section('title', '用户权限 - 用户列表')
@extends('back.layout')
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    @if (session('msg'))
                        <div class="col-lg-3">
                            <div class="alert alert-success alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                {{ session('msg') }}
                            </div>
                        </div>
                    @endif
                    @if (count($errors) > 0)
                        <div class="col-lg-3">
                            <div class="alert alert-success alert-dismissable">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-sm-9 m-b-xs">
                            <ul>
                            <span data-toggle="modal" data-target="#addmenu" data-toggle="tooltip" data-placement="top" title="添加菜单权限" class="btn btn-sm btn-primary">
                                <i class="fa fa-plus"></i> 添加菜单权限
                            </span>
                            </ul>
                        </div>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input type="text" class="input-sm form-control" placeholder="Search">
                                <span class="input-group-btn"><button class="btn btn-sm btn-primary" type="button"> <b>搜索</b></button> </span>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>登陆帐号</th>
                                <th>E-mail</th>
                                <th>昵称</th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($pages as $value)
                                <tr>
                                    <td>
                                         {{ $value->id }}
                                    </td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->email }}</td>
                                    <td>{{ $value->nike_name }}</td>
                                    <td>{{ date('Y-m-d',$value->created_at) }}</td>
                                    <td>
                                    <span
                                          data data-toggle="modal" data-target="#editmenu" data-toggle="tooltip" class="btn btn-primary btn-xs">
                                        <i class="fa fa-pencil"></i> 编辑
                                    </span>
                                    <span onClick="deleteNav({{$value->id}})" class="btn btn-primary btn-xs">
                                        <i class="fa fa-trash-o"></i> 删除
                                    </span>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>

                        <div class="text-right">
                            <div class="mail-body text-right">
                                <ul class="pagination row">
                                    <li class="footable-page-arrow"><a data-page="first" href="{!! $pages->url(1) !!} #first">首页</a></li>
                                    <li class="footable-page-arrow"><a data-page="prev" href="{!! $pages->previousPageUrl() !!} #prev">上一页</a></li>

                                    <li class="footable-page active"><a data-page="0" href="#">第{!! $pages->currentPage() !!}页</a></li>

                                    <li class="footable-page-arrow"><a data-page="next" href="{!! $pages->nextPageUrl() !!} #next">下一页</a></li>
                                    <li class="footable-page-arrow"><a data-page="last" href="{!! $pages->url($pages->lastPage()) !!} #last">末页</a></li>
                                </ul>

                                <div class="pull-right pagination">
                                    <!-- Small button group -->
                                    <div class="btn-group m-l-xs m-r-xs">
                                        <button type="button" class="p-xxs btn btn-primary btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            跳转页 <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            @for($i=1; $i<=ceil($pages->total()/$pages->perPage()); $i++)
                                                <li><a href="{!! $pages->url($i) !!}">第{!! $i !!}页</a></li>
                                            @endfor
                                        </ul>
                                    </div>
                                    <!-- Small button group -->

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection