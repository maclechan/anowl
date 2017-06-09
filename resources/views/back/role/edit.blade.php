<!--模态框->菜单编辑-->
<div class="modal inmodal fade" id="editmenu" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                <span class="font-bold">编辑用户</span>
            </div>
            <form action="{{ url('back/role/edit') }}" method="post" id="editmenu-form" class="form-horizontal" enctype="multipart/form-data">
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <input type="hidden" class="form-control" id="id" name="id">
                    <div class="form-group">
                        <label class="col-lg-4 control-label">登陆帐号 *</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control"  name="name" id="name" required placeholder="如：123" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">重置密码</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control"  name="password" id="password"  placeholder="如：1" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">邮件 *</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control"  name="email" id="email" required placeholder="如：123@qq.com" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">姓名 *</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control"  name="nick_name" id="nick_name" required placeholder="如：张三" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">手机号 </label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control"  name="mobile" id="mobile"  placeholder="如：123456789" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">是否禁用</label>
                        <div class="col-lg-4">
                            <select class="form-control " id="status" required name="status">
                                <option value="0">否</option>
                                <option value="1">是</option>
                            </select>
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
        $('#editmenu').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var modal = $(this)
            modal.find('#id').val(button.data('id'))
            modal.find('#name').val(button.data('name'))
            modal.find('#email').val(button.data('email'))
            modal.find('#nick_name').val(button.data('nick_name'))
            modal.find('#mobile').val(button.data('mobile'))
            modal.find('#status').val(button.data('status'))
        })
    });
</script>
<!--edit-->