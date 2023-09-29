@extends('user.layout')
@section('content')
<!-- Content -->
<style>
.toast {
  position: fixed;
  top: 20px;
  right: 20px;
  background-color: #333;
  color: #fff;
  padding: 10px 20px;
  border-radius: 5px;
  opacity: 0;
  animation: toastAnimation 1s ease-in-out;
}

@media only screen and (max-width: 600px) {
    .search{
        margin-top: 20px !important;
    }
}

@keyframes toastAnimation {
  0% {
    transform: scale(0);
    border: 1px solid transparent;
  }

  50% {
    transform: scale(1.2);
    border-color: #fff;
  }

  100% {
    transform: scale(1);
    border-color: #fff;
  }
}

.toast.show {
  opacity: 1;
}

</style>

<div class="navbar-sidebar-aside-content content-space-1 content-space-md-2 px-lg-5 px-xl-10">
    <div class="">
        <div class="row">
            <div class="col-md-8 col-6">
                <h4 class="mb-0">{{ __('Prompts') }}</h4>
            </div>
            <div class="col-md-2 col-6 text-end">
                <div class="btn-group">
                    <div class="add-token rounded @if($subscription->available_token<10) bg-danger @elseif($subscription->available_token<50) bg-warning @else bg-secondary @endif d-inline-block p-2">
                        <span class="icon-bg mx-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 14 14"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="9" cy="5.5" rx="4.5" ry="2"></ellipse><path d="M4.5 5.5v6c0 1.1 2 2 4.5 2s4.5-.9 4.5-2v-6"></path><path d="M13.5 8.5c0 1.1-2 2-4.5 2s-4.5-.9-4.5-2m4.4-7A6.77 6.77 0 0 0 5 .5C2.51.5.5 1.4.5 2.5c0 .59.58 1.12 1.5 1.5"></path><path d="M2 10C1.08 9.62.5 9.09.5 8.5v-6"></path><path d="M2 7C1.08 6.62.5 6.09.5 5.5"></path></g></svg>
                        </span>
                        <span class="text-light" id="token_number">
                            {{$subscription->available_token}}&nbsp;&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-12">
                <div class="input-group ">
                    <select id="sortSelect" class="search form-control form-control-sm rounded-btn shadow-none bg-grey-light border-0">
                        <option disabled selected>Sort By</option>
                        <option value="1">A-Z Sort</option>
                        <option value="2">Z-A Sort</option>
                        <option value="3">New</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="row">
                    @foreach ($plans as $plan)
                        <button type="button" class="btn btn-dark btn-pointer w-100 pt-2 pb-2 js-pay-plan d-none" id="js-pay-plan-{{ $plan->id }}" data-url="{{ url('pay/'.$plan->id.'/monthly') }}">{{ __('common.select_plan') }}</button>
                        <div class="col-md-3">
                            <!--<button for="allCat" class="btn fw-categgory btn-sm @if ($subscription->plan_id == $plan->id) btn-dark btn-pointer @else @endif ps-3 pt-2 pb-2 w-100 text-start mb-2">-->
                            <!--     {{ $plan->name }} -->
                            <!-- </button>-->
                            <label for="planId{{$plan->id}}" class="btn fw-plan btn-sm @if ($subscription->plan_id == $plan->id) btn-dark btn-pointer @else @endif ps-3 pt-2 pb-2 w-100 text-start mb-2 text-capitalize">
                                <input type="radio" name="pan" class="plan-radio d-none" id="planId{{$plan->id}}" value="{{$plan->id}}">{{ $plan->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-12">
                <hr class="my-2">
            </div>
            <div class="col-md-3 mb-3">
                <div class="dropdown">
                    <button class="form-control form-control-sm rounded-btn shadow-none bg-grey-light border-0 dropdown-toggle w-100 dropdown-toggle px-3 py-2" href="#" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="true">
                    Filter By Category
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" data-bs-popper="static">
                        <label for="allCat" class="btn fw-categgory btn-sm btn-dark btn-pointer ps-3 pt-2 pb-2 w-100 text-start mb-2 rounded-btn">
                            <input type="radio" name="category" id="allCat" class="category-radio d-none" checked value="0">{{ __('All Templates') }}
                            </label>
                        @foreach ($categories as $category)
                            <label for="catId{{$category->id}}" class="btn fw-categgory btn-sm  ps-3 pt-2 pb-2 w-100 text-start mb-2 rounded-btn text-capitalize">
                                <input type="radio" name="category" class="category-radio d-none" id="catId{{$category->id}}" value="{{$category->id}}">{{ $category->category_name }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
             <div class="input-group">
                    <span class="input-group-text rounded-btn border-0 bg-grey-light ps-4 pe-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M11 2c4.968 0 9 4.032 9 9s-4.032 9-9 9s-9-4.032-9-9s4.032-9 9-9zm0 16c3.867 0 7-3.133 7-7c0-3.868-3.133-7-7-7c-3.868 0-7 3.132-7 7c0 3.867 3.132 7 7 7zm8.485.071l2.829 2.828l-1.415 1.415l-2.828-2.829l1.414-1.414z"></path>
                        </svg>
                    </span>
                    <select class="subcat form-control form-control-sm rounded-btn shadow-none bg-grey-light border-0 template-search" placeholder="{{ __('Filter By SubCategory') }}">
                        <option selected disabled value="">Filter By SubCategory</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="input-group">
                    <span class="input-group-text rounded-btn border-0 bg-grey-light ps-4 pe-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M11 2c4.968 0 9 4.032 9 9s-4.032 9-9 9s-9-4.032-9-9s4.032-9 9-9zm0 16c3.867 0 7-3.133 7-7c0-3.868-3.133-7-7-7c-3.868 0-7 3.132-7 7c0 3.867 3.132 7 7 7zm8.485.071l2.829 2.828l-1.415 1.415l-2.828-2.829l1.414-1.414z"></path>
                        </svg>
                    </span>
                    <input type="text" class="form-control form-control-sm rounded-btn shadow-none bg-grey-light border-0 template-search" placeholder="{{ __('Search Template') }}" data-url="{{ url('templates-search/'.Request::segment(2)) }}">
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <label for="collection" class="btn fw-plan btn-sm ps-3 pt-2 pb-2 w-100 text-start mb-2 text-capitalize">
                    <input type="radio" name="pan" class="plan-radio d-none" id="collection" value="collection">Collection
                </label>
            </div>
            <div class="col-md-12">
                <div class="card border-0">
                    <div class="card-body py-0" id="filter-tag"></div>
                </div>
            </div>
            
        </div>
        <div class="mt-3 row">
            <!--<div class="col-md-3" style="width: 20%;">-->
                <!--<div class="border rounded bg-white" id="table-render">-->
                <!--    <div class="bg-grey-light ps-2 pe-2 pt-2 pb-2 rounded h-100">-->
                <!--        <h6 class="mt-2 mb-3">Filter By Category</h6>-->
                <!--        <label for="allCat" class="btn fw-categgory btn-sm btn-dark btn-pointer ps-3 pt-2 pb-2 w-100 text-start mb-2 rounded-btn" -->
                <!--        >-->
                <!--            <input type="radio" name="category" id="allCat" class="category-radio d-none" checked value="0">{{ __('All Templates') }}-->
                <!--            </label>-->
                <!--        @foreach ($categories as $category)-->
                <!--            <label for="catId{{$category->id}}" class="btn fw-categgory btn-sm  ps-3 pt-2 pb-2 w-100 text-start mb-2 rounded-btn text-capitalize">-->
                <!--                <input type="radio" name="category" class="category-radio d-none" id="catId{{$category->id}}" value="{{$category->id}}">{{ $category->category_name }}-->
                <!--            </label>-->
                <!--        @endforeach-->
                <!--    </div>-->
                <!--</div>-->
            <!--</div>-->
            <div class="col-md-12">
                <div class="bg-white grid-items" style="overflow: revert;">
                    <div class="row" id="gridItemsContainer">
                        @if($plan_status == 0)
                            @if(count($templates)>0)
                                @foreach ($templates as $template)
                                <div class="col-md-3 mb-3">
                                    <!-- Card -->
                                    <div class="card card-xs shadow-sm text-start h-100 bg-cover-image bg-cover-image-5" role="button">
                                        <div class="card-body js-select-template p-4" data-url="{{ url('project/create/' . $template->id) }}">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="mb-0 text-capitalize">{{ $template->name }}</h6> &nbsp;&nbsp;
                                                <small class="font-xs ml-5">{{ $template->category_new->category_name ?? 'Free style' }}</small>
                                            </div>
                                            <small class="text-muted font-xs">{{ $template->description }}</small>
                                        </div>
                                        @if($template->monthly_price != 0 && $template->yearly_price != 0)    
                                            <div class="text-end mb-3">
                                                <span class=" px-3">
                                                    <span class="js-select-template" data-url="{{ url('project/create/' . $template->id) }}" >Discover</span>
                                                <a href="#" type="button" class="btn-dark btn-pointerr px-3">
                                                    <span class=" tooltip" data-toggle="tooltip" data-placement="top" title="Add To collection"  onclick="addToCollection({{$template->id}})" style="opacity:1;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width=20><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zM200 344V280H136c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V168c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H248v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/></svg>
                                                    </span>
                                                </a>
                                                </span>
                                            </div>
                                        @else
                                            
                                            <div class="text-end mb-3">
                                                <a href="#" type="button" class="btn-dark btn-pointerr px-3 copy-prompt">
                                                    <span class="badge badge-primary tooltip" data-toggle="tooltip" data-placement="top" title="Copy to Clipboard"  onclick="copyPrompt(this)" style="opacity:1;">
                                                        <input class="d-none" value="{{ $template->description }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width=20>
                                                            <path d="M64 464H288c8.8 0 16-7.2 16-16V384h48v64c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V224c0-35.3 28.7-64 64-64h64v48H64c-8.8 0-16 7.2-16 16V448c0 8.8 7.2 16 16 16zM224 352c-35.3 0-64-28.7-64-64V64c0-35.3 28.7-64 64-64H448c35.3 0 64 28.7 64 64V288c0 35.3-28.7 64-64 64H224z" />
                                                        </svg>
                                                    </span>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="col-md-3 mb-3">
                                    <div class="card card-xs shadow-sm text-start h-100" role="button">
                                        <div class="card-body p-4">
                                            <h6 class="mb-3 text-capitalize" onclick="upgrade">Upgrade Plan to access Prompt</h6>
                                            <button type="button" class="btn btn-dark btn-pointer w-100 pt-2 pb-2" onclick="showModal()">Select Plan</button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else 
                            <div class="col-md-3 mb-3">
                                <div class="card card-xs shadow-sm text-start h-100" role="button">
                                    <div class="card-body p-4">
                                        <h6 class="mb-3 text-capitalize" onclick="upgrade">Upgrade Plan to access Prompt</h6>
                                        <button type="button" class="btn btn-dark btn-pointer w-100 pt-2 pb-2 js-pay-plan" data-url="{{ url('pay/'.$subscription->plan_id.'/yearly') }}">Renew Plan</button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="d-flex fs-7 float-end mt-4">
                        <nav>
                            {{ $templates->links('pagination::bootstrap-4') }}
                        </nav>
                    </div>
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
                        <h5 class="modal-title">{{ __('Please Change the plan to Access this Area.') }}</h5>
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
                                                        $whole = (int) $number;  // 5
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
                                                {{ $plan->words == 0 ? 'Unlimited' : CurrencyHelper::format_number($plan->words) }} {{ __('words /mo') }}
                                            </small>
                                            <br>
                                            <small class="text-muted font-xs 111">
                                                @if ($plan->allow_export)
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path fill="#0ABF53" d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10s10-4.5 10-10S17.5 2 12 2m-2 15l-5-5l1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9Z"/></svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10s10-4.5 10-10S17.5 2 12 2zm3.7 12.3c.4.4.4 1 0 1.4c-.4.4-1 .4-1.4 0L12 13.4l-2.3 2.3c-.4.4-1 .4-1.4 0c-.4-.4-.4-1 0-1.4l2.3-2.3l-2.3-2.3c-.4-.4-.4-1 0-1.4c.4-.4 1-.4 1.4 0l2.3 2.3l2.3-2.3c.4-.4 1-.4 1.4 0c.4.4.4 1 0 1.4L13.4 12l2.3 2.3z"/></svg>
                                                @endif
                                                {{ __('common.export_as_pdf_word') }}
                                            </small>
                                            <br>
                                            <small class="text-muted font-xs 111">
                                                <div class='plan-period {{ $subscription->plan_interval != 'year' ? 'd-none' : '' }}'>
                                                    @if ($plan->yearly_token > 0)
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path fill="#0ABF53" d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10s10-4.5 10-10S17.5 2 12 2m-2 15l-5-5l1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9Z"/></svg>
                                                        {{ $plan->yearly_token }}
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10s10-4.5 10-10S17.5 2 12 2zm3.7 12.3c.4.4.4 1 0 1.4c-.4.4-1 .4-1.4 0L12 13.4l-2.3 2.3c-.4.4-1 .4-1.4 0c-.4-.4-.4-1 0-1.4l2.3-2.3l-2.3-2.3c-.4-.4-.4-1 0-1.4c.4-.4 1-.4 1.4 0l2.3 2.3l2.3-2.3c.4-.4 1-.4 1.4 0c.4.4.4 1 0 1.4L13.4 12l2.3 2.3z"/></svg>
                                                    @endif
                                                    Token
                                                </div>
                                                <div class='plan-period {{ $subscription->plan_interval == 'year' ? 'd-none' : '' }}'>
                                                    @if ($plan->monthly_token > 0)
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path fill="#0ABF53" d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10s10-4.5 10-10S17.5 2 12 2m-2 15l-5-5l1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9Z"/></svg>
                                                        {{ $plan->monthly_token }}
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10s10-4.5 10-10S17.5 2 12 2zm3.7 12.3c.4.4.4 1 0 1.4c-.4.4-1 .4-1.4 0L12 13.4l-2.3 2.3c-.4.4-1 .4-1.4 0c-.4-.4-.4-1 0-1.4l2.3-2.3l-2.3-2.3c-.4-.4-.4-1 0-1.4c.4-.4 1-.4 1.4 0l2.3 2.3l2.3-2.3c.4-.4 1-.4 1.4 0c.4.4.4 1 0 1.4L13.4 12l2.3 2.3z"/></svg>
                                                    @endif
                                                    Token
                                                </div>
                                                
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
<div class="add-token-model">
    <div class="modal fade" id="addTokenModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-bottom pb-2">
                    <div>
                        <h5 class="modal-title">{{ __('Purchase More Token to Access this Area.') }}</h5>
                        <!-- <small>{{ __('common.subscribe_to_plan') }}</small> -->
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-5">
                        <div class='col-md-12'>
                            <label><small>{{ __('Token :') }}</small></label>
                            <input list="browsers" name="token" class='form-control  token-count' data-amount='{{ $subscription->getPlan->editional_token_price }}' placeholder="add your token count" /></label>
                            
                            <datalist id="browsers">
                                <option value="10">
                                <option value="20">
                                <option value="30">
                            </datalist>
                            <span class="mt-1 add-token-error text-danger"></span>
                        </div>
                        <div class='col-md-6 mt-3'>
                            @if($subscription->getPlan->editional_token_price > 0)
                            Per Token : {{$subscription->getPlan->editional_token_price}}
                            @else
                                <a onclick="showModal()" href="#" style="text-decoration:underline; color:blue;">Token not available</a>
                            @endif
                        </div>
                        <div class='col-md-6 mt-3'>
                            Total Amount: <span class="totalAmount"></span>
                        </div>
                        <div class='col-md-12 mt-3 text-center'>
                            <button type="button" class="btn btn-dark btn-pointer pt-2 pb-2 add_token_form_submit">Pay</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://js.stripe.com/v3/"></script>
<script>
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
    
    
    function copyPrompt(element) {
      var inputField = $(element).find('input');
      var valueToCopy = inputField.val();
    
      var textarea = $('<textarea>').val(valueToCopy).appendTo('body').select();
      document.execCommand('copy');
      textarea.remove();
    
      // Create a custom toast message element
      var toast = $('<div class="toast  bg-dark text-light d-inline-block"></div>').html('<span>Prompt copied: </span> <small class="small text-muted">' + valueToCopy+'</small>').appendTo('body');
    
      // Show the toast message
      toast.addClass('show');
    
      // Remove the toast after a delay
      setTimeout(function() {
        toast.removeClass('show');
        setTimeout(function() {
          toast.remove();
        }, 1000); // Delay for the animation duration (1s) before removing the toast element
      }, 3000);
    }

    

    function upgrade(){
        $('#paymentModal').modal('show');
    }

    function showModal() {
        $('#addTokenModel').modal('hide');
        $('#paymentModal').modal('show');
    }
    
    
    $(document).ready(function() {

        $('.add-token').on('click', function() {
            $('#addTokenModel').modal('show');
        });

        $('.token-count').on('keydown keyup', function() {

            var amount = $(this).attr('data-amount');
            var token = $(this).val();
            var totaAmount = amount * token;
            $("input[name='token']").val(token);
            $("input[name='token_amount']").val(totaAmount);
            $('.totalAmount').text("$"+totaAmount);
        });

        $('.add_token_form_submit').on('click', function() {

            var amount = $('.token-count').attr('data-amount');
            var token = $('.token-count').val();
            var totalAmount = amount * token;
            var url = '{{ url("/prompts/add/token/") }}';
            if((token <= 0)){    
                $('.add-token-error').text('Please add Token');
            }else if(totalAmount <= 0){
                $('.add-token-error').text('Token not available, Please Change Your Plan');
            }
            else{

                $(this).addClass('add-token-model-payment');
                $(this).attr('data-url', url+'/'+token+'/'+totalAmount);
                performClickLogic();
            }
        });

        function performClickLogic() {
            $('#addTokenModel').modal('hide');
            $(this).click();
        }

        document.addEventListener("click", function(event) {
            if (event.target.classList.contains('add-token-model-payment')) {
                const viewModal = document.querySelector('.viewModal');

                let myModalEl = document.getElementById('paymentModal');

                if(myModalEl){
                    let modal = bootstrap.Modal.getInstance(myModalEl)
                }

                var payButton = event.target;
                const url = payButton.getAttribute('data-url');
                
                fetch(url)
                .then(response => response.text())
                .then(data => {
                    // append the resultant view to the ViewModal div
                    viewModal.innerHTML = data;
                    const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'), {});
                    paymentModal.show();
                })
                .catch(error => console.error(error));
            }
        });

        $('.category-radio').on('change', function() {
            radioBtn(this,'category-radio');
        });
        
        $('.plan-radio').on('change', function() {
            radioBtn(this,'plan-radio');
        });
        
     function radioBtn(element,targetClass) {
        var $radio = $(element);
        var $label = $radio.closest('label');
    
        // Remove btn-dark btn-pointer class from all labels
        $('.'+targetClass).closest('label').removeClass('btn-dark btn-pointer');
    
        if ($radio.is(':checked')) {
            $label.removeClass('btn-outline-none').addClass('btn-dark btn-pointer');
            var filterTag = $('#filter-tag');
            var existingTag = filterTag.find('.'+targetClass+'');
            var newTag = $('<span class="btn '+targetClass+' fw-radio btn-sm btn-light py-1 px-2 text-start mb-2 rounded-btn mx-1">' + $label.text() + '</span>');
    
            if (existingTag.length > 0) {
                existingTag.replaceWith(newTag);
            } else {
                filterTag.append(newTag);
            }
        } else {
            $label.removeClass('btn-dark btn-pointer').addClass('btn-outline-none');
            $('#filter-tag').find('.fw-radio').remove();
        }
    }

    });
    
    // sort.js
    $(document).ready(function() {
        $("#sortSelect").on("change", function() {
                short();
            });
            
        $('input[name="category"]').on("change", function() {
                short();
        });
        $('input[name="pan"]').on("change", function() {
                short();
        });
    });
  
    function short(){
        var selectedValue = $('#sortSelect').val();
        var categoryId = $('input[name="category"]:checked').val();
        var planId = $('input[name="pan"]:checked').val();
        var gridItemsContainer = $("#gridItemsContainer");
        
        $.ajax({
            url: "{{ route('templates.sort') }}",
            method: "GET",
            data: { sortValue: selectedValue,categoryId: categoryId,planId:planId },
            beforeSend: function() {
                // Show a loading spinner or any other visual indicator
                gridItemsContainer.html('<div class="text-center">Loading...</div>');
            },
            success: function(response) {
                // Update the grid items container with the sorted template data
                    gridItemsContainer.html(response);
            },
            error: function(xhr, status, error) {
              // Handle any errors that occur during the AJAX request
              console.error(error);
            }
        });
    }
  
    const templateSearch = document.querySelector('.template-search');
    // console.log('Asdfg')
    document.addEventListener("click", function(event) {
        var container = document.querySelector(".user-menu");
        if (!container.contains(event.target)) {
            var elements = document.querySelectorAll('.user-menu');
            for (var i = 0; i < elements.length; i++) {
                elements[i].classList.add('d-none');
            }
        }
    });

    document.addEventListener('click', function(event) {
        let footer = event.target.closest('.user-menu-footer');
        if (!footer) return;
        event.stopPropagation();
        
        let elements = document.querySelectorAll('.user-menu');
        for (let i = 0; i < elements.length; i++) {
            elements[i].classList.toggle('d-none');
        }
    });

    function addToCollection(temp_id){

        var token = {{ $subscription->available_token }};
        if(token > 0){
            var route =  "{{ route('favorite.template',['id'=>'__id__']) }}";
            var collection =1;
            route = route.replace('__id__',temp_id)
            $.ajax({
                url:route,
                method: "GET",
                data:{collection:collection},
                beforeSend: function() {
                },
                success: function(response) {
                        // Create a custom toast message element
                        var toast = $('<div class="toast  bg-dark text-light d-inline-block"></div>').html('<small class="small">' + response.message+'</small>').appendTo('body');
                        if(response.token){
                            $('#token_number').html(response.token)
                        }
                        // Show the toast message
                        toast.addClass('show');
                    
                        // Remove the toast after a delay
                        setTimeout(function() {
                        toast.removeClass('show');
                        setTimeout(function() {
                            toast.remove();
                        }, 1000); // Delay for the animation duration (1s) before removing the toast element
                        }, 3000);

                },
                error: function(xhr, status, error) {
                    // Handle any errors that occur during the AJAX request
                    console.error(error);
                }
            });
        }else{
            $('#addTokenModel').modal('show');
        }
    }

</script>
@endsection
