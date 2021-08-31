<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Example : @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('ico/logo.ico') }}" />

    @include('layouts.css')
    @yield('custom-css-script')
    @yield('custom-css')
</head>

<body class="hold-transition sidebar-mini layout-fixed ">
    <div class="wrapper">
        @include('layouts.navbar')
        @include('layouts.sidebar')
        @yield('content')
        @include('layouts.footer')
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    @include('layouts.js')
    @yield('custom-js-script')
    @yield('custom-js')
</body>

</html>