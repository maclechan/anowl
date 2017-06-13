<!--添加菜单-->
<div class="modal inmodal fade" id="edit" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <span class="font-bold">修改帐号</span>
            </div>

            <form action="{{ url('back/role/edit') }}" method="post" class="form-horizontal">
                {!! csrf_field() !!}
                <input type="hidden" class="form-control" id="id" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-lg-4 control-label">登陆帐号 </label>
                        <div class="col-lg-4">
                            <input type="text" value="{{ old('name') }}" disabled class="form-control"  name="name" id="name" required placeholder="尽量使用英文帐号登陆" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">登录密码 </label>
                        <div class="col-lg-4">
                            <input type="password" value="{{ old('password') }}" class="form-control"  name="password" id="password" placeholder="为空不修改" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">邮件 </label>
                        <div class="col-lg-4">
                            <input type="text" value="{{ old('email') }}" class="form-control"  name="email" id="email" required placeholder="如：maclechan@qq.com" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">姓名 </label>
                        <div class="col-lg-4">
                            <input type="text" value="{{ old('nick_name') }}" class="form-control"  name="nick_name" id="nick_name" required placeholder="如：路飞" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">手机号 </label>
                        <div class="col-lg-4">
                            <input type="text" value="{{ old('mobile') }}" class="form-control"  name="mobile" id="mobile"  placeholder="如：13251079793" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">是否禁用</label>
                        <div class="col-lg-4">
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

                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-sm btn-primary">保存</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script type="text/javascript">
    $("document").ready(function(){
        $('#edit').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id') // Extract info from data-* attributes
            var name = button.data('name')
            var email = button.data('email')
            var nick_name = button.data('nick_name')
            var mobile = button.data('mobile')

            var modal = $(this)
            modal.find('#id').val(id)
            modal.find('#name').val(name)
            modal.find('#email').val(email)
            modal.find('#nick_name').val(nick_name)
            modal.find('#mobile').val(mobile)
        })
    });
</script>