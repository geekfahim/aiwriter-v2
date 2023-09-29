<!-- ========== HEADER ========== -->
<header id="header" class="navbar navbar-expand-lg navbar-light bg-white">
<div class="container">
  <nav class="js-mega-menu navbar-nav-wrap">
      <!-- Default Logo -->
      <a class="navbar-brand" href="{{ url('/') }}" aria-label="Unify">
          @if (Helper::config('logo'))
              <img class="navbar-brand-logo" src="{{ asset('uploads/brand/' . Helper::config('logo')) }}">
          @else
              <h5 class="text-dark mb-0 ps-3 placeholder-logo">{{ __('Upload Logo') }}</h5>  
          @endif
      </a>
      <!-- End Default Logo -->

      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-default">
              <i class="bi-list"></i>
          </span>
          <span class="navbar-toggler-toggled">
              <i class="bi-x"></i>
          </span>
      </button>
      <!-- End Toggler -->
  
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav nav-pills">

          <li class="hs-has-mega-menu nav-item">
              <a class="hs-mega-menu-invoker nav-link" href="{{ url('pricing') }}" role="button" aria-expanded="false">{{ __('Pricing') }}</a>
          </li>
          
          <li class="hs-has-mega-menu nav-item">
              <a class="hs-mega-menu-invoker nav-link" href="{{ url('contact-us') }}" role="button" aria-expanded="false">{{ __('Contact Us') }}</a>
          </li>

          <!-- Log in -->
          <li class="nav-item ms-lg-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle bg-grey-light" href="#" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="fi fi-{{Config::get('languages')[App::getLocale()]['flag-icon']}} me-2"></span> {{ Config::get('languages')[App::getLocale()]['display'] }}
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                @foreach (Config::get('languages') as $lang => $language)
                    @if ($lang != App::getLocale())
                            <a class="dropdown-item" href="{{ route('lang.switch', $lang) }}"><span class="fi fi-{{$language['flag-icon']}}"></span> {{$language['display']}}</a>
                    @endif
                @endforeach
                </div>
            </li>
            <a class="btn btn-ghost-dark me-2 me-lg-0" href="{{ url('login') }}">{{ __('Log in') }}</a>
            <a class="btn btn-dark d-lg-none" href="{{ url('signup') }}">{{ __('Get Started ― It\'s Free') }}</a>
          </li>
          <!-- End Log in -->

          <!-- Sign up -->
          <li class="nav-item">
          <a class="btn btn-dark d-none d-lg-inline-block" href="{{ url('signup') }}">{{ __('Get Started ― It\'s Free') }}</a>
          </li>
          <!-- End Sign up -->
      </ul>
      </div>
      <!-- End Collapse -->
  </nav>
</div>
</header>
<!-- ========== END HEADER ========== -->