<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ Helper::config('company_name') }} - {{ $page_title ?? 'Prompt' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('uploads/brand/' . Helper::config('favicon')) }}"/>

    <base href="" target="_blank">
    <meta
        content="Prompt, Prompts, Prompt Engineer, Custom prompts, ChatGPT Prompts, Ai Prompts, Midjourney, Midjourney prompts, AI tools, Ai writer, Speech to text, Ai image generator, Generator, AI image, AI writer, Writer AI "
        name="keywords"/>
    <meta
        content="Access AI tools and custom prompts to enhance your business. Drive customer engagement, streamline workflows, and unlock new opportunities for growth. "
        name="description"/>
    <meta content="width=device-width,initial-scale=1.0,viewport-fit=cover" name="viewport">

    <!-- CSS -->
    <link href="{{asset('css/fonts.css')}}" rel="stylesheet"/>
    <link href="{{asset('css/bootstrap.weber.css')}}" rel="stylesheet"/>
    <link href="{{asset('css/fx.css')}}" rel="stylesheet"/>
    <link href="{{asset('css/aos.css')}}" rel="stylesheet"/>
    <link href="{{asset('css/custom.css')}}" rel="stylesheet"/>
    <link href="{{asset('css/index.css')}}" rel="stylesheet"/>
    <link href="{{asset('css/preloader.css')}}" rel="stylesheet"/>

</head>

<body class="light-page">
<div id="preloader">
    <div class="circles">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
</div>
<div id="wrap">
    @include('frontend.layout.navbar')
    @yield('content')
</div>


@include('frontend.layout.footer')
<div class="modal-container"></div>


<script src="https://maps.googleapis.com/maps/api/js?key="></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="{{asset('js/jquery-2.1.4.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/jquery.validate.min.js')}}"></script>
<script src="{{asset('js/jquery.smooth-scroll.min.js')}}"></script>
<script src="{{asset('js/rellax.min.js')}}"></script>
<script src="{{asset('js/aos.js')}}"></script>
<script src="{{asset('js/custom.js')}}"></script>
<script src="{{asset('js/index.js')}}"></script>

</body>
</html>
