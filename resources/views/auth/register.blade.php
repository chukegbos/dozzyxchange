<!DOCTYPE html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Register - {{ $setting->sitename }}</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Favicon -->
        <meta name="csrf-token" content="{{ csrf_token() }}">  
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('account/img/favicon.png') }}">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('account/css/bootstrap.min.css') }}">
        <!-- Fontawesome CSS -->
        <link rel="stylesheet" href="{{ asset('account/css/fontawesome-all.min.css') }}">
        <!-- Flaticon CSS -->
        <link rel="stylesheet" href="{{ asset('account/font/flaticon.css') }}">
        <!-- Google Web Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;display=swap" rel="stylesheet">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="{{ asset('account/style.css') }}">
    </head>

    <body>
        <section class="fxt-template-animation fxt-template-layout1">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-12 fxt-bg-color">
                        <div class="fxt-content">
                            <div class="fxt-header">
                                <a href="{{ url('/') }}">
                                    <img src="{{ asset('account/img/logo-1.png') }}" alt="Logo" class="img-fluid img-responsive">
                                </a>
                            </div>
                            <div class="fxt-form">
                                <h2>Register</h2>     
                                <p>Welcome, Let's get to know you </p>
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="form-group">
                                        <div class="fxt-transformY-50 fxt-transition-delay-1">
                                            <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus placeholder="Your Username">

                                            @if ($errors->has('username'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('username') }}</strong>
                                                </span>
                                            @endif
                                            <i class="flaticon-user"></i>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="fxt-transformY-50 fxt-transition-delay-1">
                                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter Email">

                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                            <i class="flaticon-envelope"></i>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="fxt-transformY-50 fxt-transition-delay-2">
                                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Enter Password">

                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                            <i class="flaticon-padlock"></i>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="fxt-transformY-50 fxt-transition-delay-2">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirm Password">
                                            <i class="flaticon-padlock"></i>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="fxt-transformY-50 fxt-transition-delay-3">
                                            <div class="fxt-content-between">
                                                <button type="submit" class="fxt-btn-fill">Log in</button>
                                                <a href="{{ route('login') }}" class="switcher-text1 active">Already have an account? Click here to login.</a>

                                            </div>
                                        </div>
                                    </div>
                                </form>                            
                            </div> 
                            <div class="fxt-footer">
                                <ul class="fxt-socials">
                                    <li class="fxt-facebook fxt-transformY-50 fxt-transition-delay-4">
                                        <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                                    </li>
                                    <li class="fxt-twitter fxt-transformY-50 fxt-transition-delay-5">
                                        <a href="#" title="twitter"><i class="fab fa-twitter"></i></a>
                                    </li>
                                    <li class="fxt-google fxt-transformY-50 fxt-transition-delay-6">
                                        <a href="#" title="google"><i class="fab fa-google-plus-g"></i></a>
                                    </li>
                                    <li class="fxt-linkedin fxt-transformY-50 fxt-transition-delay-7">
                                        <a href="#" title="linkedin"><i class="fab fa-linkedin-in"></i></a>
                                    </li>
                                    <li class="fxt-pinterest fxt-transformY-50 fxt-transition-delay-8">
                                        <a href="#" title="pinterest"><i class="fab fa-pinterest-p"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 fxt-none-767 fxt-bg-img" data-bg-image="{{ asset('account/img/figure/bg1-l.jpg') }}"></div>
                </div>
            </div>
        </section>
        <!-- jquery-->
        <script src="{{ asset('account/js/jquery-3.5.0.min.js') }}"></script>
        <!-- Popper js -->
        <script src="{{ asset('account/js/popper.min.js') }}"></script>
        <!-- Bootstrap js -->
        <script src="{{ asset('account/js/bootstrap.min.js') }}"></script>
        <!-- Imagesloaded js -->
        <script src="{{ asset('account/js/imagesloaded.pkgd.min.js') }}"></script>    
        <!-- Validator js -->
        <script src="{{ asset('account/js/validator.min.js') }}"></script>
        <!-- Custom Js -->
        <script src="{{ asset('account/js/main.js') }}"></script>
    </body>
</html>