<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password</title>
    <link rel="icon" href="{{ URL::asset('images/favicon.ico') }}" type="image/ico"/>
    <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/animate.min.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ URL::asset('css/custom.min.css') }}" rel="stylesheet">
    <!-- Custom Your Style -->
    <link href="{{ URL::asset('css/style.min.css') }}" rel="stylesheet">
</head>

<body class="login">
<div>
    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <form method="post" action="{{ route('password.request') }}">
                    {{ csrf_field() }}
                    <h1>Form</h1>
                    <div>
                        <input name="email" type="text" class="form-control" placeholder="Email" required="" value="{{ old('email') }}"/>
                        @if ($errors->has('email'))
                            <span class="help-block error">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div>
                        <input name="password" type="password" class="form-control" placeholder="Password" required="" value="{{ old('password') }}"/>
                        @if ($errors->has('password'))
                            <span class="help-block error">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div>
                        <input name="password_confirmation" type="password" class="form-control" placeholder="Confirm Password" required="" value="{{ old('password') }}"/>
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block error">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div>
                        <button class="btn btn-default submit" type="submit">Reset Password</button>
                    </div>
                    <div class="clearfix"></div>
                    <div class="separator">
                        <div class="clearfix"></div>
                        <br/>
                        <div>
                            <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                            <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
</body>
</html>
