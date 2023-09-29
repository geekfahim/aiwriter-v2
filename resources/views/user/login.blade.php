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
    @if (Helper::config('recaptcha_active') == 1)
        {!! RecaptchaV3::initJs() !!} 
    @endif
</head>

<body>
    <div class="container">
        <div class="mx-lg-auto max-width-55">
            <div class="d-flex justify-content-center align-items-center flex-column min-vh-lg-100">
                <div class="position-relative">
                    <div class="card card-shadow card-login">
                        <div class="row">
                            <div class="col-md-4 d-md-flex justify-content-center flex-column bg-soft-primary p-8 p-md-5 bg-pattern">
                                <h3 class="mb-4">{{ __('auth.login_or_create_account') }}</h3>
                                <small class="mb-4">{{ __('auth.enter_your_email_and_password') }}</small>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <form class="js-validate needs-validation js-submit" novalidate>
                                        @csrf
                                        <div class="d-flex justify-content-center">
                                            @if ($google_active == 1)
                                            <a class="btn btn-white btn-lg {{ $google_active == 1 && $facebook_active == 0 ? 'w-100' : '' }} d-grid mb-4" href="{{ url('google/login') }}">
                                                <span class="d-flex justify-content-center align-items-center">
                                                <img class="avatar avatar-xss me-2" src="./images/socials/google-icon.svg" alt="{{ __('auth.google_login') }}">
                                                {{ __('auth.google_login') }}
                                                </span>
                                            </a>
                                            @endif
                                            @if ($facebook_active == 1)
                                            <a class="btn btn-white btn-lg {{ $facebook_active == 1 && $google_active == 0 ? 'w-100' : '' }} d-grid mb-4 ms-3" href="{{ url('facebook/login') }}">
                                                <span class="d-flex justify-content-center align-items-center">
                                                <img class="avatar avatar-xss me-2" src="./images/socials/facebook.png" alt="{{ __('auth.facebook_login') }}">
                                                {{ __('auth.facebook_login') }}
                                                </span>
                                            </a>
                                            @endif
                                        </div>
                                        @if ($google_active == 1 || $facebook_active == 1)
                                        <span class="divider-center text-muted mb-4">{{ __('auth.or') }}</span>
                                        @endif
                                        <div class="mb-4">
                                            <label class="form-label" for="signinSrEmail">{{ __('auth.email') }}</label>
                                            <input type="email" class="form-control form-control-lg" name="email" id="signinSrEmail" tabindex="1" placeholder="email@address.com" aria-label="email@address.com" required>
                                            <span class="invalid-feedback">{{ __('auth.valid_email') }}</span>
                                        </div>
                                        <div>
                                            <label class="form-label" for="signupSrPassword" tabindex="0">{{ __('auth.password') }}</label>
                                            <div class="input-group-merge">
                                                <input type="password" class="js-toggle-password form-control form-control-lg" name="password" id="signupSrPassword" placeholder="{{ __('auth.required_characters') }}" required minlength="8"
                                                    data-hs-toggle-password-options='{
                                                    "target": "#changePassTarget",
                                                    "defaultClass": "bi-eye-slash",
                                                    "showClass": "bi-eye",
                                                    "classChangeTarget": "#changePassIcon"
                                                    }'>
                                                <a id="changePassTarget" class="input-group-append input-group-text" href="javascript:;">
                                                    <i id="changePassIcon" class="bi-eye"></i>
                                                </a>
                                                <span class="invalid-feedback">{{ __('auth.valid_password') }}</span>
                                            </div>
                                        </div>
                                        @if (Helper::config('recaptcha_active') == 1)
                                            {!! RecaptchaV3::field('login') !!}
                                            <span class="invalid-feedback">{{ __('Oops! Recaptcha failed. Please refresh and try again.') }}</span>
                                        @endif
                                        <div class="d-flex mt-4">
                                            <a class="form-label-link text-dark" href="{{ url('forgot-password') }}">{{ __('auth.forgot_password?') }}</a>
                                        </div>
                                        <div class="d-grid gap-4">
                                            <button type="submit" class="btn btn-dark btn-lg">
                                                <span>{{ __('auth.sign_in') }}</span>
                                            </button>
                                            <p class="card-text text-muted">{{ __('auth.don\'t_have_an_account?') }} <a class="link text-dark" href="{{ url('signup') }}">{{ __('auth.signup') }}</a></p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <figure class="position-absolute top-0 end-0 zi-n1 d-none d-sm-block mt-n7 me-n10 width-4rem">
                        <img class="img-fluid" src="{{ asset('images/svg/components/pointer-up.svg') }}" alt="Image Description">
                    </figure>
                    <figure class="position-absolute bottom-0 start-0 d-none d-sm-block ms-n10 mb-n10 width-15rem">
                        <img class="img-fluid" src="{{ asset('images/svg/components/curved-shape.svg') }}" alt="Image Description">
                    </figure>
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