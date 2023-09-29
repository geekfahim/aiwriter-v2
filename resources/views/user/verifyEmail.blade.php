<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>{{ __('auth.login') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('uploads/brand/' . Helper::config('favicon')) }}"/>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/font/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme-style.css') }}">
</head>

<body class="bg-grey-light">
    <div class="container h-100">
        <div class="d-flex justify-content-center align-items-center flex-column min-vh-lg-100">
            <div class="card card-shadow">
                <div class="card-body">
                    <div class="text-center">
                        <h4>{{ __('Verify Your Email') }}</h4>
                        <p>{{ __('You will need to verify your email address to proceed.') }}</p>
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="{{ url('images/svg/components/email-verification.svg') }}" alt="">
                        </div>
                        <small>{{ __('We\'ve sent you a verification link to the following email address') }} {{ auth()->user()->email }}. <br>{{ __('If you have not received the email after a few minutes, please check your spam folder.') }}</small>
                        <br>
                        <button class="btn btn-dark btn-sm mt-4 resend-email" id="resend-email-btn" data-loading="{{ __('Sending email') }}" data-loaded="{{ __('Email Sent, Resend Again') }}" data-url="{{ url('resend-verification-email') }}">{{ __('Resend Email') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- JS -->
    <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/hs-toggle-password/dist/js/hs-toggle-password.js') }}"></script>
    <script src="{{ asset('js/theme.min.js') }}"></script>
    <script src="{{ asset('js/theme-custom.js') }}"></script>
</body>
</html>