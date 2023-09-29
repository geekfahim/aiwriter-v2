@extends('frontend/layout')
@section('content')
<!-- ========== MAIN CONTENT ========== -->
<main id="content" role="main">
  {!! $page->content !!}
  <div class="container content-space-b-2 content-space-b-lg-3 content-space-t-lg-2">
    <div class="row justify-content-center">
      @foreach ($reviews as $review)
      <div class="col-6 col-md-4 col-lg mb-3 mb-lg-0">
        <div class="text-center">
          <img class="avatar avatar-xl" src="{{ asset('uploads/brand/' . $review->image) }}" alt="Image">
          <p>" {{ $review->review }} "</p>

          <div class="d-flex justify-content-center gap-1">
            <img src="./images/svg/illustrations/star.svg" alt="Review rating" width="18">
            <img src="./images/svg/illustrations/star.svg" alt="Review rating" width="18">
            <img src="./images/svg/illustrations/star.svg" alt="Review rating" width="18">
            <img src="./images/svg/illustrations/star.svg" alt="Review rating" width="18">
            <img src="./images/svg/illustrations/star.svg" alt="Review rating" width="18">
          </div>
          <!-- End Rating -->
        </div>
      </div>
      <!-- End Col -->  
      @endforeach
    </div>
    <!-- End Row -->
  </div>
</main>
<!-- ========== END MAIN CONTENT ========== -->
@endsection