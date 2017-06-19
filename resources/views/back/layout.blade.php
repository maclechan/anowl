<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>管理后台-@yield('title')</title>

    <link href="{{ asset('assets/bootstrap-3.3.7/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/awesome-4.7.0/css/font-awesome.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/back/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/back/style.css') }}" rel="stylesheet">
    <!--单选框-->
    <link href="{{ asset('css/back/plugins/checkbox/checkbox.css') }}" rel="stylesheet">
    <!--弹出框-->
    <link href="{{ asset('css/back/plugins/alert/sweetalert.css') }}" rel="stylesheet">
    <!-- Mainly scripts -->
    <script type="text/javascript" src="{{ asset('js/back/jquery-2.1.1.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/bootstrap-3.3.7/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/back/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/back/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script type="text/javascript" src="{{ asset('js/back/inspinia.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/back/plugins/pace/pace.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/back/plugins/validate/jquery.validate.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/back/plugins.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/bootstrap-3.3.7/js/bootstrap-select.js') }}"></script>
    <!--弹出框-->
    <script type="text/javascript" src="{{ asset('js/back/plugins/alert/sweetalert.min.js') }}"></script>
    <!-- End Mainly scripts -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>


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
                                <i class="fa fa-tripadvisor fa-3x" aria-hidden="true"></i>
                            </div>
                            <span class="text-center block m-t-xs">
                                <strong class="font-bold">欢迎小主 {{$userInfo['info']->nick_name}}</strong>
                            </span>
                        </a>
                    </div>
                    <div class="logo-element"><i class="fa fa-tripadvisor" aria-hidden="true"></i></div>
                </li>

                @foreach ($menu as $value)
                    @if(!isset($value->menu))
                        <li @if(ucwords($value->controller_name).'Controller' == $controller_name) class="active" @endif>
                            <a href="{{ url($value->url) }}">
                                @if ($value->icon_class)<i class="fa {{$value->icon_class}}"></i> @endif
                                <span class="nav-label">{{$value->nav_name}}</span>
                            </a>
                        </li>
                    @else
                    <li @if($breadcrumb[0]['action_name'] == $action_name) class="active" @endif>
                        <a href="#">
                            @if ($value->icon_class)<i class="fa {{$value->icon_class}}"></i> @endif
                            <span class="nav-label">{{$value->nav_name}}</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse @if($breadcrumb[0]['controller_name'] == $action_name) in @endif ">
                            @foreach ($value->menu as $menu_value)
                                <li @if($breadcrumb[0]['action_name'] == $action_name) class="active" @endif>
                                    <a href="{{url($menu_value->url)}}">
                                        @if ($menu_value->icon_class)<i class="fa {{$menu_value->icon_class}}"></i> @endif
                                        {{$menu_value->nav_name}}
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

                    <a class="navbar-minimalize pull-left m-t-md m-l-md" href="#"><i class="fa fa-dedent fa-lg text-muted"></i> </a>
                    <form role="search" class="navbar-form-custom" action="search_results.html">
                        <div class="form-group">
                            <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                        </div>
                    </form>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <a href="{{url('back/logout')}}">
                            <i class="fa fa-sign-out fa-lg"></i>Log out
                        </a>
                    </li>
                </ul>

            </nav>
        </div>

        <!--面包屑-->
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-9">
                <h2></h2>
                <ol class="breadcrumb">
                    <li><a href="/back"><i class="fa fa-tripadvisor fa-lg text-navy" aria-hidden="true"></i></a></li>
                    @foreach ($breadcrumb as $value)
                        @if(empty($value['url']))
                            <li>{{$value['nav_name']}}</li>
                        @else
                            <li class="active"><a href="{{url($value['url'])}}"><b>{{$value['nav_name']}}</b></a></li>
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
