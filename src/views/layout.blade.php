<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title>
    @hasSection('title')
    @yield('title')管理 - ProjectName
    @else
    ProjectName
    @endif
</title>
<link rel="stylesheet" type="text/css" href="{{ asset('css/semantic.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/message.css') }}">
<script type="text/javascript" src="{{ asset('/js/jquery-1.11.2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/semantic.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/jquery.form.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/func.js') }}"></script>
</head>
<body>
<div class="" style="height:100%;display:flex;flex-direction:column;">
    <div class="ui inverted menu top-menu" style="margin-bottom:0;border-radius:0;">
        <a href="#" class="header item">
            <img style="margin-right:1.5em" src="{{ asset('images/logo.png') }}">
            Project Name
        </a>
        <div class="right menu" style="border-radius:0;">
            <div class="ui dropdown item" tabindex="0">
                <i class="user icon"></i>admin                    
                <div class="menu transition hidden" tabindex="-1">
                    <a class="item" href="/admin/auth/logout"><i class="sign out icon"></i>注销</a>
                </div>
            </div>
        </div>
    </div>
    <div style="display:flex;flex:1;">
        <div class="left sidebar" style="background-color:#1b1c1d;">
            <div class="ui inverted vertical visible menu" style="border-radius:0;">
                @foreach (Friparia\Admin\Models\Menu::all() as $menu)
                <a class="item">
                    {{ $menu->name }}
                </a>
                @endforeach
            </div>
        </div>
        <div class="container" style="flex:1;overflow-y:auto;padding-top:40px;padding-left:30px;padding-right:30px;">
            @if (session('error'))
            <div class="error message">
                <h3 style="display:inline;">{{ session('error') }}</h3><i class="close icon message-close" style="float:right;"></i>
            </div>
            @endif
            @if (session('success'))
            <div class="success message">
                <h3 style="display:inline;">{{ session('success') }}</h3><i class="close icon message-close" style="float:right;"></i>
            </div>
            @endif
        <h2 class="ui dividing header">
            @hasSection('title')
            @yield('title')管理 - ProjectName
            @else
            ProjectName
            @endif
        </h2>
        <div class="content">
            @yield('content')
        </div>
    </div>
</div>
<div class="footer"></div>
</div>
<script>
$(function(){
    $('.ui.dropdown').dropdown();
    $('.message-close').click(function(){
        hideAllMessages();
    });
    setTimeout(function(){
        hideAllMessages();
    },10000);
});
</script>
</body>


