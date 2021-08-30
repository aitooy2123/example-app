<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TCEP - Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('ico/logo.ico') }}" />
    @include('layouts.css')

    <style>
        body {
            background-image: url('{{ asset('images/Laravel_onlineWorkshop.jpeg') }}');
            background-repeat: no-repeat;
            background-size: 100% 100%;
        }
    </style>

</head>

<body class="hold-transition login-page">

    <div class="login-box shadow">
        <!-- <div class="login-logo">
      <img src="{{ asset('graphic/Main/PNG/img_login_logo.png') }}" width="250">
    </div> -->
        <!-- /.login-logo -->
        <div class="card rounded">
            <div class="card-body login-card-body rounded">
                <p class="login-box-msg h5">Example-App : Login</p>

                @if(session()->has('Register'))
                <div class="alert alert-success" id="success-alert">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                    <strong>ลงทะเบียนสำเร็จ !</strong> โปรดลงชื่อเข้าใช้งาน
                </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="input-group mb-3">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="ชื่อผู้ใช้งาน" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-user-alt"></i>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <!-- <input type="password" class="form-control text-lg" placeholder="รหัสผ่าน"> -->
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="รหัสผ่าน" required autocomplete="current-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>


                    <div class="social-auth-links text-center mb-3">
                        <button type="submit" class="btn btn-block bg-blue text-lg">{{ __('เข้าสู่ระบบ') }}</button>
                        <a href="{{ route('password.request') }}">ลืมรหัสผ่าน</a>
                        <p>---------------- หรือ ----------------</p>
                        <a href="{{ route('register') }}" class="btn btn-block bg-pink text-lg ">ลงทะเบียน</a>
                    </div>
                    <!-- /.social-auth-links -->
                </form>

            </div>
            <!-- /.login-card-body -->
        </div>
    </div>

    <footer class="text-center">
        <div class="text-center pt-3 text-white h5">ⓒ กรมควบคุมโรค</div>
    </footer>

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
</body>

</html>