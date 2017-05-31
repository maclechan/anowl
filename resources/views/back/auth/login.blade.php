<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>管理后台登陆</title>

    <link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/awesome/css/font-awesome.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/back/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/back/style.css') }}" rel="stylesheet">

</head>

<body class="gray-bg">

<div class="loginColumns animated fadeInDown">
    <div class="row">

        <div class="col-md-6">


            <p>

                <div class="contact-box">
                    <a href="#">
                        <div class="col-sm-4">
                            <div class="text-center">
                                <img alt="image" class="img-circle m-t-xs img-responsive" src="/img/back/patterns/chan.jpg">
                                <div class="m-t-xs font-bold">Graphics designer</div>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <h3><strong>John Smith</strong></h3>
            <p><i class="fa fa-map-marker"></i> Riviera State 32/106</p>
            <address>
                <strong>Twitter, Inc.</strong><br>
                795 Folsom Ave, Suite 600<br>
                San Francisco, CA 94107<br>
                <abbr title="Phone">P:</abbr> (123) 456-7890
            </address>
        </div>
        <div class="clearfix"></div>
        </a>
    </div>

    </p>



        </div>
        <div class="col-md-6">
            <div class="ibox-content">
                <h2 class="font-bold">  </h2>
                {!! Form::open(['url'=>'/back/login']) !!}

                <div class="form-group">
                    {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'登陆帐号']) !!}
                </div>

                <div class="form-group">
                    {!! Form::password('password',['class'=>'form-control','placeholder'=>'登陆密码']) !!}
                </div>

                <div class="form-group">
                    {!! Form::checkbox('remember', '1' ,true) !!} 记住密码
                </div>

                    {!! Form::submit('登陆',['class'=>'btn btn-primary block full-width m-b']) !!}

                {!! Form::close() !!}
            </div>
            <p>
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

        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-md-6">
            Power By maclechan@qq.com
        </div>
        <div class="col-md-6 text-right">
            <small>© 2016-2018</small>
        </div>
    </div>
</div>

</body>

</html>