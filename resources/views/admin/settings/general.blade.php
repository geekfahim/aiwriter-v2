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
                    <form method="POST" class="js-add-form" action="{{ url('admin/settings/general') }}">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="mb-0">{{ __('Company Name') }}</h6>
                                    <small class="text-muted">{{ __('Your organization name.') }}</small>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group mb-3">
                                        <input type="text" value="{{ Helper::config('company_name') }}" class="form-control" name="company_name" aria-describedby="name" placeholder="{{ __('Company Name') }}">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="mb-0">{{ __('Global Preferences') }}</h6>
                                    <small class="text-muted">{{ __('Site wide preferences.') }}</small>
                                </div>
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-3">
                                            <label class="small">{{ __('Timezone') }}</label>
                                            <select name="timezone" class="form-control">
                                                @foreach ($timezones as $timezone)
                                                    <option value="{{ $timezone }}" {{ Helper::config('timezone') == $timezone ? 'selected' : '' }}>{{ $timezone }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 mb-3">
                                            <label class="small">{{ __('Date Format') }}</label>
                                            <select class="form-control" name="date_format">
                                                <option value="" selected="" disabled="" hidden="">{{ __('Select') }}</option>
                                                <option value="m/d/y" {{ Helper::config('date_format') == 'm/d/y' ? 'selected' : '' }}>{{ date('m/d/y') }}</option>
                                                <option value="Y-m-d" {{ Helper::config('date_format') == 'Y-m-d' ? 'selected' : '' }}>{{ date('Y-m-d') }}</option>
                                                <option value="d-M-y" {{ Helper::config('date_format') == 'd-M-y' ? 'selected' : '' }}>{{ date('d-M-y') }}</option>
                                                <option value="F jS, Y" {{ Helper::config('date_format') == 'F jS, Y' ? 'selected' : '' }}>{{ date('F jS, Y') }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 mb-3">
                                            <label class="small">{{ __('Time Format') }}</label>
                                            <select class="form-control" name="time_format">
                                                <option value="" selected="" disabled="" hidden="">{{ __('Select') }}</option>
                                                <option value="h:i a" {{ Helper::config('time_format') == 'h:i a' ? 'selected' : '' }}>{{ __('12hr format') }} (01:03 pm)</option>
                                                <option value="H:i" {{ Helper::config('time_format') == 'H:i' ? 'selected' : '' }}>{{ __('24hr format') }} (13:03)</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 mb-3">
                                            <label class="small">{{ __('Currency') }}</label>
                                            <select name="currency" class="form-control">
                                                @foreach(config('currencies.all') as $key => $value)
                                                    <option value="{{ $key }}" {{ Helper::config('currency') == $key ? 'selected' : '' }}>{{ $key }} - {{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="mb-0">{{ __('Trial Period') }}</h6>
                                    <small class="text-muted">{{ __('User trial period from when they first signup.') }}</small>
                                </div>
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="form-group col-md-6 mb-3">
                                            <label class="small">{{ __('Trial Period') }}</label>
                                            <div class="input-group mb-3">
                                                <input type="text" name="trial_period" class="form-control" placeholder="1" value="{{ Helper::config('trial_period') }}">
                                                <span class="input-group-text" id="basic-addon2">{{ __('Days') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6 mb-3">
                                            <label class="small">{{ __('Word Limit') }}</label>
                                            <input type="text" name="trial_word_limit" class="form-control" value="{{ Helper::config('trial_word_limit') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="mb-0">{{ __('Google Analytics') }}</h6>
                                    <small class="text-muted">{{ __('Track website data analysis.') }}</small>
                                </div>
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-4">
                                            <label class="small">{{ __('Google Analytics Tracking ID') }}</label>
                                            <input type="text" name="google_analytics_tracking_id" class="form-control" placeholder="Tracking ID" value="{{ Helper::config('google_analytics_tracking_id') }}">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <div class="form-check form-switch mb-4">
                                                <input type="hidden" name="google_analytics_status" value="0">
                                                <input type="checkbox" class="form-check-input" name="google_analytics_status" value="1" id="formSwitch1" {{ Helper::config('google_analytics_status') == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="formSwitch1">Enable Google Analytics</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="mb-0">{{ __('Google Recaptcha') }}</h6>
                                    <small class="text-muted">{{ __('Protect your site.') }}</small>
                                </div>
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="form-group col-md-6 mb-4">
                                            <label class="small">{{ __('Site Key') }}</label>
                                            <input type="password" name="recaptcha_site_key" class="form-control" placeholder="Site Key" value="{{ Helper::config('recaptcha_site_key') }}">
                                        </div>
                                        <div class="form-group col-md-6 mb-4">
                                            <label class="small">{{ __('Secret Key') }}</label>
                                            <input type="password" name="recaptcha_secret_key" class="form-control" placeholder="Secret Key" value="{{ Helper::config('recaptcha_secret_key') }}">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <div class="form-check form-switch mb-4">
                                                <input type="hidden" name="recaptcha_active" value="0">
                                                <input type="checkbox" class="form-check-input" name="recaptcha_active" value="1" id="formSwitch2" {{ Helper::config('recaptcha_active') == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="formSwitch1">Enable Recaptcha</label>
                                            </div>
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
                <div class="card mt-6 mr-10 border-0 p-4 mb-4">
                    <form method="POST" class="js-add-form" action="{{ url('admin/settings/contacts') }}">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="mb-0">{{ __('Phone') }}</h6>
                                    <small class="text-muted">{{ __('Organization\'s phone contacts.') }}</small>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group mb-3">
                                        <input type="text" value="{{ Helper::config('phone') }}" class="form-control" name="phone" aria-describedby="name" placeholder="{{ __('Phone') }}">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="mb-0">{{ __('Email') }}</h6>
                                    <small class="text-muted">{{ __('Organization\'s email address.') }}</small>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group mb-3">
                                        <input type="text" value="{{ Helper::config('email') }}" class="form-control" name="email" aria-describedby="name" placeholder="{{ __('Email') }}">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="mb-0">{{ __('Address') }}</h6>
                                    <small class="text-muted">{{ __('Your organization address.') }}</small>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group mb-3">
                                        <textarea name="address" class="form-control" cols="30" rows="5">{{ Helper::config('address') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="mb-0">{{ __('Facebook') }}</h6>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group mb-3">
                                        <input type="text" value="{{ Helper::config('socials') != NULL ? unserialize(Helper::config('socials'))['facebook'] : '' ; }}" class="form-control" name="socials[facebook]" aria-describedby="name">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="mb-0">{{ __('Twitter') }}</h6>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group mb-3">
                                        <input type="text" value="{{ Helper::config('socials') != NULL ? unserialize(Helper::config('socials'))['twitter'] : '' ; }}" class="form-control" name="socials[twitter]" aria-describedby="name">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="mb-0">{{ __('Instagram') }}</h6>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group mb-3">
                                        <input type="text" value="{{ Helper::config('socials') != NULL ? unserialize(Helper::config('socials'))['instagram'] : '' ; }}" class="form-control" name="socials[instagram]" aria-describedby="name">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="mb-0">{{ __('Slack') }}</h6>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group mb-3">
                                        <input type="text" value="{{ Helper::config('socials') != NULL ? unserialize(Helper::config('socials'))['slack'] : '' ; }}" class="form-control" name="socials[slack]" aria-describedby="name">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="mb-0">{{ __('LinkedIn') }}</h6>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group mb-3">
                                        <input type="text" value="{{ Helper::config('socials') != NULL ? unserialize(Helper::config('socials'))['linkedin'] : '' ; }}" class="form-control" name="socials[linkedin]" aria-describedby="name">
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
                <div class="card mt-6 mr-10 border-0 p-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h6 class="mb-0">{{ __('Logo') }}</h6>
                                <small>{{ __('Add logo and favicon.') }}</small>
                            </div>
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <form method="post" class="js-upload-logo-form" action="{{ url('admin/settings/upload/logo') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    @if (Helper::config('logo'))
                                                    <div class="logo-c90">
                                                        <img src="{{ asset('uploads/brand/' . Helper::config('logo')) }}" class="file-img">
                                                    </div>
                                                    @else
                                                    <h5 class="text-dark mb-0 ps-3 border-dashed mt-2">{{ __('Logo') }}</h5>  
                                                    @endif
                                                    <input type="file" class="d-none js-logo-upload js-file-upload" data-form="js-upload-logo-form" name="image"/>
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="button" class="btn btn-sm btn-primary float-right mr-2" data-target="logo-img" data-form="js-upload-logo-form" onclick="$('.js-logo-upload').click();">{{ __('Upload') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-12">
                                        <form method="post" class="js-upload-favicon-form" action="{{ url('admin/settings/upload/favicon') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    @if (Helper::config('favicon'))
                                                    <img src="{{ asset('uploads/brand/' . Helper::config('favicon')) }}" class="file-img favicon-c90">
                                                    @else
                                                    <h5 class="text-dark mb-0 ps-3 border-dashed mt-2">{{ __('Favicon') }}</h5>  
                                                    @endif
                                                    <input type="file" class="d-none js-favicon-upload js-file-upload" data-form="js-upload-favicon-form" name="image"/>
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="button" class="btn btn-sm btn-primary float-right mr-2" data-form="js-upload-favicon-form" onclick="$('.js-favicon-upload').click();">{{ __('Upload') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>       
             </div>
        </div>
    </div>
</div>
@endsection
