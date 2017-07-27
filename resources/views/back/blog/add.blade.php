@section('title', '用户权限-创建用户')
@extends('back.layout')
@section('content')


<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">

                <div class="panel-body">
                    @include('back.message')
                </div>

                <div class="panel blank-panel">
                    <div class="panel-heading">
                        <div class="panel-options">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="project_detail.html#tab-1" data-toggle="tab" aria-expanded="true">基本信息</a></li>
                                <li class=""><a href="project_detail.html#tab-2" data-toggle="tab" aria-expanded="false">内容详情</a></li>
                            </ul>
                        </div>
                    </div>

                    <form action="{{ url('back/blog/add') }}" id="addform" method="post" class="form-horizontal" enctype="multipart/form-data">
                    <div class="panel-body">

                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-1">

                                    <div class="modal-body">
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">文章标题 *</label>
                                                <div class="col-lg-3">
                                                    <input type="text" value="{{ old('title') }}" class="form-control"  name="title" id="title" required placeholder="文章标题" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">文章标签</label>
                                                <div class="col-lg-3">
                                                    <input type="text" value="{{ old('tag') }}" class="form-control"  name="tag" id="tag" placeholder="文章标签" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">文章简介</label>
                                                <div class="col-lg-3">
                                                    <textarea value="{{ old('intro') }}" class="form-control" name="intro" id="intro" placeholder="文章简介"></textarea>
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


                            </div>
                            <div class="tab-pane" id="tab-2">
                                内容二

                            </div>
                        </div>

                    </div>
                    </form>
                </div>


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
