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
                <!--search-->
                <div class="panel">
                    <div class="panel-heading">
                        <a class="btn btn-sm btn-primary btn-outline" href="/back/role/add"><i class="fa fa-plus"></i> 创建用户</a>
                    </div>

                    <form action="{{ url('/back/role/index') }}" method="post" class="form-horizontal" enctype="multipart/form-data">

                    <div class="panel-body p-l-none p-b-none">
                        <div class="col-md-2">
                            <label class="pull-left">
                                <select class="form-control select" name="page_number" id='page_number'>
                                    <option value="-1">每页展示数</option>
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
                                @foreach($groups as $v)
                                    <option value="{{ $v['id'] }}">{{ $v['role_name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1 p-r-none" id='hide_role_id'>
                            <select class="select form-control" id="role_id" name="role_id"></select>
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
                        @foreach ($pages as $value)
                        <tr>
                            <td>{{ $value->id }}</td>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->email }}</td>
                            <td>{{ $value->nick_name }}</td>
                            <td>{{ $value->mobile }}</td>
                            <td>{{ $value->hasGroup->role_name }}</td>
                            <td>{{ $value->hasRole->role_name }}</td>
                            <td>{!! $value->status?'<span class="badge badge-danger">己禁用</span>':'<span class="badge badge-primary">己启用</span>' !!}</td>
                            <td>{{ date('Y-m-d/H:i:s',$value->created_at) }}</td>
                            <td>
                                <a href="/back/role/edit/{{ $value->id }}" class="btn btn-primary btn-xs btn-rounded btn-outline">
                                    <i class="fa fa-pencil"></i> 编辑
                                </a>
                                <span onClick="deleteRole({{$value->id}})" class="btn btn-primary btn-xs btn-rounded btn-outline">
                                    <i class="fa fa-trash-o"></i> 删除
                                </span>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                    @include('back.page',['pages'=>$pages])

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
                data: {'id':id},
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
<script type="text/javascript">
    $('#group_id').change(function(){
        var group_id = $("#group_id").val();
        $("#role_id").empty();

        if(!group_id){
            $("#hide_role_id").hide();
            return false;
        }
        var parame = {
            url:"{{url('/back/role/add/')}}/"+group_id,
            type:'get',
            dataType:"json",
        };

        $.ajax(parame).done(function(data){
            $("#hide_role_id").show();
            for(var i=0; i<data.length;i++) {
                $("#role_id").append("<option value='"+data[i].id+"'>"+data[i].role_name+"</option>");
            }
            $('#role_id').selectpicker('refresh');
        });
    });
</script>
@endsection