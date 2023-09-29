@extends('frontend/layout')
@section('content')
<main id="content" role="main">
    <!-- Content -->
    <div class="container content-space-2 content-space-lg-3">
      <div class="w-lg-75 mx-lg-auto">
        <!-- Card -->
        <div class="card card-lg card-shadow">
          <!-- Header -->
          <div class="card-header bg-dark">
            <h1 class="card-title h2 text-white text-capitalize">{{ $page->name }}</h1>
            <p class="card-text text-white">{{ __('Last modified') }}: {{ date('M d Y', strtotime($page->updated_at)) }}</p>
          </div>
          <!-- End Header -->

          <!-- Card Body -->
          <div class="card-body">
            {!! $page->content !!}
          </div>
          <!-- End Card Body -->
        </div>
        <!-- End Card -->
      </div>
    </div>
    <!-- End Content -->
</main>
@endsection