<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <title>
            @hasSection('title')
            @yield('title')管理 - ProjectName
    @else
            ProjectName
    @endif
        </title>
        <link href="{{ asset('plugins/chartist/chartist.css') }}" rel="stylesheet" />
        <link href="{{ asset('plugins/datepicker/css/bootstrap-datepicker3.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/semantic.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/main.css') }}" rel="stylesheet" />
        <link href="{{ asset('plugins/pacejs/pace.css') }}" rel="stylesheet" />
        <script src="{{ asset('js/jquery-2.1.4.min.js') }}"></script>
    </head>
    <body class="admin">
        <div class="ui vertical push sidebar menu thin" id="toc">
            @foreach(config('menu') as $menu)
                @if(isset($menu['submenus']) && !empty($menu['submenus']))
                    <div class="ui accordion">
                        <div class="title">
                            <i class="dropdown icon"></i>
                            {{ $menu['name'] }}
                        </div>
                        @foreach($menu['submenus'] as $submenu)
                            <div class="content">
                                <a class="item" href="{{ $submenu['url'] }}">
                                    {{ $submenu['name'] }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <a class="item" href="{{ $menu['url'] }}">
                        <b>{{ $menu['name'] }}</b>
                    </a>
                @endif
            @endforeach
        </div>
        <div class="mobilenavbar">
        <div class="ui fixed main menu push no-border no-radius sidemenu2 borderless">
            <a class="launch icon item" style="padding-top:20px">
                <i class="content icon"></i>
            </a>
            <div class="right menu">
                <div class="ui dropdown item">
                    Language <i class="dropdown icon"></i>
                    <div class="menu">
                        <a class="item"><i class="united kingdom flag"></i>English</a>
                        <a class="item"><i class="china flag"></i>中文</a>
                    </div>
                </div>
                <div class="ui dropdown item">
                    {{ Auth::user()->username }}
                    <div class="menu">
                        <a class="item" href="/admin/auth/signout">Sign Out</a>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <div class="pusher">
            <div class="full height">
                <div class="toc">
                    <div class="ui visible left vertical sidebar menu no-border sidemenu toc-full-menu">
                        @foreach(config('menu') as $menu)
                            @if(isset($menu['submenus']) && !empty($menu['submenus']))
                            <div class="ui accordion">
                                <div class="title">
                                    <i class="dropdown icon"></i>
                                    {{ $menu['name'] }}
                                </div>
                                @foreach($menu['submenus'] as $submenu)
                                    <div class="content">
                                        <a class="item" href="{{ $submenu['url'] }}">
                                            {{ $submenu['name'] }}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            @else
                                <a class="item" href="{{ $menu['url'] }}">
                                    <b>{{ $menu['name'] }}</b>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="article">
                    <div class="navbarmenu">
                        <div class="ui fixed top  menu no-border no-radius borderless navmenu">
                            <a class="item active no-padding logo" style="width:250px;" href="dashboard.html">

                                <!-- <img class="ui image logoImg" src="img/logo.png" /> -->
                                Project Name
                            </a>
                            <a class="item hamburger" data-name="show">
                                <i class="align justify icon"></i>
                            </a>
                            <div class="right menu">
                                <div class="ui dropdown item">
                                    Language <i class="dropdown icon"></i>
                                    <div class="menu">
                                        <a class="item"><i class="united kingdom flag"></i>English</a>
                                        <a class="item"><i class="china flag"></i>中文</a>
                                    </div>
                                </div>
                                <div class="ui dropdown item">
                                    {{ Auth::user()->username }}
                                    <div class="menu">
                                        <a class="item" href="/admin/auth/signout">Sign Out</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Begin Container-->
                    <div class="containerli">
                        <div class="ui equal width left aligned padded grid stackable">
                            @yield('content')
                        </div>
                    </div>
                    <!--Finish Container-->
                    <!--Load Footer Menu In App.js loadhtml function-->
                    <div class="footer"></div>
                    <!--Load Footer Menu In App.js loadhtml function-->
                </div>
            </div>
        </div>
        <script src="{{ asset('plugins/nicescrool/jquery.nicescroll.min.js') }}"></script>
        <script src="{{ asset('js/semantic.js') }}"></script>
        <script data-pace-options='{ "ajax": false }' src="{{ asset('plugins/pacejs/pace.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
