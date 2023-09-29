@extends('user.layout')
@section('content')
@php
    $content = Helper::content_generated();
@endphp
<!-- Content -->
<div class="navbar-sidebar-aside-content content-space-1 content-space-md-2 px-lg-5 px-xl-10">
    <div class="">
        <div class="row align-items-center">
          <div class="col-sm">
            <h4>{{ __('common.welcome_back') . ' ' . auth()->user()->first_name }} 🎉</h4>
          </div>
        </div>
    </div>
    <div class="mt-4">
        @if(auth()->user()->subscription->plan_id == 2)
        <div class="row">
            <div class="col-4 col-md-3">
                <div class="card card-xs h-100 rounded-0 border-0" style="border-right: 3px solid rgba(220, 224, 229, 0.6)!important;">
                    <div class="card-body p-0">
                        <h4 class="mb-1">{{ $content['count'] }}</h4>
                        <p class="mb-0 font-xs text-muted text-capitalize small pe-3">{{ __('common.words_generated') }}</p>
                        <span class="badge bg-grey-light text-dark mt-2 mb-0 rounded-btn d-none d-md-inline-block">{{ __('common.during_this_period') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-4 col-md-3">
                <div class="card card-xs h-100 rounded-0 border-0" style="border-right: 3px solid rgba(220, 224, 229, 0.6)!important;">
                    <div class="card-body p-0">
                        <h4 class="mb-1">{{ $content['imageCount'] }}</h4>
                        <p class="mb-0 font-xs text-muted text-capitalize small pe-3">{{ __('common.ai_images_generated') }}</p>
                        <span class="badge bg-grey-light text-dark mt-2 mb-0 rounded-btn d-none d-md-inline-block">{{ __('common.during_this_period') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-4 col-md-3">
                <div class="card card-xs h-100 rounded-0 border-0">
                    <div class="card-body p-0">
                        <h4 class="mb-1">{{ CurrencyHelper::format_no_currency($content['secondsCount'] / 60) }}</h4>
                        <p class="mb-0 font-xs text-muted text-capitalize small pe-3">{{ __('common.audio_to_text_minutes') }}</p>
                        <span class="badge bg-grey-light text-dark mt-2 mb-0 rounded-btn d-none d-md-inline-block">{{ __('common.during_this_period') }}</span>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-4 col-md-3">
                <div class="card card-xs h-100 rounded-0 border-0" style="border-right: 3px solid rgba(220, 224, 229, 0.6)!important;">
                    <div class="card-body p-0">
                        <h4 class="mb-1">{{ $content['count'] }}</h4>
                        <p class="mb-0 font-xs text-muted text-capitalize small pe-3">{{ __('common.words_generated') }}</p>
                        <span class="badge bg-grey-light text-dark mt-2 mb-0 rounded-btn d-none d-md-inline-block">{{ __('common.during_this_period') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-4 col-md-3" style="background-color:#f5f5f5;pointer-events: none;">
                <div class="card card-xs h-100 rounded-0 border-0" style="border-right: 3px solid rgba(220, 224, 229, 0.6)!important;">
                    <div class="card-body p-0">
                        <h4 class="mb-1">{{ $content['imageCount'] }}</h4>
                        <p class="mb-0 font-xs text-muted text-capitalize small pe-3">{{ __('common.ai_images_generated') }}</p>
                        <span class="badge bg-grey-light text-dark mt-2 mb-0 rounded-btn d-none d-md-inline-block">{{ __('common.during_this_period') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-4 col-md-3">
                <div class="card card-xs h-100 rounded-0 border-0" style="background-color:#f5f5f5;pointer-events: none;">
                    <div class="card-body p-0">
                        <h4 class="mb-1">{{ CurrencyHelper::format_no_currency($content['secondsCount'] / 60) }}</h4>
                        <p class="mb-0 font-xs text-muted text-capitalize small pe-3">{{ __('common.audio_to_text_minutes') }}</p>
                        <span class="badge bg-grey-light text-dark mt-2 mb-0 rounded-btn d-none d-md-inline-block">{{ __('common.during_this_period') }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    <br>
    
    <div class="mt-4">
        <div class="row">
            @if(Helper::is_trial_mode())
            <div class="col-md-3 mb-3">
                <div class="card shadow-sm bg-white border-0" style="border-radius: 15px;background: url('/images/svg/components/wave-pattern.svg');">
                    <div class="card-body p-3">
                        <h4 class="mb-2 text-capitalize">{{ __('common.upgrade_account') }}</h4>
                        <small class="font-xs">{{ __('common.you_are_in_trial_mode') }}</small>
                        <a href="{{ url('billing') }}" class="btn mt-3 btn-sm btn-dark w-100 rounded-btn">{{ __('common.upgrade') }}</a>
                    </div>
                </div>
            </div>
            @elseif(Helper::userSubscription() != null && (Helper::has_active_subscription() == false || Helper::generate_more_words() == false))
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm bg-white border-0" style="border-radius: 15px;background: url('/images/svg/components/wave-pattern.svg');">
                        <div class="card-body p-3">
                            <h4 class="mb-2 text-capitalize">{{ __('common.renew_subscription') }}</h4>
                            <small class="font-xs">{{ __('common.plan_depleted') }}</small>
                            <a href="{{ url('billing') }}" class="btn mt-3 btn-sm btn-dark w-100 rounded-btn">{{ __('common.renew') }}</a>
                        </div>
                    </div>
                </div>
            @endif
            {{--@if(auth()->user()->subscription->plan_id == 2)--}}
                @if(auth()->user()->subscription->status =='active')
                <div class="col-md-3 mb-3">
                    
                    <!-- Card -->
                    <a href="{{ url('chat') }}" class="card card-xs shadow-sm h-100 bg-cover-image bg-cover-image-6" role="button">
                        <div class="card-body">
                            <h6 class="mb-0 text-capitalize">{{ __('common.chat_with_ai') }}</h6>
                            <small class="text-muted font-xs">{{ __('common.prompt_ai_to_chat_with_you') }}</small>
                        </div>
                    </a>
                    <!-- End Card -->
                </div>
                <div class="col-md-3 mb-3">
                    <!-- Card -->
                    <a href="{{ route('prompts_user') }}" class="card card-xs shadow-sm text-start h-100 bg-cover-image bg-cover-image-2">
                        <div class="card-body">
                            <h6 class="mb-0 text-capitalize">{{ __('common.generate_content') }}</h6>
                            <small class="text-muted font-xs">{{ __('common.prompt_ai_to_create_content') }}</small>
                        </div>
                    </a>
                    <!-- End Card -->
                </div>
                <div class="col-md-3 mb-3">
                    <!-- Card -->
                    <a href="javascript:void()" class="card card-xs shadow-sm h-100 bg-cover-image bg-cover-image-3" data-bs-toggle="modal" data-bs-target="#createImageModal" role="button">
                        <div class="card-body">
                            <h6 class="mb-0 text-capitalize">{{ __('common.generate_ai_image') }}</h6>
                            <small class="text-muted font-xs">{{ __('common.prompt_ai_to_generate_images') }}</small>
                        </div>
                    </a>
                    <!-- End Card -->
                </div>
                <div class="col-md-3 mb-3">
                    <!-- Card -->
                    <a href="javascript:void()" class="card card-xs shadow-sm h-100 bg-cover-image bg-cover-image-4" data-bs-toggle="modal" data-bs-target="#speechModal" role="button">
                        <div class="card-body">
                            <h6 class="mb-0 text-capitalize">{{ __('common.speech_to_text') }}</h6>
                            <small class="text-muted font-xs">{{ __('common.prompt_ai_to_transcribe') }}</small>
                        </div>
                    </a>
                    <!-- End Card -->
                </div>
            @else

            <div class="col-md-3 mb-3" style="background-color:#f5f5f5;pointer-events: none;">
                <!-- Card -->
                <a href="{{ url('chat') }}" class="card card-xs shadow-sm h-100 bg-cover-image bg-cover-image-6" role="button">
                    <div class="card-body">
                        <h6 class="mb-0 text-capitalize">{{ __('common.chat_with_ai') }}</h6>
                        <small class="text-muted font-xs">{{ __('common.prompt_ai_to_chat_with_you') }}</small>
                    </div>
                </a>
                <!-- End Card -->
            </div>
            <div class="col-md-3 mb-3">
                <!-- Card -->
            
                <a href="{{ route('prompts_user') }}" class="card card-xs shadow-sm text-start h-100 bg-cover-image bg-cover-image-2">
                    <div class="card-body">
                        <h6 class="mb-0 text-capitalize">{{ __('common.generate_content') }}</h6>
                        <small class="text-muted font-xs">{{ __('common.prompt_ai_to_create_content') }}</small>
                    </div>
                </a>
                <!-- End Card -->
            </div>
            <div class="col-md-3 mb-3" style="background-color:#f5f5f5;pointer-events: none;">
                <!-- Card -->
                <a href="javascript:void()" class="card card-xs shadow-sm h-100 bg-cover-image bg-cover-image-3" data-bs-toggle="modal" data-bs-target="#createImageModal" role="button">
                    <div class="card-body">
                        <h6 class="mb-0 text-capitalize">{{ __('common.generate_ai_image') }}</h6>
                        <small class="text-muted font-xs">{{ __('common.prompt_ai_to_generate_images') }}</small>
                    </div>
                </a>
                <!-- End Card -->
            </div>
            <div class="col-md-3 mb-3" style="background-color:#f5f5f5;pointer-events: none;">
                <!-- Card -->
                <a href="javascript:void()" class="card card-xs shadow-sm h-100 bg-cover-image bg-cover-image-4" data-bs-toggle="modal" data-bs-target="#speechModal" role="button">
                    <div class="card-body">
                        <h6 class="mb-0 text-capitalize">{{ __('common.speech_to_text') }}</h6>
                        <small class="text-muted font-xs">{{ __('common.prompt_ai_to_transcribe') }}</small>
                    </div>
                </a>
                <!-- End Card -->
            </div>
            @endif
        </div>
    </div>
    <br>
    
    <div class="mt-5">
        <div class="row align-items-center">
            <div class="col-6">
                <h5>{{ __('common.recent_activity') }}</h5>
            </div>
            <div class="col-6">
                <a href="{{ url('documents') }}" class="float-end mb-0 font-xs link-secondary link-pointer">
                    {{ __('common.view_all') }}
                </a>
              </div>
        </div>
        <div class="mt-3 row">
            <div class="col-md-12">
                <div class="border rounded bg-white">
                    @foreach ($projects as $project)
                    <div role="button" class="border-bottom p-2 project-row">
                        <div class="row">
                            <div class="col-8 view-template d-flex align-items-center" data-url="{{ url('project/'.$project->uuid) }}">
                                <span class="me-2">
                                    @if ($project->type == 'content')
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="M20 12V5.749a.6.6 0 0 0-.176-.425l-3.148-3.148A.6.6 0 0 0 16.252 2H4.6a.6.6 0 0 0-.6.6v18.8a.6.6 0 0 0 .6.6H11M8 10h8M8 6h4m-4 8h3m6.954 2.94l1-1a1.121 1.121 0 0 1 1.586 0v0a1.121 1.121 0 0 1 0 1.585l-1 1m-1.586-1.586l-2.991 2.991a1 1 0 0 0-.28.553l-.244 1.557l1.557-.243a1 1 0 0 0 .553-.28l2.99-2.992m-1.585-1.586l1.586 1.586"></path><path d="M16 2v3.4a.6.6 0 0 0 .6.6H20"></path></g></svg> 
                                    @elseif($project->type == 'image')
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="m14 2l6 6v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8m4 18V9h-5V4H6v16h12m-1-7v6H7l5-5l2 2m-4-5.5A1.5 1.5 0 0 1 8.5 12A1.5 1.5 0 0 1 7 10.5A1.5 1.5 0 0 1 8.5 9a1.5 1.5 0 0 1 1.5 1.5Z"></path></svg>  
                                    @elseif($project->type == 'audio')
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none"><path d="M24 0v24H0V0h24ZM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018Zm.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01l-.184-.092Z"/><path fill="currentColor" d="M12 3a1 1 0 0 1 .993.883L13 4v16a1 1 0 0 1-1.993.117L11 20V4a1 1 0 0 1 1-1ZM8 6a1 1 0 0 1 1 1v10a1 1 0 1 1-2 0V7a1 1 0 0 1 1-1Zm8 0a1 1 0 0 1 1 1v10a1 1 0 1 1-2 0V7a1 1 0 0 1 1-1ZM4 9a1 1 0 0 1 1 1v4a1 1 0 1 1-2 0v-4a1 1 0 0 1 1-1Zm16 0a1 1 0 0 1 .993.883L21 10v4a1 1 0 0 1-1.993.117L19 14v-4a1 1 0 0 1 1-1Z"/></g></svg>
                                    @endif
                                </span>
                                <small class="font-xs">{{ $project->name }}</small>
                                @if ($project->type == 'image')
                                @php
                                    $images = DB::table('image_contents')->where('document_id', $project->id)->where('deleted_at', null)->limit(5)->orderBy('id', 'desc')->get();
                                @endphp
                                <div class="grid_groups_wrapper ms-2">
                                    <div class="group">
                                        <a class="route d-flex">
                                            @foreach ($images as $image)
                                            <div class="rounded-circle default-avatar member-overlap-item" style="background: url({{ asset('uploads/images/' . $image->url) }}) 0 0 no-repeat; background-size: cover;">
                                            </div>
                                            @endforeach
                                        </a>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="col-4">
                                <div class="float-end">
                                    <div class="d-flex align-items-center">
                                        <small class="text-muted font-xs">{{ Helper::time_ago($project->updated_at) }}</small>
                                        <div class="ms-3">
                                            <span role="button" id="dropdownMenuReference" data-bs-toggle="dropdown" aria-expanded="false" data-reference="parent">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M16 12a2 2 0 0 1 2-2a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2m-6 0a2 2 0 0 1 2-2a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2m-6 0a2 2 0 0 1 2-2a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2Z"/></svg>
                                            </span>
                                            <div class="dropdown-menu dropdown-menu-sm" aria-labelledby="dropdownMenuReference">
                                                <a class="dropdown-item view-template font-sm" href="{{ url('project/'.$project->uuid) }}">{{ __('common.view_edit') }}</a>
                                                @if ((Helper::is_trial_mode() || Helper::subscription()->plan->allow_export == 1) && $project->type == 'content')
                                                <a href="{{ url('project/export/'.$project->uuid.'/word') }}" class="dropdown-item font-sm">{{ __('common.download_as_word') }}</a>
                                                <a href="{{ url('project/export/'.$project->uuid.'/pdf') }}" class="dropdown-item font-sm">{{ __('common.download_as_pdf') }}</a>
                                                @endif
                                                <div class="dropdown-divider"></div>
                                                <button class="dropdown-item delete-project font-sm" data-url="{{ url('project/delete/'.$project->uuid) }}">{{ __('common.delete') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
{{--  <div class="viewModal">
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
                                                        $whole = (int) $number;  // 5
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
                                                {{ $plan->words == 0 ? 'Unlimited' : CurrencyHelper::format_number($plan->words) }} {{ __('common.words_mo') }}
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
</div>  --}}
<!-- End Content -->
<div class="modal fade" id="createImageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Generate AI Image') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ url('image/create') }}" class="js-create-project">
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
{{--  @include('user.templates.main')  --}}
@endsection()