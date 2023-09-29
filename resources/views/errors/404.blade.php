<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>{{ Helper::config('company_name') }}</title>
  <link rel="icon" type="image/png" href="{{ asset('uploads/brand/' . Helper::config('favicon')) }}"/>

  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/font/bootstrap-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('css/theme.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/theme-style.css') }}">
</head>

<body class="d-flex flex-column justify-content-center align-items-center h-100">
  <!-- ========== HEADER ========== -->
  <header id="header" class="navbar navbar-height navbar-light navbar-absolute-top bg-white mt-2">
    <div class="container">
        <a class="navbar-brand mx-auto" href="{{ url('/') }}" aria-label="Unify">
            @if (Helper::config('logo'))
                <img class="navbar-brand-logo" src="{{ asset('uploads/brand/' . Helper::config('logo')) }}">
            @else
                <h5 class="text-dark mb-0 ps-3 border-dashed mt-2">{{ __('Upload Logo') }}</h5>  
            @endif
        </a>
    </div>
  </header>
  <!-- ========== END HEADER ========== -->

  <!-- ========== MAIN CONTENT ========== -->
  <main id="content" role="main">
    <!-- Content -->
    <div class="container text-center">
      <div class="mb-4">
        <h1 class="display-1">{{ __('404') }}</h1>
        <h3 class="mb-1">{{ __('Something went wrong') }}</h3>
        <p>{{ __('The page you are looking for does not exist!') }}</p>
      </div>
      <a class="btn btn-dark" href="{{ url('/') }}">{{ __('Go back home') }}</a>
    </div>
    <!-- End Content -->
  </main>
  <!-- ========== END MAIN CONTENT ========== -->

  <!-- ========== FOOTER ========== -->
  <div class="position-absolute bottom-0 start-0 end-0">
    <footer class="container py-4">
      <div class="row align-items-md-center text-center text-md-start">
        <div class="col-md mb-3 mb-md-0">
          <p class="fs-5 mb-0">© {{ Helper::config('company_name') }}. {{ date('Y') }}.</p>
        </div>
      </div>
    </footer>
  </div>
  <!-- ========== END FOOTER ========== -->

  <!-- JS  -->
  <script src="./frontend/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./frontend/js/theme.min.js"></script>
</body>
</html>
