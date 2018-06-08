@section('title', '用户列表')
@extends('extman.layout')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">

                @include('extman.message')

                <!--search-->
                <div class="panel">
                    <div class="panel-heading">
                        <a class="btn btn-sm btn-primary btn-outline" href="/role/add"><i class="fa fa-plus"></i> 创建用户</a>
                    </div>

                    <form action="{{ url('/role/index') }}" method="post" class="form-horizontal" enctype="multipart/form-data">

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
                            <input type="text" name="email" class="form-control" placeholder="登陆帐号">
                        </div>

                        <div class="col-md-1 p-r-none">
                            <select class="select form-control" id="group_id" name="group_id">
                                <option value="0">选择权限组</option>
                                @foreach($groups as $v)
                                    <option value="{{ $v['id'] }}">{{ $v['role_name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1 p-r-none" id='hide_role_id' style=" display: none;">
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
                    <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <th>图像</th>
                            <th>E-mail(登陆帐号)</th>
                            <th>名称</th>
                            <th>手机</th>
                            <th>权限组</th>
                            <th>角色</th>
                            <th>帐号状态</th>
                            <th>创建时间</th>
                            <th>最后登陆时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($pages as $value)
                        <tr>
                            <td><img src="{{ $value->avatar }}" height="60" width="60" alt="image" class="img-circle"></td>
                            <td>{{ $value->email }}</td>
                            <td>{{ $value->nick_name }}</td>
                            <td>{{ $value->mobile }}</td>
                           <td>{{ $value->hasGroup->role_name }}</td>
                            <td>{{ $value->hasRole->role_name }}</td>
                            <td>{!! $value->status?'<span class="badge badge-danger">禁用</span>':'<span class="badge badge-primary">正常</span>' !!}</td>
                            <td>{{ $value->created_at }}</td>
                            <td>{{ $value->last_login_time }}</td>
                            <td>
                                <a href="/role/edit/{{ $value->id }}" class="btn btn-primary btn-xs btn-rounded btn-outline">
                                    <i class="fas fa-file-alt"></i> 编辑
                                </a>
                                <span onClick="deleteRole({{$value->id}})" class="btn btn-primary btn-xs btn-rounded btn-outline">
                                    <i class="fas fa-file-excel"></i> 删除
                                </span>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>

                    @include('extman.page',['pages'=>$pages])

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
                url: '/role/del',
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