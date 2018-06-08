<!--纺辑权限组-->
<div class="modal inmodal fade" id="editgroup" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <span class="font-bold">编辑权限组</span>
            </div>
            <form action="{{ url('back/role/editgroup') }}" method="post" class="form-horizontal">
                <input type="hidden" class="form-control" id="group_id" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-lg-4 control-label">权限组名称 *</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" value="{{ old('role_name') }}" name="role_name" id="group_name" required placeholder="如：技术部" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">权限组描述</label>
                        <div class="col-lg-4">
                            <textarea type="text" class="form-control" rows="3" value="{{ old('role_description') }}" name="role_description" id="group_description" placeholder="如：技术组下面有前端/UI等角色"></textarea>
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
        $('#editgroup').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var group_id = button.data('group_id') // Extract info from data-* attributes
            var group_name = button.data('group_name')
            var group_description = button.data('group_description')

            var modal = $(this)
            modal.find('#group_id').val(group_id)
            modal.find('#group_name').val(group_name)
            modal.find('#group_description').val(group_description)
        })
    });
</script>


<!--纺辑角色组-->
<div class="modal inmodal fade" id="editrole" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <span class="font-bold">编辑角色</span>
            </div>
            <form action="{{ url('back/role/editgroup') }}" method="post" class="form-horizontal">
                <input type="hidden" class="form-control" id="role_id" name="id">
                <input type="hidden" value="{{ $role_id }}" name="role_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-lg-4 control-label">所属权限组 *</label>
                        <div class="col-md-4">
                            <select class="select form-control" id="parent_id" name="parent_id">
                                @foreach($groups as $v)
                                    <option @if($role_id==$v->id) selected="selected" @endif value="{{ $v->id }}">{{ $v->role_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">角色名称 *</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" value="{{ old('role_name') }}" name="role_name" id="role_name" required placeholder="如：技术部" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">角色描述</label>
                        <div class="col-lg-4">
                            <textarea type="text" class="form-control" rows="3" value="{{ old('role_description') }}" name="role_description" id="role_description" placeholder="如：技术组下面有前端/UI等角色"></textarea>
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
        $('#editrole').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var role_id = button.data('role_id') // Extract info from data-* attributes
            var role_name = button.data('role_name')
            var role_description = button.data('role_description')
            var role_pid = button.data('role_pid')
            var modal = $(this)
            modal.find('#role_id').val(role_id)
            modal.find('#role_name').val(role_name)
            modal.find('#role_description').val(role_description)
            //$("#parent_id").val(role_pid);
        })
    });

</script>

