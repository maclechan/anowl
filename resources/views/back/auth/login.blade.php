<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BETA 管理系统-后台管理登录</title>

    <link href="{{ asset('assets/bootstrap-3.3.7/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/awesome-4.7.0/css/font-awesome.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/back/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/back/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/back/style.css') }}" rel="stylesheet">

</head>

<body class="gray-bg">
<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        <div><h1 class="logo-name"><i class="fa fa-code-fork" aria-hidden="true"></i></h1></div>

        <h3>sign in to iliber</h3>

        {!! Form::open(['url'=>'/back/login']) !!}
        <div class="form-group">
            <div class="input-group m-b">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary"><i class="fa fa-user-circle-o fa-lg" aria-hidden="true"></i></button>
                </span>
                {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'登陆帐号']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="input-group m-b">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary"> <i class="fa fa-unlock fa-lg" aria-hidden="true"> </i></button>
                </span>
                {!! Form::password('password',['class'=>'form-control','placeholder'=>'登陆密码']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="input-group m-l-xl">
                <label>{!! Form::checkbox('remember', '1' ,true,['class'=>'i-checks']) !!} 记住密码 </label>
            </div>
        </div>
        {!! Form::submit('登陆',['class'=>'btn btn-primary block full-width m-b']) !!}
        {!! Form::close() !!}
        <p class="m-t">
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul style="color:red;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </p>

            <p class="m-l-xl text-left">
                <i class="fa fa-envelope-square fa-lg" aria-hidden="true"> </i>  maclechan@qq.com<br/>
                <i class="fa fa-github fa-lg" aria-hidden="true"> </i> https://github.com/maclechan
            </p>
    </div>
</div>
</body>
</html>
<!-- Mainly scripts -->
<script type="text/javascript" src="{{ asset('js/back/jquery-2.1.1.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/back/plugins/iCheck/icheck.min.js') }}"></script>
<!-- End Mainly scripts -->
<script>
    $(document).ready(function () {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });
</script>