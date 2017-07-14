@section('title', '用户权限-用户列表')
@extends('back.layout')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">

                @include('back.message')

                <div class="row nav-tabs-custom">
                        <!-- Nav tabs -->
                        <form action="{{ url('back/role/rolepermission') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="role_id" value="{{$role_id}}" readonly="readonly" />
                            <div class="tab-content">
                                <div class="tab-pane active" id="details">
                                    <div class="col-md-12">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="col-md-2">模块名称</th>
                                                    <th>权限分配</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($nav_data as $key => $value)
                                                @if($value['parent_id'] == 0)
                                                <tr id="nav_{{$value['nav_id']}}">
                                                    <td>
                                                        <b onclick="check(document.getElementById('nav_'+{{$value['nav_id']}}))">{{ $value['nav_name'] }}</b>
                                                    </td>
                                                    <td>
                                                        <div class="col-md-1 checkbox checkbox-success">
                                                            <input @if(in_array($value['nav_id'], $role_mod_data)) checked @endif name="nav_id[]" id="{{ $value['nav_id'] }}" value="{{ $value['nav_id'] }}" type="checkbox">
                                                            <label for="{{ $value['nav_id'] }}">{{$value['nav_name']}}</label>
                                                        </div>
                                                @else
                                                        <div class="col-md-1 checkbox checkbox-success">
                                                            <input @if(in_array($value['nav_id'], $role_mod_data)) checked @endif name="nav_id[]" id="{{ $value['nav_id'] }}" value="{{ $value['nav_id'] }}" type="checkbox">
                                                            <label for="{{ $value['nav_id'] }}">{{$value['nav_name']}}</label>
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
    function check(Obj){
        var div_input = Obj.getElementsByTagName('input');
        var len       = div_input.length;

        for(var i=0; i<len; i++){
            div_input[i].checked = true;
        }
    }
</script>
@endsection