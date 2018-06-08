<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>管理后台-@yield('title')</title>

    <link href="{{ asset('assets/bootstrap-3.3.7/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/awesome-5.0.13/css/fontawesome-all.min.css') }}" rel="stylesheet">
    <!-- Toastr style -->
    <link href="{{ asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!--单选框-->
    <link href="{{ asset('css/plugins/checkbox/checkbox.css') }}" rel="stylesheet">
    <!--弹出框-->
    <link href="{{ asset('css/plugins/alert/sweetalert.css') }}" rel="stylesheet">
    <!-- Mainly scripts -->
    <script type="text/javascript" src="{{ asset('js/jquery-2.1.1.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/bootstrap-3.3.7/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script type="text/javascript" src="{{ asset('js/inspinia.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/plugins.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/bootstrap-3.3.7/js/bootstrap-select.js') }}"></script>
    <!--弹出框-->
    <script type="text/javascript" src="{{ asset('js/plugins/alert/sweetalert.min.js') }}"></script>
    <!-- Toastr script -->
    <script type="text/javascript" src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>
    <!-- End Mainly scripts -->

</head>

<body>

<div id="wrapper">

    <!--Start Nav-->
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <div class="text-center">
                                <img height="50" width="50" alt="image" class="img-circle" src={{$userInfo['info']->avatar}}>
                            </div>
                            <span class="text-center block m-t-xs">
                                <strong class="font-bold">   {{$userInfo['info']->nick_name}}</strong>
                                <div class="profile-data-title">{{$userInfo['group']->role_name}}
                                    / {{$userInfo['role']->role_name}}</div>
                            </span>
                        </a>
                    </div>
                    <div class="logo-element"><i class="fab fa-odnoklassniki" aria-hidden="true"></i></div>
                </li>
                @foreach ($menu as $value)
                    @if(!isset($value->menu))
                        <li @if(ucwords($value->controller_name).'Controller' == $controller_name) class="active" @endif>
                            <a href="{{ url($value->url) }}">
                                @if ($value->icon_class)<i class="fa {{$value->icon_class}}"></i> @endif

                                <span class="nav-label">{{$value->mod_name}}</span>
                            </a>
                        </li>
                    @else
                    <li @if(ucwords($value->controller_name).'Controller' == $controller_name) class="active" @endif>
                        <a href="#">
                            @if ($value->icon_class)<i class="fa {{$value->icon_class}}"></i> @endif
                            <span class="nav-label">{{$value->mod_name}}</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse @if(ucwords($value->controller_name) == $action_name)in @endif ">
                            @foreach ($value->menu as $menu_value)
                                <li @if(ucwords($menu_value->controller_name).'Controller' == $controller_name && strtolower($menu_value->action_name) == $action_name)
                                        class="active"
                                    @elseif(ucwords($menu_value->controller_name) == $breadcrumb[0]['controller_name'] && strtolower($menu_value->action_name) == $action_name)
                                        class="active"
                                    @endif >

                                    <a href="{{url($menu_value->url)}}">
                                        @if ($menu_value->icon_class)<i class="fa {{$menu_value->icon_class}}"></i> @endif
                                        {{$menu_value->mod_name}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    @endif
                @endforeach
            </ul>

        </div>
    </nav>
    <!--Start Nav-->

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">

                    <a class="navbar-minimalize pull-left m-t-md m-l-md" href="#"><i class="fas fa-outdent fa-lg text-muted"></i> </a>
                    <form role="search" class="navbar-form-custom" action="search_results.html">
                        <div class="form-group">
                            <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                        </div>
                    </form>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt fa-lg"></i>Log out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"></form>
                    </li>
                </ul>

            </nav>
        </div>

        <!--面包屑-->
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-9">
                <h2></h2>
                <ol class="breadcrumb">
                    <li><a href="/home"><i class="fas fa-home fa-lg text-navy" aria-hidden="true"></i></a></li>
                   @foreach ($breadcrumb as $value)
                        @if(empty($value['url']))
                            <li><i class="fas fa-sliders-h"></i> {{$value['mod_name']}}</li>
                        @else
                            <li class="active">
                                <i class="fas fa-map-signs"></i>
                                <a href="{{url($value['url'])}}"><b>{{$value['mod_name']}}</b></a>
                            </li>
                        @endif
                    @endforeach
                </ol>
            </div>
        </div>
        <!--面包屑-->

        <div class="wrapper wrapper-content animated fadeInRight">
            @yield('content')
        </div>

        <div class="footer">
            <div class="pull-right">
                power by <strong>maclechan@qq.com</strong>.
            </div>
        </div>

    </div>
</div>

</body>

</html>
