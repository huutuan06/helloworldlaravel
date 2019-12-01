<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ Config::get('constants.head.title_login') }}</title>
    <link rel="icon" href="{{ URL::asset('images/favicon.ico') }}" type="image/ico"/>
    <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/animate.min.css') }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ URL::asset('css/custom.min.css') }}" rel="stylesheet">
    <!-- Custom Your Style -->
    <link href="{{ URL::asset('css/login.min.css') }}" rel="stylesheet">
</head>

<body class="clear_login">
    <div class="container" onclick="onclick">
        @if (session('status'))
            <p class="alert alert-success">{{ session('status') }}</p>
        @endif
        <form method="post" action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class="top"></div>
            <div class="bottom"></div>
            <div class="center">
                    <h1>VogoBook</h1>
                    <input name="email" type="text" placeholder="Email" required=""/>
                    @if ($errors->has('email'))
                        <span class="help-block error">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                    <input name="password" type="password" placeholder="Password" required=""/>
                    @if ($errors->has('password'))
                        <span class="help-block error">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                    <button class="btn btn-default submit" type="submit">Log in</button>
            </div>
        </form>
    </div>
</body>
</html>
