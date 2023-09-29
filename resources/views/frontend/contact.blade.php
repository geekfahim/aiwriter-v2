@extends('frontend/layout')
@section('content')
<!-- ========== MAIN CONTENT ========== -->
<main id="content" role="main">
  <!-- Contact Form -->
  <div class="overflow-hidden">
    <div class="container content-space-1 content-space-lg-2">
      <div class="row">
        <div class="col-lg-6 mb-10 mb-lg-0">
          <div class="pe-lg-10">
            <div class="mb-5">
              <h1>{{ __('Contact Us') }}</h1>
            </div>

            <!-- Info -->
            <address>
              {{ Helper::config('address') }}
            </address>
            <!-- End Info -->

            @if (Helper::config('phone') != NULL)
            <div class="mb-5 d-flex">
              <span class="d-block">{{ __('Phone') }} :</span>
              <span class="d-block ms-2">{{ Helper::config('phone') }}</span>
            </div>
            @endif

            <div class="d-grid mb-3">
              @if (Helper::config('email') != NULL)
                <a class="btn btn-white" href="mailto:{{ Helper::config('email') }}"><i class="bi-envelope-open me-2"></i> {{ Helper::config('email') }}</a>
              @endif
            </div>
          </div>
        </div>
        <!-- End Col -->

        <div class="col-lg-6">
          <div class="position-relative">
            <!-- Card -->
            <div class="card card-lg">
              <!-- Card Body -->
              <div class="card-body">
                <h4 class="mb-4">{{ __('Fill in the form') }}</h4>

                <form class="js-validate needs-validation" novalidate="">
                  @csrf
                  <div class="row">
                    <div class="col-sm-6 mb-4 mb-sm-0">
                      <!-- Form -->
                      <div class="mb-4">
                        <label class="form-label" for="contactsFormFirstName">{{ __('First name') }}</label>
                        <input type="text" class="form-control" name="first_name" id="contactsFormFirstName" placeholder="John" required="">
                        <span class="invalid-feedback">{{ __('Please enter a valid first name.') }}</span>
                      </div>
                      <!-- End Form -->
                    </div>
                    <!-- End Col -->

                    <div class="col-sm-6">
                      <!-- Form -->
                      <div class="mb-4">
                        <label class="form-label" for="contactsFormLasttName">{{ __('Last name') }}</label>
                        <input type="text" class="form-control" name="last_name" id="contactsFormLasttName" placeholder="Doe" required="">
                        <span class="invalid-feedback">{{ __('Please enter a valid last name.') }}</span>
                      </div>
                      <!-- End Form -->
                    </div>
                    <!-- End Col -->
                  </div>
                  <!-- End Row -->

                  <!-- Form -->
                  <div class="mb-4">
                    <label class="form-label" for="contactsFormWorkEmail">{{ __('Email') }}</label>
                    <input type="email" class="form-control" name="email" id="contactsFormWorkEmail" placeholder="email@site.com" aria-label="email@site.com" required="">
                    <span class="invalid-feedback">{{ __('Please enter a valid email address.') }}</span>
                  </div>
                  <!-- End Form -->

                  <!-- Form -->
                  <div>
                    <label class="form-label" for="contactsFormDetails">{{ __('Details') }}</label>
                    <textarea class="form-control" name="details" id="contactsFormDetails" placeholder="{{ __('Tell us about your issue') }}" rows="4" required=""></textarea>
                    <span class="invalid-feedback">{{ __('This field is required') }}</span>
                  </div>
                  <!-- End Form -->

                  @if (Helper::config('recaptcha_active') == 1)
                      {!! RecaptchaV3::field('contact') !!}
                      <span class="invalid-feedback">{{ __('Oops! Recaptcha failed. Please refresh and try again.') }}</span>
                  @endif

                  <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-dark btn-lg" data-message="{{ __('Inquiry Sent!') }}">{{ __('Send inquiry') }}</button>
                  </div>
                </form>
              </div>
              <!-- End Card Body -->
            </div>
            <!-- End Card -->

            <!-- SVG Shape -->
            <figure class="position-absolute bottom-0 end-0 zi-n1 d-none d-md-block mb-n10 width-15rem mr--8rem">
              <img class="img-fluid" src="./images/svg/illustrations/grid-grey.svg" alt="Image Description">
            </figure>
            <!-- End SVG Shape -->

            <!-- SVG Shape -->
            <figure class="position-absolute bottom-0 end-0 d-none d-md-block me-n5 mb-n5 width-10rem">
              <img class="img-fluid" src="./images/svg/illustrations/plane.svg" alt="Image Description">
            </figure>
            <!-- End SVG Shape -->
          </div>
        </div>
        <!-- End Col -->
      </div>
      <!-- End Row -->
    </div>
  </div>
  <!-- End Contact Form -->
</main>
<!-- ========== END MAIN CONTENT ========== -->
@endsection
