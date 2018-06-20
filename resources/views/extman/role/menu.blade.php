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

                    <div class="dd" id="nestable">
                        <ol class="dd-list">
                            <li class="dd-item">
                                <div class="dd-handle">
                                    <div class="row" style="margin-left: 15px">
                                        <div class="col-sm-2"><b><span class="badge">#</span>  菜单名称</b></div>
                                        <div class="col-sm-2"><b>控制器名称</b></div>
                                        <div class="col-sm-2"><b>动作名称</b></div>
                                        <div class="col-sm-2"><b>URI</b></div>
                                        <div class="col-sm-2"><b>左侧导航</b></div>
                                        <div class="col-sm-2"><b>操作</b></div>
                                    </div>
                                </div>
                            </li>

                            @foreach ($pages as $value)
                            @if(!$value->parent_id)
                            <li class="dd-item" >
                                <button data-action="collapse" type="button">Collapse</button>
                                <div class="dd-handle ">
                                    <div class="row" style="margin-left: 15px">
                                        <span class="col-sm-2"><span class="badge">{{ $value->mod_id }}</span> {{ $value->mod_name }}</span>
                                        <span class="col-sm-2">{{ $value->controller_name }}</span>
                                        <span class="col-sm-2">{{ $value->action_name }}</span>
                                        <span class="col-sm-2">{{ $value->url }}</span>
                                        <span class="col-sm-2">{!! $value->is_show?'<span class="label label-warning">隐藏</span>':'<span class="label label-primary">导航</span>' !!}</span>
                                        <div class="col-sm-2">
                                            <span data-id="{{ $value->mod_id }}"
                                                  data-name="{{ $value->mod_name }}"
                                                  data-controller="{{ $value->controller_name }}"
                                                  data-action="{{ $value->action_name }}"
                                                  data-url="{{ $value->url }}"
                                                  data-icon="{{ $value->icon_class }}"
                                                  data-sort="{{ $value->sort }}"
                                                  data-show="{{ $value->is_show }}"
                                                  data-toggle="modal"
                                                  data-target="#edit"
                                                  class="btn btn-primary btn-xs btn-rounded btn-outline">
                                                <i class="fas fa-file-alt"></i> 编辑
                                            </span>
                                            <span onClick="deleteNav({{$value['mod_id']}})" class="btn btn-primary btn-xs btn-rounded btn-outline">
                                                <i class="fas fa-file-excel"></i> 删除
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <ol class="dd-list">
                                @foreach ($_smenu as $_v)
                                    @if($_v->parent_id == $value->mod_id)
                                    <li class="dd-item" data-id="3">
                                        <div class="dd-handle">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <span class="badge">{{ $_v->mod_id }}</span> {{ $_v->mod_name }}</div>
                                                <div class="col-sm-2">{{ $_v->controller_name }}</div>
                                                <div class="col-sm-2">{{ $_v->action_name }}</div>
                                                <div class="col-sm-2">{{ $_v->url }}</div>
                                                <div class="col-sm-2">{!! $_v->is_show?'<span class="label label-warning">隐藏</span>':'<span class="label label-primary">导航</span>' !!}</div>
                                                <div class="col-sm-2">
                                                    <span data-id="{{ $_v->mod_id }}"
                                                          data-name="{{ $_v->mod_name }}"
                                                          data-controller="{{ $_v->controller_name }}"
                                                          data-action="{{ $_v->action_name }}"
                                                          data-url="{{ $_v->url }}"
                                                          data-icon="{{ $_v->icon_class }}"
                                                          data-sort="{{ $_v->sort }}"
                                                          data-show="{{ $_v->is_show }}"
                                                          data data-toggle="modal"
                                                          data-target="#edit"
                                                          class="btn btn-primary btn-xs btn-rounded btn-outline">
                                                          <i class="fas fa-file-alt"></i> 编辑
                                                    </span>
                                                    <span onClick="deleteNav({{$_v['mod_id']}})" class="btn btn-primary btn-xs btn-rounded btn-outline">
                                                        <i class="fas fa-file-excel"></i> 删除
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @endif
                                @endforeach

                                </ol>
                            </li>
                            @endif
                        @endforeach

                        </ol>
                    </div>

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