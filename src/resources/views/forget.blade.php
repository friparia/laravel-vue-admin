<!DOCTYPE html>
<html>
<head>
    <!-- Standard Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <!-- Site Properties -->
    <title>忘记密码</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/ionicons.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/AdminLTE.min.css') }}">
    <script type="text/javascript" src="{{ asset('/js/jquery-1.10.2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/app.min.js') }}"></script>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <b>忘记密码</b>
    </div>
    <div class="login-box-body">
        @if (session('error'))
            <div class="alert alert-info">{{ session('error') }}</div>
        @endif
        <form action="/admin/auth/change-password" method="POST">
            {{ csrf_field() }}
            <div class="input-group form-group">
                <input type="text" id="name" name="name" class="form-control" placeholder="用户名">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-info btn-flat" id="captcha">获取验证码</button>
                </span>
            </div>
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="验证码" name="captcha">
                <span class="glyphicon glyphicon-cloud form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="密码" name="password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="再次输入密码" name="password-confirm">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                </div>
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">修改</button>
                </div>
            </div>
        </form>
            <a href="/admin/auth/login"><<返回登录</a>
    </div>
</div>
<script>
    $(function(){
        $('#captcha').on('click', function() {
            if (!$(this).hasClass('disabled')) {
                flag = true;
                $that = $(this);
                $that.html(120);
                $that.addClass('disabled');
                $.get('/admin/auth/captcha/' + $('#name').val(), function (data) {
                });
            }
        })
    });
    var flag = false;
    setInterval(function() {
        if (flag) {
            if ($('#captcha').html() == '1') {
                flag = false;
                $('#captcha').removeClass('disabled');
                $('#captcha').html("获取验证码");
            } else {
                $('#captcha').html($('#captcha').html() - 1);
            }
        }
    }, 1000)
</script>
</body>

