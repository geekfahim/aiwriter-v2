<!-- ========== FOOTER ========== -->
<footer class="bg-dark">
    <div class="container">
        <div class="border-bottom border-white-10">
            <div class="row py-6">
            <div class="col-4 col-sm-4 col-lg mb-7 mb-lg-0">
                <span class="text-cap text-white">{{ __('Resources') }}</span>

                <!-- List -->
                <ul class="list-unstyled list-py-1 mb-0">
                <li><a class="link link-light link-light-75" href="{{ url('pricing') }}">{{ __('Pricing') }}</a></li>
                <li><a class="link link-light link-light-75" href="{{ url('contact-us') }}">{{ __('Contact Us') }}</a></li>
                </ul>
                <!-- End List -->
            </div>
            <!-- End Col -->

            <div class="col-4 col-sm-4 col-lg mb-7 mb-lg-0">
                <span class="text-cap text-white">{{ __('My Account') }}</span>
                <!-- List -->
                <ul class="list-unstyled list-py-1 mb-0">
                <li><a class="link link-light link-light-75" href="{{ url('signup') }}" target="_blank">{{ __('Signup') }}</a></li>
                <li><a class="link link-light link-light-75" href="{{ url('login') }}" target="_blank">{{ __('Login') }}</a></li>
                </ul>
                <!-- End List -->
            </div>

            <div class="col-4 col-sm-4 col-lg mb-7 mb-lg-0">
                <span class="text-cap text-white">{{ __('Legal') }}</span>
                <!-- List -->
                <ul class="list-unstyled list-py-1 mb-0">
                <li><a class="link link-light link-light-75" href="{{ url('terms') }}">{{ __('Terms of use') }}</a></li>
                <li><a class="link link-light link-light-75" href="{{ url('privacy') }}">{{ __('Privacy policy') }}</a></li>
                </ul>
                <!-- End List -->
            </div>
            <!-- End Col -->
            <!-- End Col -->

            @if (Helper::config('socials') != NULL)
            @php
                $socials = unserialize(Helper::config('socials'));
            @endphp
            @if (array_filter($socials))
            <div class="col-md-4 col-sm-4 col-lg">
                <span class="text-cap text-white">{{ __('Follow us') }}</span>

                <!-- List -->
                <ul class="list-unstyled list-py-2 mb-0 row">
                
                @if (isset(unserialize(Helper::config('socials'))['linkedin']))
                <li class="col-4 col-4 pt-0"><a class="link link-light link-light-75" href="{{ unserialize(Helper::config('socials'))['linkedin'] }}">
                    <div class="d-flex">
                    <div class="flex-shrink-0">
                        <i class="bi-linkedin"></i>
                    </div>

                    <div class="flex-grow-1 ms-2">
                        <span>{{ __('Linkedin') }}</span>
                    </div>
                    </div>
                </a></li>
                @endif
                
                @if (isset(unserialize(Helper::config('socials'))['twitter']))
                <li class="col-4 pt-0"><a class="link link-light link-light-75" href="{{ unserialize(Helper::config('socials'))['twitter'] }}">
                    <div class="d-flex">
                    <div class="flex-shrink-0">
                        <i class="bi-twitter"></i>
                    </div>

                    <div class="flex-grow-1 ms-2">
                        <span>{{ __('Twitter') }}</span>
                    </div>
                    </div>
                </a></li>
                @endif

                @if (isset(unserialize(Helper::config('socials'))['facebook']))
                <li class="col-4 col-4 pt-0"><a class="link link-light link-light-75" href="{{ unserialize(Helper::config('socials'))['facebook'] }}">
                    <div class="d-flex">
                    <div class="flex-shrink-0">
                        <i class="bi-facebook"></i>
                    </div>

                    <div class="flex-grow-1 ms-2">
                        <span>{{ __('Facebook') }}</span>
                    </div>
                    </div>
                </a></li>
                @endif

                @if (isset(unserialize(Helper::config('socials'))['slack']))
                <li class="col-4"><a class="link link-light link-light-75" href="{{ unserialize(Helper::config('socials'))['slack'] }}">
                    <div class="d-flex">
                    <div class="flex-shrink-0">
                        <i class="bi-slack"></i>
                    </div>

                    <div class="flex-grow-1 ms-2">
                        <span>{{ __('Slack') }}</span>
                    </div>
                    </div>
                </a></li>
                @endif

                @if (isset(unserialize(Helper::config('socials'))['instagram']))
                <li class="col-4"><a class="link link-light link-light-75" href="{{ unserialize(Helper::config('socials'))['instagram'] }}">
                    <div class="d-flex">
                    <div class="flex-shrink-0">
                        <i class="bi-instagram"></i>
                    </div>

                    <div class="flex-grow-1 ms-2">
                        <span>{{ __('Instagram') }}</span>
                    </div>
                    </div>
                </a></li>
                @endif
                </ul>
                <!-- End List -->
            </div>
            @endif
            @endif
            <!-- End Col -->
            </div>
            <!-- End Row -->
        </div>

        <div class="row align-items-md-center py-6">
            <div class="col-md mb-3 mb-md-0">
            <!-- List -->
            <ul class="list-inline list-px-2 mb-0">
                <li class="list-inline-item"><a class="link link-light link-light-75" href="{{ url('privacy') }}">{{ __('Privacy and Policy') }}</a></li>
                <li class="list-inline-item"><a class="link link-light link-light-75" href="{{ url('terms') }}">{{ __('Terms') }}</a></li>
            </ul>
            <!-- End List -->
            </div>
            <!-- End Col -->

            <div class="col-md-auto">
            <p class="fs-5 text-white-70 mb-0">© {{ Helper::config('company_name') }} {{ date('Y') }}.</p>
            </div>
            <!-- End Col -->
        </div>
        <!-- End Row -->
    </div>
</footer>
<!-- ========== END FOOTER ========== -->