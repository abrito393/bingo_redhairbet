<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bingo</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{!! asset('admin/img/logo1.ico') !!}"/>

    <!--global styles-->
    <link rel="stylesheet" href="{!! asset('admin/css/components.css') !!}" />
    <link rel="stylesheet" href="{!! asset('admin/css/custom.css') !!}" />
    <!-- end of global styles-->
    <link rel="stylesheet" href="#" id="skin_change" />

</head>

<body>
<div class="preloader" style=" position: fixed;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  z-index: 100000;
  backface-visibility: hidden;
  background: #ffffff;">
    <div class="preloader_img" style="width: 200px;
  height: 200px;
  position: absolute;
  left: 48%;
  top: 48%;
  background-position: center;
z-index: 999999">
        <img src="{!! asset('admin/img/loader.gif') !!}" style=" width: 40px;" alt="loading...">
    </div>
</div>
<div id="wrap">
    <div id="top">
        <!-- .navbar -->
        <nav class="navbar navbar-static-top">
            <div class="container-fluid m-0">
                <a class="navbar-brand mr-0" href="index.html">
                    <h4 class="text-white"> Bingo RedHairBet</h4>
                </a>
                <div class="menu mr-sm-auto">
                        <span class="toggle-left" id="menu-toggle">
                        <i class="fa fa-bars text-white"></i>
                    </span>
                </div>

                <div class="topnav dropdown-menu-right ml-auto">
                    <div class="btn-group">
                        <div class="user-settings no-bg">
                            <button type="button" class="btn btn-default no-bg micheal_btn" data-toggle="dropdown">
                                <img src="{!! asset('admin/img/admin.jpg') !!}" class="admin_img2 rounded-circle avatar-img" alt="avatar"> <strong>Aquiles</strong>
                                <span class="fa fa-sort-down white_bg"></span>
                            </button>
                            <div class="dropdown-menu admire_admin">
                                <div class="popover-header">Opciones</div>
                                <a class="dropdown-item" href="#"><i class="fa fa-cogs"></i>
                                    Account Settings</a>
                                <a class="dropdown-item" href="#">
                                    <i class="fa fa-user"></i> User Status
                                </a>
                                <a class="dropdown-item" href="#"><i class="fa fa-envelope"></i>
                                    Inbox</a>
                                <a class="dropdown-item" href="#"><i class="fa fa-lock"></i>
                                    Lock Screen</a>
                                <a class="dropdown-item" href="#"><i class="fa fa-sign-out"></i>
                                    Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </nav>
        <!-- /.navbar -->
        <!-- /.head -->
    </div>
    <!-- /#top -->
    <div class="wrapper">
        <div id="left">
            <div class="menu_scroll">
                <div class="media user-media">
                    <div class="user-media-toggleHover">
                        <span class="fa fa-user"></span>
                    </div>
                    <div class="user-wrapper">
                        <a class="user-link" href="">
                            <img class="media-object img-thumbnail user-img rounded-circle admin_img3" alt="User Picture" src="{!! asset('admin/img/admin.jpg') !!}">
                            <p class="text-white user-info">Usuario</p>
                        </a>
                    </div>
                </div>
                <!-- #menu -->
                <ul id="menu">
                    @include('template.nav_bar')

                </ul>
                <!-- /#menu -->
            </div>
        </div>
        <!-- /#left -->
        <div id="content" class="bg-container">
            <header class="head">
                <div class="main-bar">
                    <div class="row">
                        <div class="col-12" align="center">
                            <h4 class="m-t-5">
                                <i class="fa fa-home"></i>
                                @yield('name_seccion')
                            </h4>
                        </div>
                    </div>
                </div>
            </header>

            <!--contenido principal-->
            <div class="outer">
                <div class="inner bg-container">
                    @yield('contend')
                </div>
            </div>
            <!-- /#content -->
        </div>
    </div>
    <!--wrapper-->
    <!-- # right side -->
</div>
<!-- /#wrap -->
<!-- global scripts-->
<script src="{!! asset('admin/js/components.js') !!}"></script>
<script src="{!! asset('admin/js/custom.js') !!}"></script>
@yield('codejs')
</body>
</html>
