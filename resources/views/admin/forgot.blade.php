<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Title -->
  <title>{{ __('auth.forgot_password') }}</title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('uploads/brand/' . Helper::config('favicon')) }}"/>

  <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme-style.css') }}">
    @if (Helper::config('recaptcha_active') == 1)
        {!! RecaptchaV3::initJs() !!} 
    @endif
</head>
<body class="bg-pattern">
  <div class="container">
    <div class="mx-lg-auto max-width-55">
      <div class="d-flex justify-content-center align-items-center flex-column min-vh-lg-100">
        <div class="position-relative">
          <div class="card card-shadow card-login">
            <div class="row">
              <div class="col-md-4 d-md-flex justify-content-center flex-column bg-soft-primary p-8 p-md-5 bg-pattern">
                <h3 class="mb-4">{{ __('auth.forgot_password') }}</h3>
                <small class="mb-4">{{ __('auth.enter_your_email_to_reset_password') }}</small>
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <form class="js-validate needs-validation" novalidate="">
                    @csrf
                    <div>
                      <label class="form-label" for="resetPasswordSrEmail" tabindex="0">{{ __('auth.email') }}</label>
                      <input type="email" class="form-control form-control-lg" name="email" id="resetPasswordSrEmail" tabindex="1" placeholder="{{ __('email@address.com') }}" required="">
                      <span class="invalid-feedback">{{ __('auth.valid_email') }}</span>
                    </div>
                    @if (Helper::config('recaptcha_active') == 1)
                        {!! RecaptchaV3::field('forgotPassword') !!}
                        <span class="invalid-feedback">{{ __('Oops! Recaptcha failed. Please refresh and try again.') }}</span>
                    @endif
                    <div class="d-grid gap-4 mt-4">
                      <button type="submit" class="btn btn-dark btn-lg" data-message="{{ __('auth.reset_link_sent') }}">{{ __('auth.reset_password') }}</button>
                      <p class="card-text text-muted">{{ __('auth.remember_your_password?') }} <a class="link text-dark" href="{{ url('admin/login') }}">{{ __('auth.sign_in') }}</a></p>
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
  <!-- JS Global Compulsory  -->
  <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/hs-toggle-password/dist/js/hs-toggle-password.js') }}"></script>
  <script src="{{ asset('js/theme.min.js') }}"></script>
  <script src="{{ asset('js/theme-custom.js') }}"></script>
</body>
</html>