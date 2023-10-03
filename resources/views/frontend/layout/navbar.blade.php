<nav class="navbar navbar-expand-lg fixed-top light" id="nav-megamenu-logo-menu" style="">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-3 hidden-lg">
                <button aria-controls="navbarMenuContent" aria-expanded="false" aria-label="Toggle navigation"
                        class="navbar-toggler collapsed" data-target=".main-menu-collapse" data-toggle="collapse"
                        style="" type="button"><span class="icon-bar"></span><span
                        class="icon-bar"></span><span class="icon-bar"></span></button>
            </div>
            <div class="col-6 col-lg-2 order-lg-2 text-center">
                <!-- Default Logo -->
                <a class="navbar-brand" href="{{ url('/') }}" aria-label="Unify">
                    @if (Helper::config('logo'))
                        <img class="mw-100" height="50"  src="{{ asset('uploads/brand/' . Helper::config('logo')) }}">
                    @else
                        <img class="mw-100" height="50"  src="{{asset('images/logo.png')}}">
                    @endif
                </a>
                <!-- End Default Logo -->
            </div>
            <div class="col-lg-5 order-lg-1 collapse navbar-collapse main-menu-collapse position-inherit">
                <ul class="navbar-nav" style="">

                    <li class="nav-item">
                        <a class="nav-link smooth" href="{{url('/')}}" style="" target="_self">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link smooth" href="{{url('custom-prompt')}}" style=""
                           target="_self">Custom prompts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link smooth" href="{{url('ai-writer')}}" style=""
                           target="_self">Ai Writer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link smooth" href="{{url('contact-us')}}" style=""
                           target="_self">Contact</a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-5 order-lg-3 collapse navbar-collapse main-menu-collapse justify-content-lg-end">
                <ul class="navbar-nav" style="">
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('login')}}">Log in</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('signup')}}" style="">Get started - it's free</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="bg-wrap">
        <div class="bg"></div>
    </div>
</nav>


<!-- ========== HEADER ========== -->
<header id="header" class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container">
        <nav class="js-mega-menu navbar-nav-wrap">
            <!-- Default Logo -->

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
        </nav>
    </div>
</header>
<!-- ========== END HEADER ========== -->
