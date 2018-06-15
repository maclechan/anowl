@section('title', '菜单管理')
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
                            <span data-toggle="modal" data-target="#addmenu" class="btn btn-sm btn-primary btn-outline">
                                <i class="fa fa-plus"></i> 创建菜单
                            </span>
                        </ul>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>菜单名称</th>
                                <th>控制器</th>
                                <th>方法</th>
                                <th>路由</th>
                                <th>是否导航</th>
                                <th>icon</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($pages as $value)
                            @if(!$value->parent_id)
                            <tr>
                                <td data-toggle="collapse" href="#faq{{ $value->mod_id }}">
                                    <a class="badge badge-primary"><span class="fa fa-arrow-circle-down"> </span> {{ $value->mod_id }}</a>
                                </td>
                                <td>{{ $value->mod_name }}</td>
                                <td>{{ $value->controller_name }}</td>
                                <td>{{ $value->action_name }}</td>
                                <td>{{ $value->url }}</td>
                                <td>{!! $value->is_show?'<span class="badge badge-danger">隐藏</span>':'<span class="badge badge-primary">导航</span>' !!}</td>
                                <td><i class="fa {{ $value->icon_class }}" aria-hidden="true"></i></td>
                                <td>
                                    <span data-id="{{ $value->mod_id }}"
                                          data-name="{{ $value->mod_name }}"
                                          data-controller="{{ $value->controller_name }}"
                                          data-action="{{ $value->action_name }}"
                                          data-url="{{ $value->url }}"
                                          data-icon="{{ $value->icon_class }}"
                                          data-sort="{{ $value->sort }}"
                                          data-show="{{ $value->is_show }}"
                                          data-toggle="modal"
                                          data-target="#editmenu"
                                          class="btn btn-primary btn-xs btn-rounded btn-outline">
                                        <i class="fa fa-pencil"></i> 编辑
                                    </span>
                                    <span onClick="deleteNav({{$value['mod_id']}})" class="btn btn-primary btn-xs btn-rounded btn-outline">
                                        <i class="fa fa-trash-o"></i> 删除
                                    </span>
                                </td>
                            </tr>
                            <tr id="faq{{ $value->mod_id }}" class="panel-collapse collapse" bgcolor="#F9F9F9">
                                    <td colspan="8">
                                        <table class="table table-bordered table-hover">
                                            <tbody>
                                            @foreach ($_smenu as $_v)
                                                @if($_v->parent_id == $value->mod_id)
                                                    <tr>
                                                        <td>{{ $_v->mod_id }}</td>
                                                        <td>{{ $_v->mod_name }}</td>
                                                        <td>{{ $_v->controller_name }}</td>
                                                        <td>{{ $_v->action_name }}</td>
                                                        <td>{{ $_v->url }}</td>
                                                        <td>{!! $_v->is_show?'<span class="badge badge-danger">隐藏</span>':'<span class="badge badge-primary">导航</span>' !!}</td>
                                                        <td><i class="fa {{ $_v->icon_class }}" aria-hidden="true"></i></td>
                                                        <td>
                                                            <span data-id="{{ $_v->mod_id }}"
                                                                  data-name="{{ $_v->mod_name }}"
                                                                  data-controller="{{ $_v->controller_name }}"
                                                                  data-action="{{ $_v->action_name }}"
                                                                  data-url="{{ $_v->url }}"
                                                                  data-icon="{{ $_v->icon_class }}"
                                                                  data-sort="{{ $_v->sort }}"
                                                                  data-show="{{ $_v->is_show }}"
                                                                  data data-toggle="modal"
                                                                  data-target="#editmenu"
                                                                  class="btn btn-primary btn-xs btn-rounded btn-outline">
                                                                  <i class="fa fa-pencil"></i> 编辑
                                                            </span>
                                                            <span onClick="deleteNav({{$_v['mod_id']}})" class="btn btn-primary btn-xs btn-rounded btn-outline">
                                                                <i class="fa fa-trash-o"></i> 删除
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            @endif
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
    function deleteNav(mod_id){
        var mod_id = mod_id;
        swal({
            title: "确定删除吗?",
            text: "此次操作不可逆!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#1ab394",
            confirmButtonText: "确定",
            cancelButtonText: "取消",
            closeOnConfirm: false
        },
        function(){
            $.ajax({
                type: 'POST',
                url: '/role/delmenu',
                data: {'mod_id':mod_id},
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
@include('extman.role.addmenu')
@include('extman.role.editmenu')
@endsection