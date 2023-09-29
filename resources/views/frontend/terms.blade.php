@extends('frontend/layout')
@section('content')
<main id="content" role="main">
    <!-- Hero -->
    <div class="bg-dark">
      <div class="container position-relative content-space-1 content-space-lg-2">
        <h1 class="text-white text-capitalize">{{ $page->name }}</h1>
        <p class="text-white">{{ __('Updated') }}: {{ date('M d Y', strtotime($page->updated_at)) }}</p>
      </div>
    </div>
    <!-- End Hero -->

    <!-- Description -->
    <div class="container content-space-1 content-space-lg-3">
      <div class="row">
        <div class="col-md-12 col-lg-12">
            {!! $page->content !!}
          <!-- End Sticky End Point -->
          <div id="stickyBlockEndPoint"></div>
        </div>
        <!-- End Col -->
      </div>
      <!-- End Row -->
    </div>
    <!-- End Description -->
</main>
@endsection