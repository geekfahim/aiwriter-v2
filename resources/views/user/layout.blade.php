<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ Helper::config('company_name') }}</title>
    <meta name="subscription" content="{{ Helper::generate_more_words() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('uploads/brand/' . Helper::config('favicon')) }}"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css"/>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme-style.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.css') }}"/>
    <style>
        .trial_mode{
            position: fixed;
            top:0px!important;
            z-index: 999;
        }            
        @media only screen and (max-width: 600px) {
            .trial_mode{
                position: relative;
                top:0px!important;
                z-index: 999;
            }            
        }
    </style>
    <!-- JS -->
    <script src="{{ asset('vendor/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
</head>
<body class="navbar-sidebar-aside-lg">
    <main id="content" role="main">
        <!-- Navbar -->
        <div id="sidebar">
            @include('user.sidebar')
        </div>
        @if (Helper::is_trial_mode())
        <div class="trial_mode p-2 bg-dark end-0">
            <a href="{{ url('billing') }}" class="small text-white mb-0 ps-3 pe-3">{{ __('You are currently in trial period. Select a plan before your trial ends in') }} {{ Helper::getTrialDays() }} {{ __('days') }}</a>
        </div>
        @endif
        <!-- End Navbar -->
        @yield('content')
        <div class="js-modal-container"></div>
    </main>

    <div class="d-block d-md-none mt-4">
        <div class="container text-center fixed-footer {{ Request::segment(1) == 'chat' ? '' : 'shadow-footer' }} pt-3 pb-3">
            <a href="{{ url('documents') }}" class="col text-muted">
                <span class="icon-bg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="grey" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="M20 12V5.749a.6.6 0 0 0-.176-.425l-3.148-3.148A.6.6 0 0 0 16.252 2H4.6a.6.6 0 0 0-.6.6v18.8a.6.6 0 0 0 .6.6H11M8 10h8M8 6h4m-4 8h3m6.954 2.94l1-1a1.121 1.121 0 0 1 1.586 0v0a1.121 1.121 0 0 1 0 1.585l-1 1m-1.586-1.586l-2.991 2.991a1 1 0 0 0-.28.553l-.244 1.557l1.557-.243a1 1 0 0 0 .553-.28l2.99-2.992m-1.585-1.586l1.586 1.586"></path><path d="M16 2v3.4a.6.6 0 0 0 .6.6H20"></path></g></svg>
                </span>
            </a>
            <a href="{{ url('ai-images') }}" class="col text-muted">
                <span class="icon-bg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="grey" d="m14 2l6 6v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8m4 18V9h-5V4H6v16h12m-1-7v6H7l5-5l2 2m-4-5.5A1.5 1.5 0 0 1 8.5 12A1.5 1.5 0 0 1 7 10.5A1.5 1.5 0 0 1 8.5 9a1.5 1.5 0 0 1 1.5 1.5Z"></path></svg>
                </span>
            </a>
            <a href="{{ url('dashboard') }}" class="col">
                <span class="icon-bg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#000" d="M4 13h6c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v8c0 .55.45 1 1 1zm0 8h6c.55 0 1-.45 1-1v-4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v4c0 .55.45 1 1 1zm10 0h6c.55 0 1-.45 1-1v-8c0-.55-.45-1-1-1h-6c-.55 0-1 .45-1 1v8c0 .55.45 1 1 1zM13 4v4c0 .55.45 1 1 1h6c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1h-6c-.55 0-1 .45-1 1z"></path></svg>
                </span>
            </a>
            <a href="{{ url('audios') }}" class="col text-muted">
                <span class="icon-bg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none"><path d="M24 0v24H0V0h24ZM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018Zm.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01l-.184-.092Z"></path><path fill="currentColor" d="M12 3a1 1 0 0 1 .993.883L13 4v16a1 1 0 0 1-1.993.117L11 20V4a1 1 0 0 1 1-1ZM8 6a1 1 0 0 1 1 1v10a1 1 0 1 1-2 0V7a1 1 0 0 1 1-1Zm8 0a1 1 0 0 1 1 1v10a1 1 0 1 1-2 0V7a1 1 0 0 1 1-1ZM4 9a1 1 0 0 1 1 1v4a1 1 0 1 1-2 0v-4a1 1 0 0 1 1-1Zm16 0a1 1 0 0 1 .993.883L21 10v4a1 1 0 0 1-1.993.117L19 14v-4a1 1 0 0 1 1-1Z"></path></g></svg>
                </span>
            </a>
            <a href="{{ url('settings') }}" class="col text-muted">
                <span class="icon-bg">
                    <svg width="24" height="24" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg" class="mr-2"><path fill-rule="evenodd" clip-rule="evenodd" d="M9.22422 0.950195C9.77574 0.950195 10.2751 1.17343 10.6369 1.53448C10.6509 1.54847 10.6648 1.56266 10.6784 1.57706C10.9982 1.91562 11.201 2.36582 11.2224 2.86305L11.223 2.87984C11.2238 2.90319 11.2242 2.92665 11.2242 2.9502V2.96161C11.2242 2.99413 11.244 3.02336 11.274 3.03582C11.3041 3.04828 11.3387 3.04158 11.3617 3.01857L11.3698 3.0105C11.3865 2.99385 11.4033 2.97755 11.4204 2.96161L11.4327 2.9502C11.7994 2.61367 12.2612 2.43878 12.7268 2.42553C12.7466 2.42497 12.7663 2.42469 12.7861 2.42472C13.2973 2.42525 13.8082 2.62051 14.1982 3.0105L14.7639 3.57618C15.1539 3.96617 15.3492 4.47714 15.3497 4.98827C15.3497 5.00807 15.3494 5.02786 15.3489 5.04765C15.3356 5.5132 15.1607 5.97499 14.8242 6.34167L14.8128 6.354C14.7969 6.37109 14.7806 6.38796 14.7639 6.40461L14.7558 6.41268C14.7328 6.43569 14.7261 6.47033 14.7386 6.50039C14.7511 6.53043 14.7803 6.5502 14.8128 6.5502H14.8242C14.8478 6.5502 14.8712 6.5506 14.8946 6.55141L14.9114 6.55206C15.4086 6.57338 15.8588 6.77625 16.1974 7.09606C16.2118 7.10966 16.2259 7.12347 16.2399 7.13749C16.601 7.4993 16.8242 7.99867 16.8242 8.5502V9.3502C16.8242 9.90172 16.601 10.4011 16.2399 10.7629C16.2259 10.7769 16.2118 10.7907 16.1974 10.8043C15.8588 11.1241 15.4086 11.327 14.9114 11.3483L14.8946 11.349C14.8712 11.3498 14.8478 11.3502 14.8242 11.3502H14.8128C14.7803 11.3502 14.7511 11.37 14.7386 11.4C14.7261 11.4301 14.7328 11.4647 14.7558 11.4877L14.7639 11.4958C14.7806 11.5124 14.7969 11.5293 14.8128 11.5464L14.8242 11.5587C15.1607 11.9254 15.3356 12.3872 15.3489 12.8527C15.3494 12.8725 15.3497 12.8923 15.3497 12.9121C15.3492 13.4233 15.1539 13.9342 14.7639 14.3242L14.1982 14.8899C13.8082 15.2799 13.2973 15.4751 12.7861 15.4757C12.7663 15.4757 12.7466 15.4754 12.7268 15.4749C12.2612 15.4616 11.7994 15.2867 11.4327 14.9502L11.4204 14.9388C11.4033 14.9228 11.3865 14.9065 11.3698 14.8899L11.3617 14.8818C11.3387 14.8588 11.3041 14.8521 11.274 14.8646C11.244 14.877 11.2242 14.9063 11.2242 14.9388V14.9502C11.2242 14.9737 11.2238 14.9972 11.223 15.0206L11.2224 15.0373C11.201 15.5346 10.9982 15.9848 10.6784 16.3233C10.6648 16.3377 10.6509 16.3519 10.6369 16.3659C10.2751 16.727 9.77574 16.9502 9.22422 16.9502H8.42422C7.8727 16.9502 7.37332 16.727 7.01151 16.3659C6.99749 16.3519 6.98368 16.3377 6.97008 16.3233C6.65027 15.9848 6.4474 15.5346 6.42608 15.0373L6.42543 15.0206C6.42463 14.9972 6.42422 14.9737 6.42422 14.9502V14.9388C6.42422 14.9063 6.40445 14.877 6.37441 14.8646C6.34435 14.8521 6.30971 14.8588 6.2867 14.8818L6.27863 14.8899C6.26198 14.9065 6.24511 14.9228 6.22802 14.9388L6.21569 14.9502C5.84902 15.2867 5.38722 15.4616 4.92168 15.4749C4.90189 15.4754 4.88209 15.4757 4.86229 15.4757C4.35116 15.4751 3.84019 15.2799 3.45021 14.8899L2.88452 14.3242C2.49454 13.9342 2.29928 13.4233 2.29874 12.9121C2.29872 12.8923 2.29899 12.8725 2.29955 12.8527C2.3128 12.3872 2.48769 11.9254 2.82422 11.5587L2.83563 11.5464C2.85157 11.5293 2.86787 11.5124 2.88452 11.4958L2.89259 11.4877C2.9156 11.4647 2.9223 11.4301 2.90984 11.4C2.89738 11.37 2.86815 11.3502 2.83563 11.3502H2.82422C2.80067 11.3502 2.77722 11.3498 2.75386 11.349L2.73707 11.3483C2.23984 11.327 1.78964 11.1241 1.45108 10.8043C1.43669 10.7907 1.42249 10.7769 1.4085 10.7629C1.04746 10.4011 0.824219 9.90172 0.824219 9.3502V8.5502C0.824219 7.99867 1.04746 7.4993 1.4085 7.13749C1.42249 7.12347 1.43669 7.10966 1.45108 7.09606C1.78964 6.77625 2.23984 6.57338 2.73707 6.55206L2.75386 6.55141C2.77722 6.5506 2.80067 6.5502 2.82422 6.5502H2.83563C2.86815 6.5502 2.89738 6.53043 2.90984 6.50039C2.9223 6.47033 2.9156 6.43569 2.89259 6.41268L2.88452 6.40461C2.86787 6.38796 2.85157 6.37109 2.83563 6.354L2.82422 6.34167C2.48769 5.97499 2.3128 5.5132 2.29955 5.04765C2.29899 5.02786 2.29872 5.00807 2.29874 4.98827C2.29928 4.47714 2.49454 3.96617 2.88452 3.57618L3.45021 3.0105C3.84019 2.62051 4.35116 2.42525 4.86229 2.42472C4.88209 2.42469 4.90189 2.42497 4.92168 2.42553C5.38722 2.43878 5.84902 2.61367 6.21569 2.9502L6.22802 2.96161C6.24511 2.97755 6.26198 2.99385 6.27863 3.0105L6.2867 3.01857C6.30971 3.04158 6.34435 3.04828 6.37441 3.03582C6.40445 3.02336 6.42422 2.99413 6.42422 2.96161V2.9502C6.42422 2.92665 6.42463 2.90319 6.42543 2.87984L6.42608 2.86305C6.4474 2.36582 6.65027 1.91562 6.97008 1.57706C6.98368 1.56266 6.99749 1.54847 7.01151 1.53448C7.37332 1.17343 7.8727 0.950195 8.42422 0.950195H9.22422ZM8.02422 14.9502C8.02422 15.1711 8.20331 15.3502 8.42422 15.3502H9.22422C9.44513 15.3502 9.62422 15.1711 9.62422 14.9502V14.9388C9.62422 14.2511 10.0412 13.6437 10.6611 13.3866C11.2824 13.129 12.0072 13.2645 12.4931 13.7505L12.5012 13.7585C12.6574 13.9147 12.9107 13.9147 13.0669 13.7585L13.6325 13.1928C13.7888 13.0366 13.7888 12.7834 13.6325 12.6272L13.6245 12.6191C13.1385 12.1331 13.003 11.4084 13.2606 10.7871C13.5177 10.1671 14.1252 9.7502 14.8128 9.7502H14.8242C15.0451 9.7502 15.2242 9.57111 15.2242 9.3502V8.5502C15.2242 8.32928 15.0451 8.1502 14.8242 8.1502H14.8128C14.1252 8.1502 13.5177 7.73325 13.2606 7.11328C13.003 6.49201 13.1385 5.76725 13.6245 5.2813L13.6325 5.27324C13.7888 5.11703 13.7888 4.86376 13.6325 4.70756L13.0669 4.14187C12.9107 3.98566 12.6574 3.98566 12.5012 4.14187L12.4931 4.14994C12.0072 4.63588 11.2824 4.7714 10.6611 4.51378C10.0412 4.25669 9.62422 3.64924 9.62422 2.96161V2.9502C9.62422 2.72928 9.44513 2.5502 9.22422 2.5502H8.42422C8.2033 2.5502 8.02422 2.72928 8.02422 2.9502V2.96161C8.02422 3.64924 7.60728 4.25669 6.98729 4.51378C6.36602 4.7714 5.64127 4.63588 5.15533 4.14994L5.14726 4.14187C4.99105 3.98566 4.73779 3.98566 4.58158 4.14187L4.01589 4.70756C3.85968 4.86376 3.85968 5.11703 4.01589 5.27324L4.02396 5.2813C4.50991 5.76725 4.64543 6.49201 4.3878 7.11328C4.13071 7.73325 3.52327 8.1502 2.83563 8.1502H2.82422C2.60331 8.1502 2.42422 8.32928 2.42422 8.5502V9.3502C2.42422 9.57111 2.60331 9.7502 2.82422 9.7502H2.83563C3.52327 9.7502 4.1307 10.1671 4.3878 10.7871C4.64543 11.4084 4.50991 12.1331 4.02396 12.6191L4.01589 12.6272C3.85968 12.7834 3.85968 13.0366 4.01589 13.1928L4.58158 13.7585C4.73779 13.9147 4.99105 13.9147 5.14726 13.7585L5.15533 13.7505C5.64128 13.2645 6.36603 13.129 6.98729 13.3866C7.60726 13.6437 8.02422 14.2511 8.02422 14.9388V14.9502Z" fill="#827A9C"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M8.82402 10.55C9.70768 10.55 10.424 9.83366 10.424 8.95C10.424 8.06634 9.70768 7.35 8.82402 7.35C7.94037 7.35 7.22402 8.06634 7.22402 8.95C7.22402 9.83366 7.94037 10.55 8.82402 10.55ZM8.82402 12.15C10.5913 12.15 12.024 10.7173 12.024 8.95C12.024 7.18269 10.5913 5.75 8.82402 5.75C7.05671 5.75 5.62402 7.18269 5.62402 8.95C5.62402 10.7173 7.05671 12.15 8.82402 12.15Z" fill="#827A9C"></path></svg>
                </span>
            </a>
            <a href="#" class="col text-muted " id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li>
                    <a class="dropdown-item" href="{{ url('chat') }}">
                        <span class="icon-bg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M2 22V4q0-.825.588-1.413T4 2h16q.825 0 1.413.588T22 4v12q0 .825-.588 1.413T20 18H6l-4 4Zm2-4.825L5.175 16H20V4H4v13.175ZM4 4v13.175V4Zm7.25 11h1.5V5h-1.5v10ZM8.5 13H10V7H8.5v6ZM6 11h1.5V9H6v2Zm8 2h1.5V7H14v6Zm2.5-2H18V9h-1.5v2Z"></path></svg>
                        </span>
                        <span class="ms-2">Chat With AI</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ url('prompts') }}">
                        <span class="icon-bg">
                            <svg width="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M40 48C26.7 48 16 58.7 16 72v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V72c0-13.3-10.7-24-24-24H40zM192 64c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zM16 232v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V232c0-13.3-10.7-24-24-24H40c-13.3 0-24 10.7-24 24zM40 368c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V392c0-13.3-10.7-24-24-24H40z"></path></svg>                            </span>
                        <span class="ms-2">Prompts</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ url('billing') }}">
                        <span class="icon-bg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 14 14"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="9" cy="5.5" rx="4.5" ry="2"></ellipse><path d="M4.5 5.5v6c0 1.1 2 2 4.5 2s4.5-.9 4.5-2v-6"></path><path d="M13.5 8.5c0 1.1-2 2-4.5 2s-4.5-.9-4.5-2m4.4-7A6.77 6.77 0 0 0 5 .5C2.51.5.5 1.4.5 2.5c0 .59.58 1.12 1.5 1.5"></path><path d="M2 10C1.08 9.62.5 9.09.5 8.5v-6"></path><path d="M2 7C1.08 6.62.5 6.09.5 5.5"></path></g></svg>
                        </span>
                        <span class="ms-2">Billing</span>
                    </a>
                </li>
              </ul>
        </div>
      </div>

    <div class="spinner">
        <div class="loading-text">
            <div class="spinner-border"></div>
            <div class="loading-message"></div>
        </div>
    </div>
    
    <!-- JS Global Compulsory  -->
    <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/customer.js') }}"></script>
    <script>
        function copyToClipboard(elementId) {

            // Create a "hidden" input
            var aux = document.createElement("input");

            // Assign it the value of the specified element
            aux.setAttribute("value", document.getElementById(elementId).innerHTML);

            // Append it to the body
            document.body.appendChild(aux);

            // Highlight its content
            aux.select();

            // Copy the highlighted text
            document.execCommand("copy");

            // Remove it from the body
            document.body.removeChild(aux);

            }
    </script>

</body>
</html>