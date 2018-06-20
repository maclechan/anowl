<!--模态框->菜单编辑-->
<div class="modal inmodal fade" id="edit" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                <span class="font-bold">编辑菜单权限</span>
            </div>
            <form action="{{ url('/role/editmenu') }}" method="post" id="editmenu-form" class="form-horizontal">
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="id" name="mod_id">
                    <div class="form-group">
                        <label class="col-lg-4 control-label">菜单名称 *</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control"  value="{{ old('mod_name') }}" name="mod_name" id="mod_name" required placeholder="如：添加角色" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">所属父类ID *</label>
                        <div class="col-lg-4">
                            <select class="form-control select" id="parent_id" required name="parent_id">
                                <option value="0">顶级菜单</option>
                                @foreach($select_data as $v)
                                    <option value="{{ $v->mod_id }}">{{ $v->mod_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">控制器名 *</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" value="{{ old('controller_name') }}" required name="controller_name" id="controller_name" placeholder="如： Role" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">方法名</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" value="{{ old('action_name') }}" name="action_name" id="action_name" placeholder="如： Addrole" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">URI路由</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" value="{{ old('url') }}" name="url" id="url" placeholder="如： back/role/addrole" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">icon图标</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" value="{{ old('icon_class') }}" name="icon_class" id="icon_class" placeholder="如： fa-user" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">排序</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" value="{{ old('sort') }}" name="sort" id="sort">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">是否导航</label>
                        <div class="col-lg-4">
                            <div class="radio radio-success radio-inline">
                                <input type="radio" id="is_show_1" value="1" name="is_show" checked="">
                                <label for="is_show_1">否</label>
                            </div>
                            <div class="radio radio-success radio-inline">
                                <input type="radio" id="is_show_0" value="0" name="is_show">
                                <label for="is_show_0">是</label>
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
            var controller = button.data('controller')
            var action = button.data('action')
            var url = button.data('url')
            var icon = button.data('icon')
            var sort = button.data('sort')
            var isshow = button.data('show')

            var modal = $(this)
            modal.find('#id').val(id)
            modal.find('#mod_name').val(name)
            modal.find('#controller_name').val(controller)
            modal.find('#action_name').val(action)
            modal.find('#url').val(url)
            modal.find('#icon_class').val(icon)
            modal.find('#sort').val(sort)
            modal.find("#is_show_"+isshow).attr("checked",true)
        })
    });
</script>
<!--edit-->