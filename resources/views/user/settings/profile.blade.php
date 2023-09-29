@extends('user.layout')
@section('content')
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
            <h4 class="text-underline">{{ __('common.my_profile') }}</h4>
          </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-9">
            <form action="{{ url('settings') }}" method="POST" class="js-submit-form">
                @csrf
                <div class="row">
                    <div class="form-group col-md-4 mb-4">
                        <label class="small">{{ __('common.first_name') }}</label>
                        <input type="text" class="form-control form-control-sm form-control-shadow" name="first_name" value="{{ auth()->user()->first_name }}">
                    </div>
                    <div class="form-group col-md-4 mb-4">
                        <label class="small">{{ __('common.last_name') }}</label>
                        <input type="text" class="form-control form-control-sm form-control-shadow" name="last_name" value="{{ auth()->user()->last_name }}">
                    </div>
                    <div class="form-group col-md-8 mb-4">
                        <label class="small">{{ __('common.email') }}</label>
                        <input type="text" class="form-control form-control-sm form-control-shadow" name="email" value="{{ auth()->user()->email }}">
                    </div>
                </div>
                <hr class="col-md-8">
                <h5>{{ __('common.change_password') }}</h5>
                <div class="row">
                    <div class="form-group col-md-4 mb-4">
                        <label class="small">{{ __('common.old_password') }}</label>
                        <input type="password" class="form-control form-control-sm form-control-shadow" name="old_password" value="" autocomplete="off">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4 mb-4">
                        <label class="small">{{ __('common.new_password') }}</label>
                        <input type="password" class="form-control form-control-sm form-control-shadow" name="password" value="" autocomplete="off">
                    </div>
                    <div class="form-group col-md-4 mb-4">
                        <label class="small">{{ __('common.confirm_password') }}</label>
                        <input type="password" class="form-control form-control-sm form-control-shadow" name="password_confirmation" value="" autocomplete="off">
                    </div>
                </div>
                <button type="submit" class="btn btn-sm btn-dark">{{ __('common.save_changes') }}</button>
                <hr class="col-md-8">
            </form>
        </div>
    </div>
</div>
@endsection