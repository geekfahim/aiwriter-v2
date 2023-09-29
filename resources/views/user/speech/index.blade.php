@extends('user.layout')
@section('content')
<!-- Content -->
<div class="navbar-sidebar-aside-content content-space-1 content-space-md-2 px-lg-5 px-xl-10">
    <div class="">
        <div class="row align-items-center">
          <div class="col-6">
            <h4 class="mb-0">{{ __('common.my_audios') }}</h4>
          </div>
          <div class="col-6">
            <button class="btn btn-sm btn-dark btn-pointer rounded-btn float-end" data-bs-toggle="modal" data-bs-target="#speechModal">
                {{ __('common.convert_audio') }}
            </button>
          </div>
        </div>
    </div>
    <div class="mt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text rounded-btn border-0 bg-grey-light ps-4 pe-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M11 2c4.968 0 9 4.032 9 9s-4.032 9-9 9s-9-4.032-9-9s4.032-9 9-9zm0 16c3.867 0 7-3.133 7-7c0-3.868-3.133-7-7-7c-3.868 0-7 3.132-7 7c0 3.867 3.132 7 7 7zm8.485.071l2.829 2.828l-1.415 1.415l-2.828-2.829l1.414-1.414z"/></svg>
                    </span>
                    <input type="text" class="form-control form-control-sm rounded-btn shadow-none bg-grey-light border-0 search-box" data-url={{ url('audios/search') }} placeholder="{{ __('common.search_projects_by_name') }}">
                </div>
            </div>
            <!--
            <button class="btn bg-grey-light rounded-btn ms-3 p-1">
                <span class="p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 21 21"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M6.5 4a1 1 0 0 1 1 1v2a1 1 0 1 1-2 0V5a1 1 0 0 1 1-1zm12 2h-11m-2 0h-3m4 8a1 1 0 0 1 1 1v2a1 1 0 0 1-2 0v-2a1 1 0 0 1 1-1zm12 2h-11m-2 0h-3m12-7a1 1 0 0 1 1 1v2a1 1 0 0 1-2 0v-2a1 1 0 0 1 1-1zm-1 2h-11m16 0h-3"/></svg>
                </span>
            </button>-->
        </div>
        <div class="mt-3 row">
            <div class="col-md-12">
                <div class="border rounded bg-white" id="table-render">
                    @include('user.speech.table')
                </div>
            </div>
        </div>
    </div>
</div>
<div class="viewModal">
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-bottom pb-2">
                    <div>
                        <h5 class="modal-title">{{ __('common.you_dont_have_active_subscription') }}</h5>
                        <small>{{ __('common.subscribe_to_plan') }}</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-5">
                        <div class="col-md-8">
                            <ul class="nav nav-segment mb-4" id="navTab1" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link plan-toggle {{ $subscription->plan_interval != 'year' ? 'active' : '' }}" data-type="monthly" id="nav-resultTab1" href="#nav-result1" data-bs-toggle="pill" data-bs-target="#nav-result1" role="tab" aria-controls="nav-result1" aria-selected="true">{{ __('common.monthly') }}</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link plan-toggle {{ $subscription->plan_interval == 'year' ? 'active' : '' }}" data-type="yearly" id="nav-htmlTab1" href="#nav-html1" data-bs-toggle="pill" data-bs-target="#nav-html1" role="tab" aria-controls="nav-html1">{{ __('common.yearly') }}</a>
                                </li>
                            </ul>
                            <div class="row">
                                @foreach ($plans as $plan)
                                <div class="col-lg-6 mb-3 mb-4">
                                    <div class="card shadow-sm card-lg h-100">
                                        <div class="card-body pt-4 ps-4 pe-4 pb-3">
                                            <div class="mb-3">
                                                <h5 class="mb-0">{{ $plan->name }}</h5>
                                                <small class="font-xs">{{ $plan->description }}</small>
                                            </div>
                                            <div class="d-flex {{ $subscription->plan_interval == 'year' ? 'd-none' : '' }} plan-period">
                                                <div class="flex-shrink-0">
                                                    @php 
                                                        $number = $plan->monthly_price;
                                                        $whole = (int) $number;
                                                        $decimal  = $number - $whole; 
                                                    @endphp
                                                    <span class="display-6 lh-1 text-dark fs-2">{{ CurrencyHelper::format_currency_symbol().$whole }}<span class="fs-4">.{{ $decimal }}</span></span>
                                                </div>
                                                <div class="flex-grow-1 align-self-end ms-3">
                                                    <span class="d-block fw-bold text-muted">{{ __('common.mo') }}</span>
                                                </div>
                                            </div>
                                            <div class="d-flex {{ $subscription->plan_interval != 'year' ? 'd-none' : '' }} plan-period">
                                                <div class="flex-shrink-0">
                                                    @php 
                                                        $number = $plan->yearly_price;
                                                        $whole = (int) $number;
                                                        $decimal  = $number - $whole;
                                                    @endphp
                                                    <span class="display-6 lh-1 text-dark fs-2">{{ CurrencyHelper::format_currency_symbol().$whole }}<span class="fs-4">.{{ $decimal }}</span></span>
                                                </div>
                                                <div class="flex-grow-1 align-self-end ms-3">
                                                    <span class="d-block fw-bold text-muted">{{ __('common.yr') }}</span>
                                                </div>
                                            </div>
                                            <small class="text-muted font-xs">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path fill="#0ABF53" d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10s10-4.5 10-10S17.5 2 12 2m-2 15l-5-5l1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9Z"/></svg>
                                                {{ $plan->words == 0 ? __('common.unlimited') : CurrencyHelper::format_number($plan->words) }} {{ __('common.words_mo') }}
                                            </small>
                                            <br>
                                            <small class="text-muted font-xs">
                                                @if ($plan->allow_export)
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path fill="#0ABF53" d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10s10-4.5 10-10S17.5 2 12 2m-2 15l-5-5l1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9Z"/></svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10s10-4.5 10-10S17.5 2 12 2zm3.7 12.3c.4.4.4 1 0 1.4c-.4.4-1 .4-1.4 0L12 13.4l-2.3 2.3c-.4.4-1 .4-1.4 0c-.4-.4-.4-1 0-1.4l2.3-2.3l-2.3-2.3c-.4-.4-.4-1 0-1.4c.4-.4 1-.4 1.4 0l2.3 2.3l2.3-2.3c.4-.4 1-.4 1.4 0c.4.4.4 1 0 1.4L13.4 12l2.3 2.3z"/></svg>
                                                @endif
                                                {{ __('common.export_as_pdf_word') }}
                                            </small>
                                        </div>
                                        <div class="card-footer pt-0 p-0 pb-3 ps-3 pe-3">
                                            <div class="plan-period {{ $subscription->plan_interval == 'year' ? 'd-none' : '' }}">
                                                @php
                                                    $api_id = json_decode($plan->stripe_id);
                                                @endphp
                                                <input type="hidden" name="priceId" value="{{ $api_id != NULL ? $api_id->monthly : NULL }}" />
                                                @if ($subscription->plan_id == $plan->id && $subscription->plan_interval == 'month')
                                                    <button type="button" class="btn btn-dark w-100 pt-2 pb-2" disabled>{{ __('common.current_plan') }}</button>
                                                @else
                                                    <button type="button" class="btn btn-dark btn-pointer w-100 pt-2 pb-2 js-pay-plan" data-url="{{ url('pay/'.$plan->id.'/monthly') }}">{{ __('common.select_plan') }}</button> 
                                                @endif
                                            </div>
                                            <div class="plan-period {{ $subscription->plan_interval != 'year' ? 'd-none' : '' }}">
                                                @php
                                                    $api_id = json_decode($plan->stripe_id);
                                                @endphp
                                                <input type="hidden" name="priceId" value="{{ $api_id != NULL ? $api_id->yearly : NULL }}" />
                                                @if ($subscription->plan_id == $plan->id && $subscription->plan_interval == 'year')
                                                    <button type="button" class="btn btn-dark w-100 pt-2 pb-2" disabled>{{ __('common.current_plan') }}</button>
                                                @else
                                                    <button type="button" class="btn btn-dark btn-pointer w-100 pt-2 pb-2 js-pay-plan" data-url="{{ url('pay/'.$plan->id.'/yearly') }}">{{ __('common.select_plan') }}</button> 
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-4 border-start">
                            @if ($review)
                            <div>
                                <img class="avatar avatar-xl" src="{{ asset('uploads/brand/' . $review->image) }}" alt="Image">
                                <br>
                                <span class="fs-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none"><path d="M24 0v24H0V0h24ZM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018Zm.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01l-.184-.092Z"/><path fill="currentColor" d="M8.4 6.2a1 1 0 0 1 1.2 1.6c-1.564 1.173-2.46 2.314-2.973 3.31A3.5 3.5 0 1 1 4 14.558a7.565 7.565 0 0 1 .508-3.614C5.105 9.438 6.272 7.796 8.4 6.2Zm9 0a1 1 0 0 1 1.2 1.6c-1.564 1.173-2.46 2.314-2.973 3.31A3.5 3.5 0 1 1 13 14.558a7.565 7.565 0 0 1 .508-3.614c.598-1.506 1.764-3.148 3.892-4.744Z"/></g></svg>
                                </span>
                                <span class="fs-5">{{ $review->review }}</span>
                                <p class="fs-5 mt-2">-- {{ $review->name }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="speechModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('common.speech_to_text') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ url('audio/create') }}" class="js-create-project">
                @csrf
                <div class="modal-body">
                    <div>
                        <input type="text" class="form-control form-control-sm rounded-btn shadow-none" name="name" placeholder="{{ __('common.project_name') }}" autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer bg-grey-light">
                    <button type="button" class="btn btn-sm btn-secondary rounded-btn" data-bs-dismiss="modal">{{ __('common.close') }}</button>
                    <button type="submit" class="btn btn-sm btn-dark rounded-btn">{{ __('common.save_changes') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Content -->
@endsection()