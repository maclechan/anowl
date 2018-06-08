@extends('extman.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                   {{--{{ dd($menu) }}
                        {{ dd($userInfo) }}--}}
                    <?php
                        //print_r($controller_name);
                        //print_r($action_name) ?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
