@extends('user.layout')
@section('content')
@php
    $words = Helper::content_generated();
@endphp
<div class="navbar-sidebar-aside-content content-space-1 content-space-md-2 px-lg-5 px-xl-10">
    <div class="list-group list-group-horizontal d-sm-block d-md-none font-xs">
        <a class="list-group-item {{ Request::segment(1) == 'settings' ? 'active' : '' }}" href="{{ url('settings') }}">
            <i class="bi-person list-group-icon"></i> {{ __('common.my_profile') }}
        </a>
        <a class="list-group-item {{ Request::segment(1) == 'billing' ? 'active' : '' }}" href="{{ url('billing') }}">
            <i class="bi-person list-group-icon"></i> {{ __('common.billing') }}
        </a>
    </div>
    <div class="d-none d-md-block">
        <div class="row align-items-center">
          <div class="col-sm">
            <h4 class="text-underline">{{ __('common.billing') }}</h4>
          </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="mb-5">
                <h6 class="mb-0">{{ __('common.subscription') }}</h6>
                @if (Helper::is_trial_mode())
                    <small>{{ __('You are currently in trial mode. Select a plan to continue.') }}</small>
                @else
                    @if ($subscription->plan_id == NULL)
                        <small>{{ __('Please subscribe to a plan by selecting any of the plans below.') }}</small>
                    @else
                        @if (Helper::has_active_subscription() == true && Helper::generate_more_words() == true)
                        <small>{{ __('You are currently subscribed to') }} {{ $subscription->plan->name }}. {{ __('Your plan expires on') }} {{ date('d M Y H:i', strtotime(Helper::user_subscription()->recurring_at)) }} 
                            @if (Helper::user_subscription()->words != 0)
                                {{ __('or when you reach') }} {{ CurrencyHelper::format_number($words['limit']) }} {{ __('words limit, whichever comes first') }}.  
                            @endif
                        </small>
                        @endif
                    @endif
                @endif
                
                @if ($subscription->plan != null && (Helper::has_active_subscription() == false || Helper::generate_more_words() == false))
                <div class="mt-2">
                    <button type="button" class="btn btn-dark btn-pointer btn-sm pt-2 pb-2 js-pay-plan" data-url="{{ url('pay/'.$subscription->plan_id.'/yearly') }}">Renew Your Subscription</button>
                </div>
                @endif
            </div>
            <div class="mb-5">
                <h6 class="mb-0">{{ __('common.words_generated') }}</h6>
                @if (Helper::has_active_subscription())
                    <small>{{ CurrencyHelper::format_number($words['count']) }}/{{ $words['limit'] == 0 ? __('common.unlimited') : CurrencyHelper::format_number($words['limit']) }} {{ __('common.words_generated') }}</small>
                @else
                    <small>0/0 {{ __('common.words_generated') }}</small>
                @endif
            </div>
            <ul class="nav nav-segment mb-4 ms-0" id="navTab1" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link plan-toggle {{ $subscription->plan_interval != 'year' ? 'active' : '' }}" data-type="monthly" id="nav-resultTab1" href="#nav-result1" data-bs-toggle="pill" data-bs-target="#nav-result1" role="tab" aria-controls="nav-result1" aria-selected="true">{{ __('common.monthly') }}</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link plan-toggle {{ $subscription->plan_interval == 'year' ? 'active' : '' }}" data-type="yearly" id="nav-htmlTab1" href="#nav-html1" data-bs-toggle="pill" data-bs-target="#nav-html1" role="tab" aria-controls="nav-html1">{{ __('common.yearly') }}</a>
                </li>
            </ul>
            <div class="row">
                @foreach ($plans as $plan)
                <div class="col-lg-4 mb-3 mb-4">
                    <div class="card shadow-sm card-lg h-100">
                        <div class="card-body pt-4 ps-4 pe-4 pb-3">
                            <div class="mb-3">
                                <h5 class="mb-0">{{ $plan->name }}</h5>
                                <small class="font-xs">{{ $plan->description }}</small>
                            </div>
                            <div class="d-flex {{ $subscription->plan_interval == 'year' ? 'd-none' : '' }} plan-period">
                                <div class="flex-shrink-0">
                                    <span class="display-6 lh-1 text-dark fs-2">{{ CurrencyHelper::format_with_currency($plan->monthly_price) }}</span>
                                </div>
                                <div class="flex-grow-1 align-self-end ms-3">
                                    <span class="d-block fw-bold text-muted">{{ __('common.mo') }}</span>
                                </div>
                            </div>
                            <div class="d-flex {{ $subscription->plan_interval != 'year' ? 'd-none' : '' }} plan-period">
                                <div class="flex-shrink-0">
                                    <span class="display-6 lh-1 text-dark fs-2">{{ CurrencyHelper::format_with_currency($plan->yearly_price) }}</span>
                                </div>
                                <div class="flex-grow-1 align-self-end ms-3">
                                    <span class="d-block fw-bold text-muted">{{ __('common.yr') }}</span>
                                </div>
                            </div>
                            <hr>
                            <small class="text-muted font-xs">
                                <b>{{ $plan->words == 0 ? __('common.unlimited') : CurrencyHelper::format_number($plan->words) }}</b> {{ __('common.words_mo') }}
                            </small>
                            <br>
                            <small class="text-muted font-xs">
                                <b>{{ $plan->image_count == 0 ? __('common.unlimited') : CurrencyHelper::format_number($plan->image_count) }}</b> {{ __('Images per month') }}
                            </small>
                            <br>
                            <small class="text-muted font-xs">
                                <b>{{ $plan->minutes == 0 ? __('common.unlimited') : CurrencyHelper::format_number($plan->minutes) }}</b> {{ __('minutes per month') }}
                            </small>
                            <br>
                            <small class="text-muted font-xs">
                                <b>{{ $plan->file_size == 0 ? __('common.unlimited') : CurrencyHelper::format_number($plan->file_size).__('MB') }}</b> {{ __('File size limit') }}
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
                            <form class="plan-period {{ $subscription->plan_interval == 'year' ? 'd-none' : '' }}" action="{{ url('stripe-checkout') }}">
                                @php
                                    $api_id = json_decode($plan->stripe_id);
                                @endphp
                                <input type="hidden" name="priceId" value="{{ $api_id != NULL ? $api_id->monthly : NULL }}" />
                                @if ($subscription->plan_id == $plan->id && $subscription->plan_interval == 'month')
                                    <button type="button" class="btn btn-dark w-100 pt-2 pb-2" disabled>{{ __('common.current_plan') }}</button>
                                @else
                                    <button type="button" class="btn btn-dark btn-pointer w-100 pt-2 pb-2 js-pay-plan" data-url="{{ url('pay/'.$plan->id.'/monthly') }}">{{ __('common.select_plan') }}</button> 
                                @endif
                            </form>
                            <form class="plan-period {{ $subscription->plan_interval != 'year' ? 'd-none' : '' }}" action="{{ url('stripe-checkout') }}">
                                @php
                                    $api_id = json_decode($plan->stripe_id);
                                @endphp
                                <input type="hidden" name="priceId" value="{{ $api_id != NULL ? $api_id->yearly : NULL }}" />
                                @if ($subscription->plan_id == $plan->id && $subscription->plan_interval == 'year')
                                    <button type="button" class="btn btn-dark w-100 pt-2 pb-2" disabled>{{ __('common.current_plan') }}</button>
                                @else
                                    <button type="button" class="btn btn-dark btn-pointer w-100 pt-2 pb-2 js-pay-plan" data-url="{{ url('pay/'.$plan->id.'/yearly') }}">{{ __('common.select_plan') }}</button> 
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-4 col-md-9">
                <h6>{{ __('Billing History') }}</h6>
                <div class="h-100 scrollbox overflow-y-auto" id="table-render">
                    <table class="table small">
                        <thead class="thead-light">
                            <tr>
                                <th>
                                    <span>{{ __('Date') }}</span>
                                </th>
                                <th>
                                    <span>{{ __('Description') }}</span>
                                </th>
                                <th>
                                    <span>{{ __('Amount') }}</span>
                                </th>
                                <th>
                                    <span>{{ __('Status') }}</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($invoices as $row){?>
                            <tr>
                                <td class="text-capitalize">
                                    <span>{{ date('M d, Y', strtotime($row->billing_date)) }}</span>
                                </td>
                                <td>
                                    <small><u>{{ Helper::config('billing_invoice_prefix').$row->billing_id }}</u> {{ __('Payment via') }} {{ $row->processor }}</small>
                                    <span class="badge bg-light text-dark badge-sm text-capitalize">{{ $row->status }}</span>
                                </td>
                                <td>
                                    <span class="font-12">{{ CurrencyHelper::format_with_currency($row->amount, $row->currency) }}</span>
                                </td>
                                <td>
                                    <a href="{{ url('invoice/'.$row->billing_id) }}" target="_blank" class="small link-secondary link-bordered">{{ __('View/Download') }}</a>
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>				
                    <div class="d-flex fs-7 float-end mt-4">
                        <nav>
                            {{  $invoices->links('pagination::bootstrap-4')  }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="viewModal"></div>
@endsection