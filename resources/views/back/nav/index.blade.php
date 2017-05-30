@section('title', '首页')
@extends('back.layout')
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>菜单权限列表 </h5>

                </div>
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
                        <div class="col-sm-9 m-b-xs tooltip-demo">
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
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>菜单名称</th>
                                <th>控制器</th>
                                <th>方法</th>
                                <th>路由</th>
                                <th>是否导航</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                           @foreach ($_pmenu as $value)
                                @if(!$value->parent_id)
                                <tr>
                                    <td data-toggle="collapse" href="#faq{{ $value->nav_id }}">
                                        <a class="badge badge-primary"><span class="fa fa-angle-down"> </span> {{ $value->nav_id }}</a>
                                    </td>
                                    <td>{{ $value->nav_name }}</td>
                                    <td>{{ $value->controller_name }}</td>
                                    <td>{{ $value->action_name }}</td>
                                    <td>{{ $value->url }}</td>
                                    <td>
                                        <div class="onoffswitch">
                                            <input {{ $value['is_show'] == 1 ? checked: '' }} type="checkbox" id="{{ $value->nav_id }}" class="onoffswitch-checkbox">
                                            <label for="{{ $value->nav_id }}" class="onoffswitch-label">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <span data-id="{{ $value->nav_id }}"
                                              data-name="{{ $value->nav_name }}"
                                              data-controller="{{ $value->controller_name }}"
                                              data-action="{{ $value->action_name }}"
                                              data-url="{{ $value->url }}"
                                              data-icon="{{ $value->icon_class }}"
                                              data-sort="{{ $value->sort }}"
                                              data-show="{{ $value->is_show }}"
                                              data data-toggle="modal" data-target="#editmenu" data-toggle="tooltip" class="btn btn-primary btn-xs">
                                            <i class="fa fa-pencil"></i> 编辑
                                        </span>
                                        <span onClick="deleteNav({{$value['nav_id']}})" class="btn btn-primary btn-xs">
                                            <i class="fa fa-trash-o"></i> 删除
                                        </span>
                                    </td>
                                </tr>
                                <tr id="faq{{ $value->nav_id }}" class="panel-collapse collapse" bgcolor="#F9F9F9">
                                        <td colspan="7">
                                            <table class="table table-bordered table-hover">
                                                <tbody>

                                                @foreach ($_smenu as $_v)
                                                    @if($_v->parent_id == $value->nav_id)
                                                        <tr>
                                                            <td>{{ $_v->nav_id }}</td>
                                                            <td>{{ $_v->nav_name }}</td>
                                                            <td>{{ $_v->controller_name }}</td>
                                                            <td>{{ $_v->action_name }}</td>
                                                            <td>{{ $_v->url }}</td>
                                                            <td>
                                                                <div class="onoffswitch">
                                                                    <input {{ $_v['is_show'] == 1 ? checked: '' }} type="checkbox" id="{{ $_v->nav_id }}" class="onoffswitch-checkbox">
                                                                    <label for="{{ $_v->nav_id }}" class="onoffswitch-label">
                                                                        <span class="onoffswitch-inner"></span>
                                                                        <span class="onoffswitch-switch"></span>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span data-id="{{ $_v->nav_id }}"
                                                                      data-name="{{ $_v->nav_name }}"
                                                                      data-controller="{{ $_v->controller_name }}"
                                                                      data-action="{{ $_v->action_name }}"
                                                                      data-url="{{ $_v->url }}"
                                                                      data-icon="{{ $_v->icon_class }}"
                                                                      data-sort="{{ $_v->sort }}"
                                                                      data-show="{{ $_v->is_show }}"
                                                                      data data-toggle="modal" data-target="#editmenu" data-toggle="tooltip" class="btn btn-primary btn-xs">
                                                                      <i class="fa fa-pencil"></i> 编辑
                                                                </span>
                                                                <a href="#" class="btn btn-primary btn-xs">
                                                                    <i class="fa fa-trash-o"></i> 删除
                                                                </a>
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

                        <div class="text-right tooltip-demo">
                            {!! $_pmenu->render() !!}

                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>
    <script>
        function deleteNav(nav_id){
            var nav_id = nav_id;
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
                            url: '/back/nav/del',
                            data: {'nav_id':nav_id, '_token':"<?=csrf_token()?>"},
                            dataType: "json",
                            success: function (data) {
                                swal("Deleted!", data.msg, "success");
                                window.location = '/back/nav/index';
                            },
                            error: function (data) {
                                swal("Error!", data.msg, "error");
                            }
                        });
            });
        };
    </script>

    @include('back.nav.add')
    @include('back.nav.edit')
@endsection