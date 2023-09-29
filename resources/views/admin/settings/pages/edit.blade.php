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
                <div class="card border-0 mt-6">
                    <div class="card-body">
                        <form method="post" action="{{ url('admin/settings/pages/edit/'.$page->id) }}" class="js-edit-template">
                            @csrf
                            <div class="col-md-12 row">
                                <div class="col-md-6">
                                    <h5 class="mt-2">{{ $page->title }}</h5>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-sm btn-secondary float-end">{{ __('Save') }}</button>
                                    <a href="{{ url('admin/settings/pages') }}" class="btn btn-sm btn-primary float-end me-2">{{ __('Back') }}</a>
                                    <button type="button" data-url="{{ url('admin/settings/pages/reset/'.$page->id) }}" data-message="{{ __('Are you sure you want to reset this content? All your changes will be lost.') }}" class="btn btn-sm btn-secondary float-end me-2 js-reset-content">{{ __('Reset Content') }}</button>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group col-md-12 mt-4">
                                <textarea id="summernotex" name="body">{{ $page->content }}</textarea>
                            </div>
                        </form>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>
@endsection
