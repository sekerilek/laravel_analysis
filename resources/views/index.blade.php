<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>CANARY</title>
    <script src="{{ asset('vendors/jquery/dist/jquery.js')}}"></script>

    <!-- Bootstrap -->
    <link href="{{ asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- Datatables -->
    <link href="{{ asset('css/datatables.min.css')}}" rel="stylesheet">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('vendors/select2/dist/css/select2.min.css')}}">
    <!-- Custom Theme Style -->
    <link href="{{ asset('/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ url('css/custom.min.css') }}" rel="stylesheet">

    @yield('styles')
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col menu_fixed">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="{{ url('/home') }}" class="site_title"><i class="fa fa-paw"></i> <span>CANARY</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="{{ url('img/img.jpg') }}" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2>{{ Auth::user()->fullname }}</h2>
                        </div>
                    </div>

                    @include('layouts.sidebar')

                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <nav>
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('img/img.jpg')}}" alt="">{{ Auth::user()->fullname }}
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-user menu pull-right">
                                    <li>
                                        <a class="dropdown-item" href="{{ url('/user/change/' . Auth::user()->name )}}">
                                            <i class="fa fa-key" aria-hidden="true"></i> Ubah Password
                                        </a>
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <i class="fa fa-sign-out" aria-hidden="true"></i> Keluar
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->

            <!-- page content -->

            <div class="right_col">

                <br><br><br><br>
                <!-- Alert -->
                @if(session()->get('changepassword'))
                <div class="alert alert-success alert-dismissible fade-show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ session()->get('changepassword') }}
                </div>
                @endif

                @yield('content')
            </div>
            <!-- /page content -->
        </div>
    </div>
    <footer>
        <div class="pull-right">
            © DNIZ-TECHNO
        </div>
        <div class="clearfix"></div>
    </footer>

    <script src="{{ asset('js/datatables.min.js')}}"></script>
    <script src="{{ asset('vendors/select2/dist/js/select2.min.js')}}" charset="utf-8"></script>
    <script src="{{ asset('vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/moment/min/moment.min.js')}}"></script>
    <!-- bootstrap-datetimepicker -->
    <script src="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{ asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ asset('js/custom.min.js') }}"></script>

    <!-- App scripts -->
    @stack('scripts')
</body>

</html>