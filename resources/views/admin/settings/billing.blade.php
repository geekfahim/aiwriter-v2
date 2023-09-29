@extends('admin.layout')
@section('content')
<!-- Page content -->
<div class="content">
    <div class="main-header position-sticky top-0">
        <div class="row">
            <div class="col-md-6">
                <h3>{{ __('Settings') }}</h3>
                <p class="mt-2 text-capitalize"><span class="text-grey">{{ __('common.dashboard') }}</span> <i class="fa fa-angle-right fa-fw"></i> {{ __('settings') }}</p>
            </div>
            <div class="col-md-6">
                
            </div>
        </div>
    </div>
    <div class="main-body">
        <div class="row">
            <div class="col-md-3">
                <div class="card ml-4 mt-6 menu-list border-0 rounded position-sticky top-125">
                    @include('admin.settings.nav')
                </div>        
            </div>
            <div class="col-md-9">
                <div class="card mt-6 mr-10 border-0 p-4 mb-4">
                    <form method="POST" class="js-add-form" action="{{ url('admin/settings/billing-info') }}">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="mb-0">{{ __('Vendor Name') }}</h6>
                                    <small class="text-muted">{{ __('Organization name as shown in invoices.') }}</small>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group mb-3">
                                        <input type="text" value="{{ Helper::config('billing_vendor') }}" class="form-control" name="billing_vendor" aria-describedby="name" placeholder="{{ __('Company Name') }}">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="mb-0">{{ __('Invoice Prefix') }}</h6>
                                    <small class="text-muted">{{ __('Add preferred prefix for your invoices.') }}</small>
                                </div>
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-4">
                                            <label class="small">{{ __('Invoice Prefix') }}</label>
                                            <input type="text" name="billing_invoice_prefix" class="form-control" placeholder="Invoice Prefix" value="{{ Helper::config('billing_invoice_prefix') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="mb-0">{{ __('Contact Details') }}</h6>
                                    <small class="text-muted">{{ __('Contact details for invoices.') }}</small>
                                </div>
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="form-group col-md-6 mb-3">
                                            <label class="small">{{ __('Phone 1') }}</label>
                                            <input type="text" class="form-control" name="billing_phone_1" value="{{ Helper::config('billing_phone_1') }}">
                                        </div>
                                        <div class="form-group col-md-6 mb-3">
                                            <label class="small">{{ __('Phone 2') }}</label>
                                            <input type="text" class="form-control" name="billing_phone_2" value="{{ Helper::config('billing_phone_2') }}">
                                        </div>
                                        <div class="form-group col-md-12 mb-3">
                                            <label class="small">{{ __('Address') }}</label>
                                            <input type="text" class="form-control" name="billing_address" value="{{ Helper::config('billing_address') }}">
                                        </div>
                                        <div class="form-group col-md-12 mb-3">
                                            <label class="small">{{ __('City') }}</label>
                                            <input type="text" class="form-control" name="billing_city" value="{{ Helper::config('billing_city') }}">
                                        </div>
                                        <div class="form-group col-md-6 mb-3">
                                            <label class="small">{{ __('State') }}</label>
                                            <input type="text" class="form-control" name="billing_state" value="{{ Helper::config('billing_state') }}">
                                        </div>
                                        <div class="form-group col-md-6 mb-3">
                                            <label class="small">{{ __('Postal Code') }}</label>
                                            <input type="text" class="form-control" name="billing_postal_code" value="{{ Helper::config('billing_postal_code') }}">
                                        </div>
                                        <div class="form-group col-md-12 mb-3">
                                            <label class="small">{{ __('Country') }}</label>
                                            <input type="text" class="form-control" name="billing_country" value="{{ Helper::config('billing_country') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="mb-0">{{ __('Tax Details') }}</h6>
                                    <small class="text-muted">{{ __('Your tax registration number for invoices.') }}</small>
                                </div>
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-3">
                                            <label class="small">{{ __('Tax Number') }}</label>
                                            <input type="text" class="form-control" name="billing_tax_number" value="{{ Helper::config('billing_tax_number') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div>
                                <button type="submit" class="btn btn-primary float-end mr-2">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>       
             </div>
        </div>
    </div>
</div>
@endsection
