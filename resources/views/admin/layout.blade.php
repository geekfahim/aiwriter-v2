<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ Helper::config('company_name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('uploads/brand/' . Helper::config('favicon')) }}"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jq-3.6.0/dt-1.13.1/af-2.5.1/fh-3.3.1/r-2.4.0/sc-2.0.7/sb-1.4.0/sl-1.5.0/datatables.min.css"/>

    <style>
        .sidebar {
            height: 100%; /* 100% Full-height */
            width: 0; /* 0 width - change this with JavaScript */
            position: fixed; /* Stay in place */
            z-index: 1; /* Stay on top */
            top: 0;
            left: 0;
            background-color: #111; /* Black*/
            overflow-x: hidden; /* Disable horizontal scroll */
            padding-top: 60px; /* Place content 60px from the top */
            transition: 0.5s; /* 0.5 second transition effect to slide in the sidebar */
        }
        .openbtn {
            display: none;
        }
        .sidebar .closebtn {
            display: none;
        }
        @media only screen and (max-width: 600px) {
            .openbtn {
                display: block;
                font-size: 20px;
                cursor: pointer;
                background-color: #111;
                color: white;
                padding: 5px 10px;
                border: none;
                margin: 10px 10px;
                border-radius: 5px;
            }
            .sidebar .closebtn {
                display: block;
                position: absolute;
                top: 0;
                right: 25px;
                font-size: 36px;
                margin-left: 50px;
            }   
        }
            @media screen and (max-height: 450px) {
                .sidebar {
                    padding-top: 15px;
                }
                .sidebar a {
                    font-size: 18px;
                }
            }
    </style>

    <!-- CSS -->  
    <link rel="stylesheet" href="{{ asset('css/theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme-style.css') }}"> 
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.css') }}"/>

    <!-- JS -->   
    <script src="{{ url('js/jquery-3.6.3.min.js') }}"></script>
</head>
<body>
    <div class="container-fluid bg-light">
        <div id="main">
            <button class="openbtn" onclick="openNav()">&#9776;</button>
          </div>
        @include('admin.sidebar')
        @yield('content')
    </div>
    
    <!-- Global JS -->
    <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/bootbox/js/bootbox.min.js') }}"></script>
    <script src="{{ asset('vendor/bootbox/js/bootbox.locales.min.js') }}"></script>
    <script src="{{ asset('vendor/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('vendor/summernote/editor-summernote.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.13.1/af-2.5.1/datatables.min.js"></script>
    <script>
        function openNav() {
        document.getElementById("mySidebar").style.width = "250px";
        }

        /* Set the width of the sidebar to 0 and the left margin of the page content to 0 */
        function closeNav() {
        document.getElementById("mySidebar").style.width = "0";
        document.getElementById("main").style.marginLeft = "0";
        }
    </script>
</body>
</html>
