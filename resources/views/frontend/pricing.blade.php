@extends('frontend/layout')
@section('content')
<!-- ========== MAIN CONTENT ========== -->
<main id="content" role="main">
  <!-- Hero -->
  <div class="overflow-hidden">
    <div class="container content-space-lg-2 content-space-t-xs-4">
      <div class="w-lg-65 text-center mx-lg-auto mb-5 mb-sm-7 mb-lg-10">
        <h1>{{ __('Our Pricing') }}</h1>
      </div>

      <div class="position-relative">
        <div class="row mb-5">
          @foreach ($plans as $plan)
            <div class="col-lg-6 mb-4">
              <!-- Card -->
              <div class="card card-lg bg-pattern {{ Helper::config('popular_plan') == $plan->id ? 'card-shadow card-pinned' : '' }} h-100">
                @if (Helper::config('popular_plan') == $plan->id)
                <span class="badge bg-dark text-white card-pinned-top-end">{{ __('Most popular') }}</span>
                @endif
                <div class="card-body">
                  <div class="mb-3">
                    <h4 class="mb-1">{{ $plan->name }}</h4>
                    <p>{{ $plan->description }}</p>
                  </div>
                  
                  <!-- Media -->
                  <div class="d-flex mb-5">
                    <div class="flex-shrink-0">
                        @php 
                            $number = CurrencyHelper::format_no_currency($plan->monthly_price);
                            list($whole, $decimal) = explode('.', $number); 
                        @endphp
                      <span class="display-4 lh-1 text-dark">{{ CurrencyHelper::format_currency_symbol().$whole }}<span class="fs-4">.{{ $decimal }}</span></span>
                    </div>
                    <div class="flex-grow-1 align-self-end ms-3">
                      <span class="d-block">{{ Helper::config('currency') }} / {{ __('monthly') }}</span>
                    </div>
                  </div>
                  <!-- End Media -->

                  <div class="row">
                    <div class="col-sm-6">
                      <ul class="list-checked list-checked-soft-bg-warning fs-4 mb-2">
                        <li class="list-checked-item">{{ $plan->words == 0 ? __('Unlimited') : CurrencyHelper::format_number($plan->words) }} {{ __('words /mo') }}</li>
                      </ul>
                    </div>
                  </div>
                  <!-- End Row -->
                </div>

                <div class="card-footer pt-0">
                  <div class="row align-items-center">
                    <div class="col-sm-auto order-sm-2 mb-3 mb-sm-0">
                      <a class="btn btn-primary btn-pointer" href="{{ url('signup') }}">{{ __('Start free trial') }}</a>
                    </div>
                    <!-- End Col -->
                    
                    <div class="col">
                      <span class="fs-5 text-muted d-block">{{ __('Cancel anytime.') }}</span>
                      <span class="fs-5 text-muted d-block">{{ __('No card required.') }}</span>
                    </div>
                    <!-- End Col -->
                  </div>
                  <!-- End Row -->
                </div>
              </div>
              <!-- End Card -->
            </div>
            <!-- End Col -->
          @endforeach
        </div>
        <!-- End Row -->

        <!-- SVG Shape -->
        <figure class="position-absolute top-0 end-0 zi-n1 d-none d-md-block mt-10 me-n10 width-4rem">
          <img class="img-fluid" src="./images/svg/components/pointer-up.svg" alt="Image Description">
        </figure>
        <!-- End SVG Shape -->

        <!-- SVG Shape -->
        <figure class="position-absolute bottom-0 start-0 zi-n1 ms-n10 mb-n10 width-15rem">
          <img class="img-fluid" src="./images/svg/components/curved-shape.svg" alt="Image Description">
        </figure>
        <!-- End SVG Shape -->
      </div>
    </div>
  </div>
  <!-- End Hero -->
</main>
<!-- ========== END MAIN CONTENT ========== -->
@endsection