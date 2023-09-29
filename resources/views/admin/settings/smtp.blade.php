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
                <div class="card mt-6 mr-10 border-0 p-4">
                    <form method="POST" class="js-add-form" action="{{ url('admin/settings/smtp') }}">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="mb-0">{{ __('Email Config') }}</h6>
                                    <small class="text-muted">{{ __('Configure your email settings.') }}</small>
                                </div>
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-3">
                                            <label class="small">{{ __('Method') }}</label>
                                            <select name="email_method" class="form-control">
                                                <option value="smtp" data-value="smtp-details" {{ Helper::config('email_method') == 'smtp' ? 'selected' : '' }}>{{ __('SMTP') }}</option>
                                                <option value="api" data-value="email-api-details" {{ Helper::config('email_method') == 'api' ? 'selected' : '' }}>{{ __('API') }}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 method-config smtp-details  {{ Helper::config('email_method') == 'smtp' ? '' : 'd-none' }}">
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-3">
                                                    <label class="small">{{ __('Host') }}</label>
                                                    <input type="text" class="form-control" name="smtp_host" value="{{ Helper::config('smtp_host') }}">
                                                </div>
                                                <div class="form-group col-md-3 mb-3">
                                                    <label class="small">{{ __('Port') }}</label>
                                                    <input type="text" class="form-control" name="smtp_port" value="{{ Helper::config('smtp_port') }}">
                                                </div>
                                                <div class="form-group col-md-3 mb-3">
                                                    <label class="small">{{ __('Encryption') }}</label>
                                                    <select name="smtp_encryption" class="form-control">
                                                        <option value="SSL" {{ Helper::config('smtp_encryption') == 'SSL' ? 'selected' : '' }}>{{ __('SSL') }}</option>
                                                        <option value="TLS" {{ Helper::config('smtp_encryption') == 'TLS' ? 'selected' : '' }}>{{ __('TLS') }}</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6 mb-3">
                                                    <label class="small">{{ __('Username') }}</label>
                                                    <input type="text" class="form-control" name="smtp_username" value="{{ Helper::config('smtp_username') }}">
                                                </div>
                                                <div class="form-group col-md-6 mb-3">
                                                    <label class="small">{{ __('Password') }}</label>
                                                    <input type="password" class="form-control" name="smtp_password" value="{{ Helper::config('smtp_password') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 method-config email-api-details {{ Helper::config('email_method') == 'api' ? '' : 'd-none' }}">
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-3">
                                                    <label class="small">{{ __('Email Provider') }}</label>
                                                    <select name="email_provider" class="form-control">
                                                        <option value="SendGrid" {{ Helper::config('email_provider') == 'SendGrid' ? 'selected' : '' }}>{{ __('SendGrid') }}</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6 mb-3">
                                                    <label class="small">{{ __('API Key') }}</label>
                                                    <input type="password" class="form-control" name="email_provider_api_key" value="{{ Helper::config('email_provider_api_key') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6 mb-3">
                                            <label class="small">{{ __('Sender\'s Name') }}</label>
                                            <input type="text" class="form-control" name="smtp_sender_name" value="{{ Helper::config('smtp_sender_name') }}">
                                        </div>
                                        <div class="form-group col-md-6 mb-3">
                                            <label class="small">{{ __('Sender\'s Email Address') }}</label>
                                            <input type="email" class="form-control" name="smtp_sender_email" value="{{ Helper::config('smtp_sender_email') }}">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <div class="form-check form-switch mb-4">
                                                <input type="hidden" name="smtp_email_active" value="0">
                                                <input type="checkbox" class="form-check-input" name="smtp_email_active" value="1" id="activateEmailCheckbox" {{ Helper::config('smtp_email_active') == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="activateEmailCheckbox">{{ __('Activate email') }}</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12 mb-3">
                                            <div class="form-check form-switch mb-4">
                                                <input type="hidden" name="verify_email" value="0">
                                                <input type="checkbox" class="form-check-input" name="verify_email" value="1" id="verifyEmailCheckbox" {{ Helper::config('verify_email') == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="verifyEmailCheckbox">{{ __('Require email verification for new accounts.') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div>
                                <button type="submit" class="btn btn-primary float-end mr-2">{{ __('Save') }}</button>
                                <button type="button" class="btn btn-secondary float-end me-3" data-bs-toggle="modal" data-bs-target="#emailModal">{{ __('Send test email') }}</button>
                            </div>
                        </div>
                    </form>
                </div>       
             </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Send Test Email</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ url('admin/settings/test-email') }}" class="send-test-email">
            @csrf
            <div class="modal-body">
                <div class="form-group col-md-12 mb-3">
                    <label class="small">{{ __('Email Address') }}</label>
                    <input type="text" class="form-control" name="email" value="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-email-send" data-loading="{{ __('Sending email') }}" data-loaded="{{ __('Send email') }}">{{ __('Send email') }}</button>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection
