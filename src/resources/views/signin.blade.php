<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <title>
            Admin Login
        </title>
        <link href="{{ asset('css/semantic.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/main.css') }}" rel="stylesheet" />
    </head>
    <body class="signin">
        <div class="ui container">
            <div class="ui equal width center aligned padded grid stackable">
                <div class="row">
                    <div class="five wide column">
                        <div class="ui segments">
                            <div class="ui segment inverted nightli">
                                <h3 class="ui header">
                                    Admin Login
                                </h3>
                            </div>
                            <div class="ui segment">
                                <form method="POST" action="/admin/auth/signin">
                                    {{ csrf_field() }}
                                    <div class="ui divider"></div>
                                    <div class="ui input fluid">
                                        <input type="text" placeholder="Your Email..." name="username">
                                    </div>
                                    <div class="ui divider hidden"></div>
                                    <div class="ui input fluid">
                                        <input type="text" placeholder="Your Password..." name="password">
                                    </div>
                                    <div class="ui divider hidden"></div>

                                    <div class="g-recaptcha" data-sitekey="6LeR3xkTAAAAAKFv-HT60HvhrqHGMfQYHup1JFI2"></div>
                                    <div class="ui divider hidden"></div>
                                    <button class="ui primary fluid button">
                                        <i class="key icon"></i>
                                        Sign In
                                    </button>
                                    <div class="ui divider hidden"></div>
                                    <a href="forgotpassword.html" class="ui">I Forgot Password?</a>
                                </form>
                            </div>
                            @if (session('error'))
                                <div class="ui bottom attached red message">
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
