<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登录</title>

    <link href="{{ asset('assets/bootstrap-3.3.7/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/awesome-5.0.13/css/fontawesome-all.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>

<body class="gray-bg">
<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        <div><h1 class="logo-name"><i class="fas fa-code" aria-hidden="true"></i></h1></div>

        <h3>登陆</h3>

        <form class="login-form" method="POST" action="{{ route('login') }}">
            <div class="form-group">
                <div class="input-group m-b">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary"><i class="fas fa-user fa-lg" aria-hidden="true"></i></button>
                </span>
                    <input class="form-control" placeholder="登陆帐号" id="email" type="email" class="form-control" name="email" value="{{ old('name') }}" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group m-b">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary"> <i class="fas fa-unlock fa-lg" aria-hidden="true"> </i></button>
                </span>
                    <input class="form-control" placeholder="登陆密码" id="password" type="password" value="{{ old('password') }}" class="form-control" name="password" required>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group m-l-xl">
                    <label>
                        <input class="i-checks" checked="checked" name="remember" type="checkbox" value="1" {{ old('remember') ? 'checked' : '' }}>
                        记住密码
                    </label>
                </div>
            </div>
            <button class="btn btn-primary block full-width m-b" type="submit">登录</button>
        </form>
        <p class="m-t">
        @if (count($errors) > 0)
            <div class="alert alert-danger text-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('msg'))
            <div class="alert alert-danger text-danger">
                <ul>
                    {{ session('msg') }}
                </ul>
            </div>
            @endif
        </p>

            <p class="m-l-xl text-left">
                <i class="fas fa-envelope" aria-hidden="true"> </i> maclechan@qq.com<br/>
                <i class="fab fa-github-square" aria-hidden="true"> </i> https://github.com/maclechan
            </p>
    </div>
</div>
</body>
</html>
<!-- Mainly scripts -->
<script type="text/javascript" src="{{ asset('js/jquery-2.1.1.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<!-- End Mainly scripts -->
<script>
    $(document).ready(function () {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });
</script>