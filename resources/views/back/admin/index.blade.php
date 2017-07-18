@extends('back.layout')
@section('content')

    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="widget-head-color-box navy-bg p-lg text-center">
                <div class="m-b-md">
                    <h2 class="font-bold no-margins">
                        {{$userInfo['info']->nick_name}}
                    </h2>
                    <span>{{$userInfo['group']->role_name}} / {{$userInfo['role']->role_name}}</span>
                </div>
                <i class="fa fa-flash fa-4x"></i>
                {{--<div>
                    <span>100 Tweets</span> |
                    <span>350 Following</span> |
                    <span>610 Followers</span>
                </div>--}}
            </div>
        </div>
    </div>
@endsection