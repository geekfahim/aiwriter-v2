@extends('admin.layout')
@section('content')
<!-- Page content -->
<div class="content">
    <div class="main-header p-3">
        <div class="row">
            <div class="col-md-6">
                <h3>{{ __('Billing') }}</h3>
                <p class="mt-2 text-capitalize"><span class="text-grey">{{ __('common.dashboard') }}</span> <i class="fa fa-angle-right fa-fw"></i> {{ __('Billing') }}</p>
            </div>
        </div>
    </div>
    <div class="main-body p-3">
        <div class="row h-100">
            <div class="col-md-4">
                <div class="input-group mb-3">
                    <span class="input-group-text bg-white border-0 ps-4">
                        <i class="fa fa-search"></i>
                    </span>
                    <input type="text" class="form-control w-50 bg-white pt-3 pb-3 border-0 search-box" data-url={{ url('admin/billing/search') }} placeholder="{{ __('Search Billing') }}">
                </div>
            </div>
            <div class="minimal-view-col-1 col-md-12  pe-0 mt-4 h-100">
                <div class="h-100 pt-3 scrollbox overflow-y-auto" id="table-render">
                    @include('admin.billing/table')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
