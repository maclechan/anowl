@section('title', '用户权限-用户列表')
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
                            <div class="alert alert-danger alert-dismissable">
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
                            <a class="btn btn-sm btn-primary btn-outline" href="/back/role/add">
                                <i class="fa fa-plus"></i> 创建用户
                            </a>
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
                                    <th>姓名</th>
                                    <th>手机</th>
                                    <th>部门</th>
                                    <th>角色</th>
                                    <th>帐号状态</th>
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
                                        <td>{{ $value->nick_name }}</td>
                                        <td>{{ $value->mobile }}</td>
                                        <td>{{ $value->group_id }}</td>
                                        <td>{{ $value->role_id }}</td>
                                        <td>{!! $value->status?'<span class="badge badge-danger">己禁用</span>':'<span class="badge badge-primary">己启用</span>' !!}</td>
                                        <td>{{ date('Y-m-d/H:i:s',$value->created_at) }}</td>
                                        <td>
                                    <span data-id="{{ $value->id }}"
                                          data-name="{{ $value->name }}"
                                          data-email="{{ $value->email }}"
                                          data-nick_name="{{ $value->nick_name }}"
                                          data-mobile="{{ $value->mobile }}"
                                          data-group_id="{{ $value->group_id }}"
                                          data-role_id="{{ $value->role_id }}"
                                          data-status="{{ $value->status }}"
                                          data-toggle="modal" data-target="#edit" class="btn btn-primary btn-xs btn-rounded btn-outline">
                                        <i class="fa fa-pencil"></i> 编辑
                                    </span>
                                    <span onClick="deleteRole({{$value->id}})" class="btn btn-primary btn-xs btn-rounded btn-outline">
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
                                            <button type="button" class="p-xxs btn btn-primary btn-xs btn-outline" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
    </div>

    <script>
        function deleteRole(id){
            var id = id;
            swal({
                title: "确定删除吗?",
                text: "此次操作不可逆!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#1ab394",
                confirmButtonText: "确定",
                cancelButtonText: "取消",
                closeOnConfirm: false
            }, function(){
                $.ajax({
                    type: 'POST',
                    url: '/back/role/del',
                    data: {'id':id, '_token':"<?=csrf_token()?>"},
                    dataType: "json",
                    success: function (data) {
                        swal("删除成功", data.msg, "success");
                        location.reload();
                    },
                    error: function (data) {
                        swal("删除失败", data.msg, "error");
                    }
                });
            });
        };
    </script>
@include('back.role.edit')
@endsection