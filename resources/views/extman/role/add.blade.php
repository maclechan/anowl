@section('title', '创建用户')
@extends('extman.layout')
@section('content')


<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">

                <div class="panel-body">
                    @include('extman.message')
                </div>

                @if (empty($user))
                <form action="{{ url('/role/add') }}" method="post" id="addform" class="form-horizontal" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-lg-2 control-label">权限组/角色</label>
                            <div class="col-lg-2">
                                <select class="select form-control" id="group_id" name="group_id" required>
                                    <option>选择权限组</option>
                                    @foreach($groups as $v)
                                        <option value="{{ $v['id'] }}">{{ $v['role_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id='hide_role_id' style=" display: none;" required>
                            <label class="col-lg-2 control-label"> </label>
                            <div class="col-lg-2">
                                <select class="select form-control" id="role_id" name="role_id">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">英文 </label>
                            <div class="col-lg-3">
                                <input type="text" value="{{ old('name') }}" class="form-control"  name="name" id="name" required placeholder="英文名称" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">登陆邮箱 *</label>
                            <div class="col-lg-3">
                                <input type="email" value="{{ old('email') }}" class="form-control"  name="email" id="email" required placeholder="如：maclechan@qq.com" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">登录密码 *</label>
                            <div class="col-lg-3">
                                <input type="password" value="{{ old('password') }}" class="form-control" required name="password" id="password" placeholder="密码不能少到6位" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">确认密码 *</label>
                            <div class="col-lg-3">
                                <input type="password" value="{{ old('password_confirmation') }}" class="form-control" required name="password_confirmation" id="password_confirmation" placeholder="两次密码要一致" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">姓名 *</label>
                            <div class="col-lg-3">
                                <input type="text" value="{{ old('nick_name') }}" class="form-control"  name="nick_name" id="nick_name" required placeholder="如：路飞" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">手机号 </label>
                            <div class="col-lg-3">
                                <input type="text" value="{{ old('mobile') }}" class="form-control"  name="mobile" id="mobile"  placeholder="如：16888886666" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">是否禁用</label>
                            <div class="col-lg-3">
                                <div class="radio radio-success radio-inline">
                                    <input type="radio" id="is_show_1" value="1" name="status">
                                    <label for="is_show_1">是</label>
                                </div>
                                <div class="radio radio-success radio-inline">
                                    <input type="radio" id="is_show_0" value="0" name="status" checked="">
                                    <label for="is_show_0">否</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-primary" type="reset"> <i class="fa fa-reply"> </i> 取 消</button>
                            <button class="btn btn-primary" type="submit"> <i class="fa fa-floppy-o"></i> 保 存</button>
                        </div>
                    </div>
                </form>
                @else
                <form action="{{ url('/role/edit') }}" method="post" id="addform" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" value="{{ $user['id'] }}" id="id" name="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-lg-2 control-label">登陆帐号 *</label>
                            <div class="col-lg-2">
                                <input type="text" value="{{$user['email']}}" disabled class="form-control"  name="email" id="email" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">权限组/角色</label>
                            <div class="col-lg-2">
                                <select autocomplete="off" class="select form-control" id="group_id" name="group_id" required>
                                    <option>选择权限组</option>
                                    @foreach($groups as $v)
                                        <option value="{{ $v['id'] }}">{{ $v['role_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id='hide_role_id' required>
                            <label class="col-lg-2 control-label"> </label>
                            <div class="col-lg-2">
                                <select autocomplete="off" class="select form-control" id="role_id" name="role_id" required>
                                    @if($roles)
                                        @foreach($roles as $_v)
                                            <option value="{{ $_v['id'] }}">{{ $_v['role_name'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">登录密码 </label>
                            <div class="col-lg-3">
                                <input type="password" value="{{ old('password') }}" class="form-control" name="password" id="password" placeholder="为空不修改"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">姓名 *</label>
                            <div class="col-lg-3">
                                <input type="text" value="{{$user['name']}}" class="form-control"  name="name" id="name" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">昵称 *</label>
                            <div class="col-lg-3">
                                <input type="text" value="{{$user['nick_name']}}" class="form-control"  name="nick_name" id="nick_name" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">手机号 </label>
                            <div class="col-lg-3">
                                <input type="text" value="{{$user['mobile']}}" class="form-control"  name="mobile" id="mobile" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">是否禁用</label>
                            <div class="col-lg-4">
                                <div class="radio radio-success radio-inline">
                                    <input type="radio" id="is_show_1" value="1" name="status" @if($user['status']==1) checked @endif>
                                    <label for="is_show_1">是</label>
                                </div>
                                <div class="radio radio-success radio-inline">
                                    <input type="radio" id="is_show_0" value="0" name="status" @if($user['status']==0) checked @endif>
                                    <label for="is_show_0">否</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-primary" type="submit">取 消</button>
                            <button class="btn btn-primary" type="submit">保 存</button>
                        </div>
                    </div>
                </form>
                    <script type="text/javascript">
                        var group_id = "{{$user['group_id']}}";
                        var role_id  = "{{$user['role_id']}}";
                        if(group_id && role_id){
                            $("#role_id").val(role_id);
                            $("#group_id").val(group_id);
                        }
                    </script>
            @endif
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("document").ready(function(){
        $("#addform").validate({
            errorElement : "small",
            errorClass : "error",
        });
    });
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
            url:"{{url('/role/add')}}/"+group_id,
            type:'get',
            dataType:"json",
        };

        $.ajax(parame).done(function(data){
            $("#hide_role_id").show();
           // console.log(data);
            for(var i=0; i<data.length;i++) {
                $("#role_id").append("<option value='"+data[i].id+"'>"+data[i].role_name+"</option>");
            }
            $('#role_id').selectpicker('refresh');
        });
    });
</script>
@endsection
