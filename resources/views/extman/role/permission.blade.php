@section('title', '权限分配')
@extends('extman.layout')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">

                @include('extman.message')

                <div class="row nav-tabs-custom">
                        <!-- Nav tabs -->
                        <form action="{{ url('role/rolepermission') }}" name="edit_permission" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="role_id" value="{{$role_id}}" readonly="readonly" />
                            <div class="tab-content">
                                <div class="tab-pane active" id="details">
                                    <div class="col-md-12">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="col-md-2">
                                                        模块名称
                                                        <a id="checkall" onclick="checkAll()" class="text-navy m-l-sm"><i class="far fa-check-circle"></i></a>
                                                        <a id="unSelect" class="text-navy m-l-sm"><i class="far fa-times-circle"></i></a>
                                                    </th>
                                                    <th>权限分配</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($nav_data as $key => $value)
                                                @if($value['parent_id'] == 0)
                                                <tr id="nav_{{$value['mod_id']}}">
                                                    <td>
                                                        <b>{{ $value['mod_name'] }}</b>
                                                        <a onclick="check(document.getElementById('nav_'+{{$value['mod_id']}}))" class="text-navy m-l-sm"><i class="far fa-check-circle"></i></a>
                                                    </td>
                                                    <td>
                                                        <div class="col-md-1 checkbox checkbox-success">
                                                            <input @if(in_array($value['mod_id'], $role_mod_data)) checked @endif name="mod_id[]" id="{{ $value['mod_id'] }}" value="{{ $value['mod_id'] }}" type="checkbox">
                                                            <label for="{{ $value['mod_id'] }}">{{$value['mod_name']}}</label>
                                                        </div>
                                                @else
                                                        <div class="col-md-1 checkbox checkbox-success">
                                                            <input @if(in_array($value['mod_id'], $role_mod_data)) checked @endif name="mod_id[]" id="{{ $value['mod_id'] }}" value="{{ $value['mod_id'] }}" type="checkbox">
                                                            <label for="{{ $value['mod_id'] }}">{{$value['mod_name']}}</label>
                                                        </div>
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <style type="text/css">
                                        .checkbox+.checkbox, .radio+.radio {
                                            margin-top: 10px;
                                        }
                                    </style>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o"></i> 保 存</button>
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
    //全选设置
    function checkAll(){
        var checkall = document.getElementById('checkall');
        var form_mod_id  = document.forms['edit_permission'].elements['mod_id[]'];
        var len   = form_mod_id.length;

        for(var i =0; i<len; i++){
            form_mod_id[i].checked = true;
        }
    };

    //反选
    $("#unSelect").click(function () {//全不选
        $(".table :checkbox").attr("checked", false);
    });

    function check(Obj){
        var div_input = Obj.getElementsByTagName('input');
        var len       = div_input.length;

        for(var i=0; i<len; i++){
            div_input[i].checked = true;
        }
    }
</script>
@endsection