@section('title', '用户权限-用户列表')
@extends('back.layout')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
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

                <div class="row nav-tabs-custom">
                        <!-- Nav tabs -->
                        <form accept-charset="utf-8" class="form-vertical" id="user-role-create" files="true" method="POST" action="http://demo.lavalite.org/admin/user/role">
                            <div class="tab-content">
                                <div class="tab-pane active" id="details">
                                    <div class="col-md-12">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="col-md-2">模块</th>
                                                    <th>权限分配</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($nav_data as $key => $value)
                                                @if($key == 0 && $value['parent_id'] == 0)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $value['nav_name'] }}</strong>
                                                    </td>
                                                    <td>
                                                        @elseif($key != 0 && $value['parent_id'] == 0)
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <strong>{{ $value['nav_name'] }}</strong>
                                                    </td>
                                                    <td>
                                                        @else
                                                            <div class="col-md-1 checkbox checkbox-success">
                                                                <input name="nav_id[]" id="{{ $value['nav_id'] }}" value="{{ $value['nav_id'] }}" type="checkbox">
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
                            </div>
                        </form>
                    </div>

            </div>
        </div>
    </div>
</div>

@endsection