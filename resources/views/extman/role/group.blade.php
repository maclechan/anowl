@section('title', '权限角色管理')
@extends('extman.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">

                    @include('extman.message')

                    <div class="row">
                        <div class="col-sm-9 m-b-xs">
                            <ul>
                                @if(isset($tag) && ($tag == 'role'))
                                    <span data-toggle="modal" data-target="#addrole" class="btn btn-sm btn-outline btn-primary">
                                        <i class="fa fa-plus"> </i> 创建角色
                                    </span>
                                @else
                                    <span data-toggle="modal" data-target="#addgroup" class="btn btn-sm btn-outline btn-primary">
                                        <i class="fa fa-plus"> </i> 创建权限组
                                    </span>
                                @endif
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
                                    <th>权限组名称</th>
                                    <th>创建时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($pages as $value)
                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td>{{ $value->role_name }}</td>
                                        <td>{{ $value->created_at }}</td>
                                        <td>
                                        @if(isset($tag) && ($tag == 'role'))
                                            <span data-role_id="{{ $value->id }}"
                                                  data-role_name="{{ $value->role_name }}"
                                                  data-role_pid="{{ $value->parent_id }}"
                                                  data-role_description="{{ $value->role_description }}"
                                                  data-toggle="modal" data-target="#editrole" class="btn btn-primary btn-rounded btn-outline btn-xs">
                                                <i class="fas fa-file-alt"> </i> 编辑
                                            </span>
                                            <span onClick="delGroup({{$value->id}})" class="btn btn-primary btn-rounded btn-xs btn-outline">
                                                <i class="fas fa-file-excel"> </i> 删除
                                            </span>

                                            <a href="/role/permission/{{$value->id}}" class="btn btn-primary btn-rounded btn-outline btn-xs">
                                                <i class="fas fa-file-medical"> </i> 创建权限
                                            </a>
                                            <a href="/role/index?role_id={{ $value->id }}" class="btn btn-primary btn-rounded btn-outline btn-xs">
                                                <i class="fa fa-list-ul"> </i> 用户列表
                                            </a>
                                        @else
                                            <span data-group_id="{{ $value->id }}"
                                                  data-group_name="{{ $value->role_name }}"
                                                  data-group_description="{{ $value->role_description }}"
                                                  data-toggle="modal" data-target="#editgroup" class="btn btn-primary btn-rounded btn-outline btn-xs">
                                                <i class="fas fa-file-alt"> </i> 编辑
                                            </span>
                                            <span onClick="delGroup({{$value->id}})" class="btn btn-primary btn-rounded btn-xs btn-outline">
                                                <i class="fas fa-file-excel"> </i> 删除
                                            </span>

                                            <a href="/role/group/{{ $value->id }}" class="btn btn-primary btn-rounded btn-outline btn-xs">
                                                <i class="fas fa-file"> </i> 角色管理
                                            </a>
                                        @endif
                                        </td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>

                            @include('extman.page',['pages'=>$pages])
                        </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function delGroup(id){
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
                    url: '/role/delgroup',
                    data: {'id':id},
                    dataType: "json",
                    success: function (data) {
                        if(data.code == 1){
                            swal("删除失败", data.msg, "error");
                        }else {
                            swal("删除成功", data.msg, "success");
                        }
                        location.reload();
                    },
                    error: function (data) {
                        swal("参数无法传递错误", data.msg, "error");
                    }
                });
            });
        };
    </script>

@include('extman.role.addgroup')
@include('extman.role.editgroup')
@endsection