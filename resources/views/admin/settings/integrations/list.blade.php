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
                <div class="row mt-6">
                    @foreach ($rows as $row)
                    <div class="col-sm-4">
                        <div class="card mb-3">
                            <div class="card-body p-0">
                                <div class="p-2">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="api-main-details">
                                                <div class="api-logo">
                                                    <img class="float-left integrations-logo" src="{{ asset('images/brands/'.$row->logo) }}">
                                                </div>
                                                <span class="ml-2">{{ $row->name }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <form method="POST" action="{{ url('admin/settings/integrations/'.$row->id.'/status') }}">
                                                @csrf
                                                <div class="form-check form-switch form-switch-lg mb-3 pr-5 float-right">
                                                    <input type="hidden" name="status" value="0">
                                                    <input type="checkbox" name="status" value="1" class="form-check-input js-status-change" id="customSwitch<?=$row->id?>" <?=$row->status == 1 ? 'checked' : ''?>>
                                                    <label class="custom-control-label" for="customSwitch<?=$row->id?>"></label>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mt-2">
                                                <small>{{ $row->description }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-top p-2">
                                    <a href="javascript:void()" class="float-right text-dark small pb-2 viewModal" data-url="{{ url('admin/settings/integrations/'.$row->id) }}">{{ __('View Integration') }}</a>
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
<div class="js-add-view"></div>
@endsection
