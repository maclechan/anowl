@section('title', '用户权限 - 创建用户')
@extends('back.layout')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">
                <form action="{{ url('back/role/add') }}" method="post" id="addform" class="form-horizontal" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-lg-2 control-label">登陆帐号 *</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control"  name="name" id="name" required placeholder="如：123" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">登录密码 *</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control"  name="password" id="password" required placeholder="如：1" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">邮件 *</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control"  name="email" id="email" required placeholder="如：123@qq.com" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">姓名 *</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control"  name="nick_name" id="nick_name" required placeholder="如：张三" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">手机号 </label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control"  name="mobile" id="mobile"  placeholder="如：123456789" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">是否禁用</label>
                            <div class="col-lg-4">
                                <div class="radio radio-success radio-inline">
                                    <input type="radio" id="is_show_1" value="1" name="status" checked="">
                                    <label for="is_show_1">是</label>
                                </div>
                                <div class="radio radio-success radio-inline">
                                    <input type="radio" id="is_show_0" value="0" name="status">
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
@endsection