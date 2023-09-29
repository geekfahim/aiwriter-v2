<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ Helper::config('company_name') }} - {{ $page_title }}</title>
    <link rel="icon" type="image/png" href="{{ asset('uploads/brand/' . Helper::config('favicon')) }}"/>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css"/>
    
    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/font/bootstrap-icons.css') }}"/>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme-style.css') }}">
    @if (Helper::config('recaptcha_active') == 1)
        {!! RecaptchaV3::initJs() !!} 
    @endif
</head>

<body>
    @include('frontend.layout.navbar')
    @yield('content')
    @include('frontend.layout.footer')

    <!-- JS Global Compulsory  -->
    <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

    <!-- JS -->
    <script src="{{ asset('js/theme.min.js') }}"></script>
    <script src="{{ asset('js/theme-custom.js') }}"></script>
</body>
</html>