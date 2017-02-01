<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<title>
    @hasSection('title')
        @yield('title')
    @else
        {{ Config::get('admin.name') }}
    @endif
</title>

<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/ionicons.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/AdminLTE.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap3-wysihtml5.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/daterangepicker.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-switch.min.css') }}">
<script type="text/javascript" src="{{ asset('/js/jquery-1.10.2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/app.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/bootstrap-switch.min.js') }}"></script>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">
    @include('admin::header')

    @include('admin::sidebar')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                @hasSection('title')
                @yield('title')
                @else
                {{ Config::get('admin.name') }}
                @endif
                <small>
                @hasSection('sub_title')
                @yield('sub_title')
                @endif
                </small>
            </h1>
        </section>
        <section class="content">
            @if (session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
                <?php session()->forget('error'); ?>
            @endif
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                    <?php session()->forget('success'); ?>
            @endif
            @yield('content')
        </section>
    </div>

    @include('admin::footer')


</div>
</body>
</html>


